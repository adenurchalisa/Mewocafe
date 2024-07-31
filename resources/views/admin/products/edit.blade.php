@extends('layouts.app', ['title' => 'Edit Product - MeowCafe'])


@section('content')
    <main class="p-7 bg-backgroundPrimary min-h-screen w-full mt-[70px]">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('products.index') }}" class="px-4 text-[30px]">←</a>
                <p class="text-3xl font-bold">Edit Products</p>
            </div>
            <div class="flex gap-2">
                <button type="submit" form="formEdit"
                    class="inline-flex justify-center h-full py-3 text-base font-bold text-white rounded-md bg-primary w-36">
                    <p class="-mb-[2px]">Save</p>
                </button>
                <form  action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex justify-center h-full py-3 text-base font-bold text-white bg-red-500 rounded-md w-36">
                        <p class="-mb-[2px]">Delete</p>
                    </button>
                </form>
            </div>
        </div>

        <form id="formEdit" method="post" action="{{ route('products.update', $product->id) }}"
            enctype="multipart/form-data" class="grid grid-cols-5 font-semibold mt-7 gap-x-8 text-md">
            @csrf
            @method('PUT')
            <div class="flex flex-col col-span-3 gap-6 px-8 py-6 bg-white border rounded-lg border-borderPrimary">
                <div class="flex flex-col gap-3">
                    <label for="product_name">Product Name</label>
                    <input type="text" id="name" name="name" value="{{ $product->name }}"
                        placeholder="Input product name"
                        class="px-5 py-2 border rounded-md border-borderPrimary bg-backgroundPrimary" />
                    @error('name')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <fieldset class="flex flex-col gap-3">
                        <p>Category</p>
                        <div class="flex gap-1">
                            @foreach ($categories as $category)
                                <div>
                                    <input type="radio" name="category_id" id="{{ $category->name }}" class="hidden peer"
                                        value="{{ $category->id }}" @if ($product->category_id === $category->id) checked @endif />
                                    <label role="button" for="{{ $category->name }}" tabindex="0"
                                        class="peer-checked:text-white bg-[#D9D9D9] peer-checked:bg-primary px-6 py-2 text-base rounded-md">
                                        {{ Str::ucfirst($category->name) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('category')
                            <div>
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            </div>
                        @enderror
                    </fieldset>
                </div>
                <div class="flex flex-col gap-3">
                    <label for="price">Price</label>
                    <input type="text" id="price" name="price" value="{{ $product->price }}"
                        placeholder="Input price"
                        class="px-5 py-2 border rounded-md border-borderPrimary bg-backgroundPrimary" />
                    @error('price')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-3">
                    <label for="stock">Stock</label>
                    <input type="text" id="stock" name="stock" value="{{ $product->stock }}"
                        placeholder="Input stock"
                        class="px-5 py-2 border rounded-md border-borderPrimary bg-backgroundPrimary" />
                    @error('stock')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <section class="col-span-2 py-6 bg-white border rounded-lg h-fit border-borderPrimary">
                <p class="px-8 text-lg font-bold">Product Image</p>
                <div class="h-[1px] border-b border-b-borderPrimary w-full my-4"></div>
                <div class="px-4">
                    <label for="image-upload" id="drag-area"
                        class="w-full h-[280px] bg-backgroundPrimary border-2 border-[#D9D9D9] border-dashed rounded-lg overflow-hidden cursor-pointer flex justify-center items-center">
                        <input id="image-upload" name="image" value="{{ $product->image }}" type="file" hidden
                            accept="image/*" />
                        <div id="image-viewer"
                            class="flex flex-col items-center justify-center w-full h-full bg-center bg-no-repeat bg-cover">
                            <img src="{{ asset('storage/images/products/' . $product->image) }}" alt="" />
                            <p class="text-[18px]">
                                Tarik dan lepas atau
                                <span class="text-primary">pilih gambar</span>
                            </p>
                            <p class="text-base text-black/25">
                                Mendukung JPG, JPEG, dan PNG
                            </p>
                        </div>
                    </label>
                </div>
            </section>
        </form>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/imageUploader.js') }}"></script>
    <script>
        var productCategory = "<?php echo $product->category->name; ?>";
        if (productCategory === 'food' || productCategory === 'drink') {
            document.getElementById(productCategory).checked = true;
        }
    </script>
@endpush
