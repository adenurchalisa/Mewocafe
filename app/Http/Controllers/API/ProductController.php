<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MetaPaginateResource;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::query();

        if ($search = request()->get('search')) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('price', 'LIKE', "%{$search}%")
                ->orWhere('stock', 'LIKE', "%{$search}%")
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        }

        $products = $query->paginate(10);

        $data = [
            'status' => true,
            'message' => 'Show All Product Success',
            'meta' => new MetaPaginateResource($products),
            'data' => ProductResource::collection($products),
        ];

        return response()->json($data, 200);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        $data = [
            'status' => true,
            'message' => 'Show Product By Id Success',
            'data' => new ProductResource($product)
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'category_id' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $imagePath = $request->file('image')->store('images/products', 'public');
            $imageFileName = basename($imagePath);
            $product = Product::create([
                'name' => $validatedData['name'],
                'category_id' => $validatedData['category_id'],
                'price' => $validatedData['price'],
                'stock' => $validatedData['stock'],
                'image' => $imageFileName,
            ]);

            $data = [
                'status' => 'success',
                'message' => 'Create Product!',
                'data' => new ProductResource($product),
            ];
            return response()->json($data, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'category_id' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            if ($request->hasFile('image')) {
                Storage::delete('public/images/products/' . $product->image);
                $imagePath = $request->file('image')->store('images/products', 'public');
                $imageFileName = basename($imagePath);
                $validatedData['image'] = $imageFileName;
            }

            $product->update($validatedData);
            $data = [
                'status' => 'success',
                'message' => 'Update Product!',
                'data' => new ProductResource($product),
            ];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th,
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);
        try {
            Storage::delete('public/images/products/' . $product->image);
            $product->delete();

            $data = [
                'status' => 'success',
                'message' => 'Delete Product!',
                'data' => new ProductResource($product),
            ];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th,
            ], 500);
        }
    }
}
