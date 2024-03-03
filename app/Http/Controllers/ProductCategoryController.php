<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductCategoryController extends BaseController
{
    public function index(ProductCategoryRequest $request): JsonResponse
    {
        dd($request);
    }
}