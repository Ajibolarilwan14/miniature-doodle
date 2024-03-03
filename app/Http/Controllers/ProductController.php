<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductValidation;

class ProductController extends BaseController
{
    public function index(Request $request)
    {   
        $products = Cache::many(['products']);
        $user = auth()->user();

        if(!is_null($products['products']))
        {

            return $this->sendResponse($products, "Products Retreived Successfully");
        }

            $products = Product::where('user_id', $user->id)->get();
    
            Cache::putMany(['products' => $products], 60);
    
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
        
        $product_cache = Cache::get('product_' . $product->id);

        if(isset($product_cache))
        {
            return $this->sendResponse(new ProductResource($product_cache), "Product Retrieved Successfully!");
        }else{
            Cache::set('product_' . $product->id, $product, 60);
            
            return $this->sendResponse(new ProductResource($product), "Product Retrieved Successfully!");
        }
    }

    public function update(ProductValidation $request, Product $product): JsonResponse
    {
        
        if($product->user_id !== auth()->user()->id) abort(Response::HTTP_FORBIDDEN, "you do not have permission to this resource");
        
        if($this->checkIfCategoryExist($request->product_category_id))
        {
            $product->update($request->validated());

            Cache::delete('product_' . $product->id);

        }else{
            return $this->sendError([], "The selected product category id does not exist");
        }
        
        Cache::set('product_' . $product->id, $product, 60);
        
        return $this->sendResponse([], "Product Edited Successfully");
    }

    public function destroy(Product $product): Jsonresponse
    {
        if($product->user_id !== auth()->user()->id) abort(Response::HTTP_FORBIDDEN, "you do not have permission to this resource");

        Cache::delete('product_' . $product->id);
        
        $product->delete();


        return $this->sendResponse([], "Product deleted successfully!");
    }
}