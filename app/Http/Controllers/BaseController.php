<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function sendResponse($data, string $message, int $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function sendError(array $data, string $message, int $code = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function checkIfCategoryExist(int $id)
    {
        $check = ProductCategory::query()
                        ->where('id', $id)
                        ->exists();

        return $check === true;
    }
}