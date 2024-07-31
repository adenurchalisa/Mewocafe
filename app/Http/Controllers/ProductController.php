<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = \App\Models\Product::query();

        if ($search = request()->get('search')) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('price', 'LIKE', "%{$search}%")
                  ->orWhere('stock', 'LIKe', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search){
                    $q->where('name', 'LIKE', "%{$search}%"); 
                  });
        }

        // Menampilkan semua product dengan menggunakan pagination
        $products = $query->paginate(7)->withQueryString();


        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'category_id' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar dan simpan path-nya
        $imagePath = $request->file('image')->store('images/products', 'public');
        $imageFileName = basename($imagePath);

        \App\Models\Product::create([
            'name' => $validatedData['name'],
            'category_id' => $validatedData['category_id'],
        'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'image' => $imageFileName,
        ]);


        Alert::success('Successful!', 'Product created successfully.');
        return redirect()->route('products.index');
        // return redirect()->route('products.index')->with('alert-success', 'Product created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = \App\Models\Category::all();

        $product = \App\Models\Product::findOrFail($id);
        return view('admin.products.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'category_id' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            \Illuminate\Support\Facades\Storage::delete('public/images/products/' . $product->image);
            $imagePath = $request->file('image')->store('images/products', 'public');
            $imageFileName = basename($imagePath);
            $validatedData['image'] = $imageFileName;
        }

        $product->update($validatedData);

        Alert::success('Successful!', 'Product updated successfully.');
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        \Illuminate\Support\Facades\Storage::delete('public/images/products/' . $product->image);
        $product->delete();

        Alert::success('Successful!', 'Product has been deleted successfully.');
        return redirect()->route('products.index');
    }
}
