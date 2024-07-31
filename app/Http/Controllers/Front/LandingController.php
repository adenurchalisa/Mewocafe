<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Alert;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'Food'); // Default ke 'Food' jika tidak ada kategori yang diberikan

        $products = Product::whereHas('category', function ($query) use ($category) {
            $query->where('name', $category);
        })->paginate(6);

        $foodCount = Product::whereHas('category', function ($query) {
            $query->where('name', 'Food');
        })->count();

        $drinkCount = Product::whereHas('category', function ($query) {
            $query->where('name', 'Drink');
        })->count();

        return view('landing.food', compact('products', 'foodCount', 'drinkCount', 'category'));
    }

    

    public function createOrder(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
    
        // Mulai transaksi database
        DB::transaction(function () use ($request, $product) {
            // Dapatkan produk yang dipesan

            // Periksa stok produk
            if ($product->stock > 0) {

                // But ID Transaksi
                $transactionId = 'ORD' . now()->format('Ymd') . '_' . \Illuminate\Support\Str::random(8);

                // Buat order baru
                Order::create([
                    'product_id' => $product->id,
                    'transaction_id' => $transactionId,
                    'payment_status' => 'processing',
                ]);

                // Kurangi stok produk
                $product->decrement('stock', 1);

                // Redirect dengan pesan sukses
                Alert::success('Order Successful!', 'Your order has been placed successfully!');
                return redirect()->back();
            } else {
                // Jika stok tidak mencukupi, kembalikan dengan pesan error
                Alert::error('Order Failed!', 'Sorry, the product stock is not enough.');
                return redirect()->back();
            }
        });

        // Redirect jika ada masalah
        return redirect()->back()->with('error', 'Failed to place order.');
    }
}
