<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $data = [
            'status' => true,
            'message' => 'Show All Category Success',
            'data' => CategoryResource::collection($categories),
        ];

        return response()->json($data, 200);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        $data = [
            'status' => true,
            'message' => 'Show Category By Id Success',
            'data' => new CategoryResource($category)
        ];

        return response()->json($data, 200);
    }
}
