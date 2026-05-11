<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto">
            {{-- Card statistic qty traveler masuk di departemen {{ auth()->user()->department->name ?? 'No Department' }}, keluar, balance --}}
            {{-- total traveler masuk diambil dari traveler yang memiliki surat jalan masuk dengan tujuan departemen user
             --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">

                {{-- Card Total Traveler Masuk --}}
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Traveler Masuk</h3>
                    <p class="mt-2 text-2xl font-semibold text-gray-800">{{ $totalIn }}</p>
                </div>

                {{-- Card Total Traveler Keluar --}}
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Traveler Keluar</h3>
                    <p class="mt-2 text-2xl font-semibold text-gray-800">{{ $totalOut }}</p>
                </div>

                {{-- Card Balance --}}
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <h3 class="text-sm font-medium text-gray-500">Balance Traveler</h3>
                    <p class="mt-2 text-2xl font-semibold text-gray-800">{{ $balance }}</p>
                </div>

            </div>

            {{-- Chart jumlah traveler masuk dan keluar per bulan di departemen user --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                <h3 class="text-sm font-medium text-gray-500 mb-4">Jumlah Traveler Masuk dan Keluar per Bulan</h3>
                <canvas id="travelerChart" height="100"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('travelerChart').getContext('2d');
            const travelerChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [
                        {
                            label: 'Traveler Masuk',
                            data: {!! json_encode($chartDataMasuk) !!},
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                        },
                        {
                            label: 'Traveler Keluar',
                            data: {!! json_encode($chartDataKeluar) !!},
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            stepSize: 1,
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>