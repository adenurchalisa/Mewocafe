<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Category;

class DashboardController extends Controller
{
    public function salesOverview()
    {
        $totalOrders = $this->getTotalOrders();
        $totalFoodOrders = $this->getTotalCategoryOrders('food');
        $totalDrinkOrders = $this->getTotalCategoryOrders('drink');
        $totalIncome = $this->getTotalIncome();

        $data = [
            'status' => 'success',
            'message' => 'Sales overview data retrieved successfully',
            'data' => [
                'totalOrders' => $totalOrders,
                'totalFoodOrders' => $totalFoodOrders,
                'totalDrinkOrders' => $totalDrinkOrders,
                'totalIncome' => $totalIncome,
            ], 
        ];

        return response()->json($data, 200);
        
    }

    public function dailySales()
    {
        $salesData = $this->getSalesData();
        $data = [
            'status' => 'success',
            'message' => 'Daily sales data retrieved successfully',
            'data' => $salesData,
        ];

        return response()->json($data, 200);
    }

    private function getTotalOrders()
    {
        return Order::where('payment_status', 'completed')->count();
    }

    private function getTotalCategoryOrders($categoryName)
    {
        $category = Category::where('name', $categoryName)->first();
        if ($category) {
            return Order::whereHas('product', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })->where('payment_status', 'completed')->count();
        }
        return 0;
    }

    private function getTotalIncome()
    {
        return Order::where('payment_status', 'completed')
            ->whereHas('product')
            ->get()
            ->sum(function ($order) {
                return $order->product->price;
            });
    }

    private function getSalesData()
    {
        $salesData = Order::select(
            DB::raw('DAY(created_at) as day'),
            DB::raw('count(*) as total')
        )
            ->where('payment_status', 'completed')
            ->groupBy(DB::raw('DAY(created_at)'))
            ->pluck('total', 'day')
            ->toArray();

        $sales = [];
        $currentDate = Carbon::now();
        $daysInMonth = $currentDate->daysInMonth;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $sales[$i] = $salesData[$i] ?? 0;
        }

        return $sales;
    }
}
