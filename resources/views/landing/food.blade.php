<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
        @vite('resources/css/admin.css')
		<title>Meow Cafe</title>
		<link
			href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css"
			rel="stylesheet"
		/>
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link
			href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
			rel="stylesheet"
		/>
		<link rel="shortcut icon" href="{{ asset('images/inr.ico') }}" type="image/x-icon" />
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	</head>
	<body>
		<main
			class="py-[75px] px-[70px] bg-backgroundPrimary min-h-screen flex gap-16"
		>
			<div>
				<p class="text-3xl font-bold">
					<span class="text-primary">Meow</span>Cafe
				</p>
				<aside class="min-h-full p-6 mt-6 bg-white w-72 rounded-xl">
					<p class="font-bold">Category</p>
					<div class="flex flex-col mt-4 gap-y-1">
						<a href="{{ route('home', ['category' => 'Food']) }}"
							class="flex justify-between px-4 py-3 {{ request()->get('category') === 'Food' || !request()->has('category') && request()->path() === '/' ? 'font-bold rounded bg-primary/20 text-primary' : 'font-semibold rounded text-textPrimary'}}"
						>
							<div>
								<i class="mr-3 ri-restaurant-line"></i>
								<span>Food</span>
							</div>
							<span class="text-textPrimary/60">{{ $foodCount }}</span>
						</a>
						<a href="{{ route('home', ['category' => 'Drink']) }}"
							class="flex justify-between px-4 py-3 font-semibold rounded text-textPrimary {{ request()->get('category') === 'Drink' ? 'font-bold rounded bg-primary/20 text-primary' : 'font-semibold rounded text-textPrimary' }}"
						>
							<div>
								<i class="mr-3 ri-goblet-line"></i>
								<span>Drink</span>
							</div>
							<span class="text-textPrimary/60">{{ $drinkCount }}</span>
						</a>
					</div>
				</aside>
			</div>
			<main class="w-full">
				<p class="text-3xl font-bold">Menu</p>
				<section class="grid grid-cols-3 gap-6 mt-6">

                    @foreach ($products as $product)
					<div class="overflow-hidden bg-white rounded-xl">
						<div
							class="max-h-[300px] overflow-hidden object-cover object-center"
						>
							<img
								src="{{ asset('storage/images/products/' . $product->image) }}" alt="{{ $product->name }}"
								class="object-cover w-full h-56"
							/>
						</div>
						<div class="p-5">
							<p class="font-bold">{{ ucwords($product->name) }}</p>
							<p class="font-bold text-[14px] text-primary">{{ 'Rp' . number_format($product->price, 0, ',', '.') }}</p>
                            <form action="{{ route('order.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit"
                                    class="py-2 px-9 mt-3 bg-[#E2EAF8] rounded-xl font-bold text-bold"
                                >
                                    Pesan
                                </button>
                            </form>
						</div>
					</div>
                    @endforeach
                    
				</section>

                <div class="mt-5">
                    {{ $products->links() }}
                </div>
			</main>
		</main>

        @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
	</body>
</html>
