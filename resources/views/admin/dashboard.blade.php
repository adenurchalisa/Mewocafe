@extends('layouts.app', ['title' => 'Dashboard - MeowCafe'])

@section('content')
    <main class="p-7 bg-backgroundPrimary min-h-screen w-full mt-[70px]">
        <p class="text-3xl font-bold">Dashboard</p>
        <div class="grid grid-cols-4 mt-7 gap-x-7">
            <div class="flex flex-col justify-between flex-grow w-full h-40 p-4 bg-white rounded-xl">
                <div class="inline-flex items-start justify-between">
                    <div class="font-semibold">Total Drink</div>
                    <div>
                        <i class="p-4 text-3xl ri-group-fill bg-purple/20 text-purple rounded-3xl"></i>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <i class="text-lg ri-funds-line text-success"></i>
                    </div>
                    <p class="text-2xl font-bold">{{ $totalDrinkOrders }}</p>
                </div>
            </div>
            <div class="flex flex-col justify-between flex-grow w-full h-40 p-4 bg-white rounded-xl">
                <div class="inline-flex items-start justify-between">
                    <div class="font-semibold">Total Food</div>
                    <div>
                        <i class="p-4 text-3xl ri-line-chart-line bg-success/20 text-success rounded-3xl"></i>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <i class="text-lg ri-funds-line text-success"></i>
                    </div>
                    <p class="text-2xl font-bold">{{ $totalFoodOrders }}</p>
                </div>
            </div>
            <div class="flex flex-col justify-between flex-grow w-full h-40 p-4 bg-white rounded-xl">
                <div class="inline-flex items-start justify-between">
                    <div class="font-semibold">Total Order</div>
                    <div>
                        <i class="p-4 text-3xl ri-box-3-fill bg-warning/20 text-warning rounded-3xl"></i>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <i class="text-lg ri-funds-line text-success"></i>
                    </div>
                    <p class="text-2xl font-bold">{{ $totalOrders }}</p>
                </div>
            </div>
            <div class="flex flex-col justify-between flex-grow w-full h-40 p-4 bg-white rounded-xl">
                <div class="inline-flex items-start justify-between">
                    <div class="font-semibold">Total Income</div>
                    <div>
                        <i class="p-4 text-3xl ri-history-fill bg-error/20 text-error rounded-3xl"></i>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <i class="text-lg ri-funds-line text-success"></i>
                    </div>
                    <p class="text-2xl font-bold">Rp{{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="mt-10">
            <div class="w-full px-8 bg-white h-96 py-9 rounded-xl">
                <p class="text-xl font-bold">Sales Details</p>
                <canvas id="myChart" class="w-full"></canvas>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    @include('partials.chart')

    {{-- <script>
        $(document).ready(function() {
            let lastKnownTimestamp =
                {{ \App\Models\Order::where('payment_status', 'completed')->orderBy('updated_at', 'desc')->first()->updated_at->timestamp ?? 0 }};

            function checkForDashboardUpdates() {
                $.ajax({
                    url: "{{ route('check-dashboard-updates') }}",
                    type: "POST",
                    data: {
                        lastKnownTimestamp: lastKnownTimestamp,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status) {
                            location.reload();
                        } else {
                            setTimeout(checkForDashboardUpdates, 5000); // Cek lagi setelah 5 detik
                        }
                    }
                });
            }

            setTimeout(checkForDashboardUpdates, 5000); // Mulai polling setelah 5 detik
        });
    </script> --}}
@endpush
