<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductValidation;

class ProductController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        $products = [];
        $user = auth()->user();

        if($request->query('limit'))
        {
            $products = Product::where('user_id', $user->id)->paginate((int) $request->query('limit'));

            return $this->sendResponse($products, "Products Retreived Successfully");
        }

        $products = Product::where('user_id', $user->id)->get();

        return $this->sendResponse($products, "Products Retreived Successfully");

    }

    public function create(ProductValidation $request): JsonResponse
    {
        if($this->checkIfCategoryExist($request->product_category_id))
        {
            $product = Product::create(array_merge($request->validated(), [
                'user_id' => auth()->user()->id,
            ]));
            
            return $this->sendResponse(new ProductResource($product), "Product Created Successfully", Response::HTTP_CREATED);
        }else{
            return $this->sendError([], "The selected product category id does not exist");
        }
    }

    public function show(Product $product): JsonResponse
    {
        if($product->user_id !== auth()->user()->id) abort(Response::HTTP_FORBIDDEN, "you do not have permission to this resource");
        
        return $this->sendResponse(new ProductResource($product), "Product Retrieved Successfully!");
    }

    public function update(ProductValidation $request, Product $product): JsonResponse
    {
        
        if($product->user_id !== auth()->user()->id) abort(Response::HTTP_FORBIDDEN, "you do not have permission to this resource");
        
        if($this->checkIfCategoryExist($request->product_category_id))
        {
            $product->update($request->validated());

        }else{
            return $this->sendError([], "The selected product category id does not exist");
        }
        
        return $this->sendResponse([], "Product Edited Successfully");
    }

    public function destroy(Product $product): Jsonresponse
    {
        if($product->user_id !== auth()->user()->id) abort(Response::HTTP_FORBIDDEN, "you do not have permission to this resource");

        $product->delete();

        return $this->sendResponse([], "Product deleted successfully!");
    }
}