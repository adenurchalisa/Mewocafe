<?php

namespace App\Http\Controllers\API\Public;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\MetaPaginateResource;

class PublicController extends Controller
{
    public function productCount()
    {
        $data = [
            'status' => true,
            'message' => 'Get Data Product Count Success',
            'data' => [
                'foodCount' => $this->getProductCount('food'),
                'drinkCount' => $this->getProductCount('drink'),
            ],
        ];

        return response()->json($data, 200);
    }

    public function food()
    {
        return $this->getProductsByCategory('food', 'Get Data Product Food Success');
    }

    public function drink()
    {
        return $this->getProductsByCategory('drink', 'Get Data Product Drink Success');
    }

    private function getProductCount($category)
    {
        return Product::whereHas('category', function ($query) use ($category) {
            $query->where('name', $category);
        })->count();
    }

    private function getProductsByCategory($category, $message)
    {
        $products = Product::whereHas('category', function ($query) use ($category) {
            $query->where('name', $category);
        })->paginate(6);

        $data = [
            'status' => true,
            'message' => $message,
            'meta' => new MetaPaginateResource($products),
            'data' => ProductResource::collection($products),
        ];

        return response()->json($data, 200);
    }

    public function createOrder(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        try {
            DB::transaction(function () use ($request, $product) {
                if ($product->stock > 0) {

                    $transactionId = 'ORD' . now()->format('Ymd') . '_' . \Illuminate\Support\Str::random(8);

                    Order::create([
                        'product_id' => $product->id,
                        'transaction_id' => $transactionId,
                        'payment_status' => 'processing',
                    ]);

                    $product->decrement('stock', 1);
                }
            });

            $data = [
                'status' => 'success',
                'message' => 'Order Product!',
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
}
