<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends BaseApiController
{
    public function allCategory()
    {
        try {
            $categories = Category::all();
            return response()->json([
                'status' => true,
                'data' => ['categories' => $categories]
            ], 201);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
