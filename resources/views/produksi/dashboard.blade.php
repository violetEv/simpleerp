<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ auth()->user()->department_id ? auth()->user()->department->name : 'No Department'    }}  Dashboard
    </h2>
     {{-- Card statistic --}}
    {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex items-center">
                <div class="bg-blue-500 text-white rounded-full p-3">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Traveler Masuk</h3>
                    <p class="text-xl font-semibold text-gray-800">{{ $travelerMasuk }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex items-center">
                <div class="bg-green-500 text-white rounded-full p-3">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Selesai Hari Ini</h3>
                    <p class="text-xl font-semibold text-gray-800">{{ $selesaiHariIni }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex items-center">
                <div class="bg-yellow-500 text-white rounded-full p-3">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Problem</h3>
                    <p class="text-xl font-semibold text-gray-800">{{ $problem }}</p>
                </div>
            </div>
        </div>
    </div> --}}

     {{-- Table list traveler siap proses--}}
     {{-- <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-800 mb-4">Traveler Siap Proses</h3>
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Traveler</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dari</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($travelerSiapProses as $traveler)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $traveler->no_traveler }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $traveler->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $traveler->dari }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $traveler->status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('traveler.show', $traveler->id) }}" class="text-blue-500 hover:text-blue-700">Proses</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}
</x-app-layout>