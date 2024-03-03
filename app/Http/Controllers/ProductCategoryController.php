<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ProductCategoryRequest;
use App\Http\Resources\ProductCategoryResource;

class ProductCategoryController extends BaseController
{
    public function create(ProductCategoryRequest $request): JsonResponse
    {
        $product = ProductCategory::create($request->validated());

        return $this->sendResponse($product, "Product Category Created Successfully!", Response::HTTP_CREATED);
    }

    public function show(ProductCategory $category): JsonResponse
    {
        return $this->sendResponse(new ProductCategoryResource($category), "Product Category Retrieved Successfully!");
    }

    public function update(ProductCategoryRequest $request, ProductCategory $category): JsonResponse
    {
        $category->update($request->validated());

        return $this->sendResponse($category, "Product Category has been updated successfully");
    }

    public function destroy(ProductCategory $category): JsonResponse
    {
        $category->delete();

        return $this->sendResponse([], "Product Category has been deleted successfully");
    }
}