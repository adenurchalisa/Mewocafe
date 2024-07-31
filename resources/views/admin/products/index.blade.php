@extends('layouts.app', ['title' => 'Products - MeowCafe'])

@section('content')
    <main class="p-7 bg-backgroundPrimary min-h-screen w-full mt-[70px]">
        <div class="flex items-center justify-between">
            <p class="text-3xl font-bold">Products</p>
            <a href="/products/create"
                class="inline-flex justify-center h-full py-3 text-base font-bold text-white rounded-md bg-primary w-36">
                <p class="-mb-[2px]">Add</p>
            </a>
        </div>
        <div class="bg-white border mt-7 border-borderPrimary rounded-xl">
            <table class="w-full table-fixed">
                <thead class="text-left">
                    <tr class="border-b border-borderPrimary">
                        <th class="w-2/12 py-4 text-center">Image</th>
                        <th class="w-3/12">Product Name</th>
                        <th class="w-3/12">Category</th>
                        <th class="w-3/12">Price</th>
                        <th class="w-3/12">Stock</th>
                        <th class="w-2/12">Action</th>
                    </tr>
                </thead>
                <tbody class="table-row-group font-semibold">
                    @foreach ($products as $product)
                    <tr class="border-b border-b-bordeborder-borderPrimary">
                        <td class="flex justify-center py-6">
                            <div class="overflow-hidden rounded-xl">
                                <img src="{{ asset('storage/images/products/'.$product->image) }}" alt="" width="130" />
                            </div>
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ Str::ucfirst($product->category->name)  }}</td>
                        <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td class="h-full">
                            <div class="inline-flex rounded-lg bg-[#FAFBFD] border border-borderPrimary">
                                <a href="/products/{{ $product->id }}/edit" class="px-4 py-2 text-black">
                                    <i class="ri-edit-box-line"></i>
                                </a>
                                <div class="w-[1px] bg-bordeborder-borderPrimary h-10"></div>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 text-red-500">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>

            {{-- Menampilkan Previous/Next Pagination --}}
            <div class=mt-5>
                {{ $products->links() }}
            </div>
            </main>
@endsection
