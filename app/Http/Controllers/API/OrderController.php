<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\MetaPaginateResource;

class OrderController extends Controller
{
    public function index()
    {
        $query = Order::query();

        if ($search = request()->get('search')) {
            $query->where('transaction_id', 'LIKE', "%{$search}%")
                ->orWhere('payment_status', 'LIKE', "%{$search}%")
                ->orWhereHas('product', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        }

        $orders = $query->orderBy('payment_status', 'asc')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        $data = [
            'status' => true,
            'message' => 'Show All Orders Success',
            'meta' => new MetaPaginateResource($orders),
            'data' => OrderResource::collection($orders),
        ];

        return response()->json($data, 200);
    }

    public function completeOrder($id)
    {
        $order = Order::findOrFail($id);

        try {
            $order->payment_status = 'completed';
            $order->save();

            $data = [
                'status' => true,
                'message' => 'Complete Order Success',
                'data' => new OrderResource($order),
            ];

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
