<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalOrders = \App\Models\Order::where('payment_status', 'completed')->count();

        // Menghitung jumlah produk 'food' yang terjual
        $totalFoodOrders = Order::where('payment_status', 'completed')->whereHas('product', function ($query) {
            $query->whereHas('category', function ($query) {
                $query->where('name', 'food');
            });
        })->count();

        // Menghitung jumlah produk 'drink' yang terjual
        $totalDrinkOrders = Order::where('payment_status', 'completed')->whereHas('product', function ($query) {
            $query->whereHas('category', function ($query) {
                $query->where('name', 'drink');
            });
        })->count();

        // Menghitung total penjualan
        $totalIncome = \App\Models\Order::where('payment_status', 'completed')
            ->whereHas('product')
            ->get()
            ->sum(function ($order) {
                return $order->product->price;
            });

        // Menghitung penjualan per hari

        $currentDate = Carbon::now();
        $daysInMonth = $currentDate->daysInMonth;

        // Menghitung penjualan per hari dalam sebulan
        $salesData = Order::where('payment_status', 'completed')
            ->selectRaw('DAY(created_at) as day, COUNT(*) as total')
            ->groupByRaw('DAY(created_at)')
            ->pluck('total', 'day')
            ->toArray();

        $salesInMonth = [];

        // Mengisi data penjualan per hari dalam bulan ini
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $salesInMonth[$i] = $salesData[$i] ?? 0;
        }

        return view('admin.dashboard', compact('totalOrders', 'totalFoodOrders', 'totalDrinkOrders', 'totalIncome', 'salesInMonth'));
    }

    public function checkDashboardUpdates(Request $request)
    {
        $latestOrder = \App\Models\Order::where('payment_status', 'completed')->orderBy('updated_at', 'desc')->first()->updated_at->timestamp ?? 0;
        $lastKnownTimestamp = $request->lastKnownTimestamp;

        $status = $latestOrder > $lastKnownTimestamp;

        return response()->json([
            'status' => $status,
            'message' => $latestOrder > $lastKnownTimestamp ? 'There are new orders.' : 'No orders found.',
            'data' => $status ? $latestOrder : null,
        ]);
    }
}
