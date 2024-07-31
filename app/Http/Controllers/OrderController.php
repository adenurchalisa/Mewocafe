<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Alert;

class OrderController extends Controller
{
    public function index()
    {
        $query = \App\Models\Order::query();

        if ($search = request()->get('search')) {
            $query->where('transaction_id', 'LIKE', "%{$search}%")
                  ->orWhere('payment_status', 'LIKE', "%{$search}%")
                  ->orWhereHas('product', function($q) use ($search){
                    $q->where('name', 'LIKE', "%{$search}%"); 
                  });
        }
    
        $orders = $query->orderBy('payment_status', 'asc')
                        ->orderBy('updated_at', 'desc')
                        ->paginate(9)
                        ->withQueryString();
    
        return view('admin.orders.index', compact('orders'));
    }

    public function complete($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $order->payment_status = 'completed';
        $order->save();

        // Redirect back with success message
        Alert::success('Successful!', 'Order payment status updated to completed.');
        return redirect('/orders');
    }

    public function checkNewOrders(Request $request)
    {
        $latestOrder = \App\Models\Order::orderBy('updated_at', 'desc')->first()->updated_at->timestamp ?? 0;
        $lastKnownTimestamp = $request->lastKnownTimestamp;

        $status = $latestOrder > $lastKnownTimestamp;

        return response()->json([
            'status' => $status,
            'message' => $latestOrder > $lastKnownTimestamp ? 'There are new orders.' : 'No orders found.',
            'data' => $status ? $latestOrder : null,
        ]);
        

    }
}
