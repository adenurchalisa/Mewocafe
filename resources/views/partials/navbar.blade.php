@php
	$action = '';
	$placeholder = '';
	if(request()->is('products*')){
		$action = '/products';
		$placeholder = 'Search Product...';
	} else if(request()->is('orders*')){
		$action = '/orders';
		$placeholder = 'Search Order...';
	}
@endphp
<nav
					class="h-[70px] flex py-4 px-7 justify-between items-center flex-grow fixed bg-white left-[240px] right-0"
				>
					<x-search :action="$action" :placeholder="$placeholder"></x-search>
					<div class="flex items-center h-full gap-5">
						<div
							class="object-center h-full overflow-hidden rounded-full aspect-square"
						>
							<img
								src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRj5r7mceg1cqsh7ZBtZYXjQUwXxjqTXV4qjHWC5Xf3_g&s"
								alt=""
								class="w-full"
							/>
						</div>
						<div>
							<p class="font-bold text-[#404040]">Imank</p>
							{{-- <p class="text-sm font-semibold text-[#565656]">イマン</p> --}}
						</div>
					</div>
				</nav>