<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends BaseController
{
    public function index(): JsonResponse
    {
        return $this->sendResponse([], "it works", Response::HTTP_OK);
    }
}