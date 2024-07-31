@extends('layouts.app', ['title' => 'Orders - MeowCafe'])

@section('content')
    <main class="p-7 bg-backgroundPrimary min-h-screen w-full mt-[70px]">
        <p class="text-3xl font-bold">Orders</p>
        {{-- <form method="GET" action="/orders">
            <input type="text" name="search" value="{{ request()->get('search') }}" placeholder="Search Orders">
            <button type="submit">Search</button>
        </form>         --}}
        <div class="bg-white border mt-7 border-borderPrimary rounded-xl">
            <table class="w-full">
                <thead class="text-left">
                    <tr class="border-b border-borderPrimary">
                        <th class="py-4 pl-8">No</th>
                        <th class="">Transaction ID</th>
                        <th class="">Product</th>
                        <th class="">Category</th>
                        <th class="">Price</th>
                        <th class="">Status</th>
                        <th class="">Action</th>
                    </tr>
                </thead>
                <tbody class="table-row-group font-semibold">
                    @foreach ($orders as $order)
                        <tr class="border-b border-b-borborder-borderPrimary">
                            <td class="py-6 pl-8">{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->index + 1 }}
                            </td>
                            <td>{{ $order->transaction_id }}</td>
                            <td>{{ ucwords($order->product->name) }}</td>
                            <td>{{ ucwords($order->product->category->name) }}</td>
                            <td>Rp{{ number_format($order->product->price, 0, ',', '.') }}</td>
                            <td>
                                <div class="data-complete:bg-success/20 rounded data-complete:text-success px-4 py-[4px] inline-block data-processing:bg-purple/20 data-processing:text-purple"
                                    data-status="{{ $order->payment_status === 'processing' ? 'processing' : 'complete' }}">
                                    {{ Str::ucfirst($order->payment_status) }}
                                </div>

                            </td>
                            <td class="h-full">
                                <div class="inline-flex rounded-lg bg-[#FAFBFD] border border-borderPrimary">
                                    <div class="w-[1px] bg-bordeborder-borderPrimary h-10"></div>
                                    <form action="{{ route('orders.complete', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="px-4 py-2">
                                            <i class="ri-check-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            {{ $orders->links() }}
        </div>
    </main>
@endsection

@push('scripts')
    {{-- <script>
        $(document).ready(function() {
            console.log('halo');
            let lastKnownTimestamp =
            {{ \App\Models\Order::orderBy('updated_at', 'desc')->first()->updated_at->timestamp ?? 0 }};
            
            function checkForNewOrders() {
                $.ajax({
                    url: "{{ route('check-new-orders') }}",
                    type: "POST",
                    data: {
                        lastKnownTimestamp: lastKnownTimestamp,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status) {
                            location.reload();
                        } else {
                            setTimeout(checkForNewOrders, 5000); // Cek lagi setelah 5 detik
                        }
                    }
                });
            }

            setTimeout(checkForNewOrders, 5000); // Mulai polling setelah 5 detik
        
        });
    </script> --}}
@endpush
