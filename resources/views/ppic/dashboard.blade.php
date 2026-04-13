<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        PPIC Dashboard
    </h2>
    {{-- CARD TOTAL --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-700">Total KKPO</h3>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalKKPO }}</p>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-700">Total Colors</h3>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalColors }}</p>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-700">Total Sizes</h3>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalSizes }}</p>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-700">Total Materials</h3>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalMaterials }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
