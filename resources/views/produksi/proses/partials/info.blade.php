<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Traveler Information</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <p><strong>No Traveler:</strong> {{ $traveler->no_traveler }}</p>
            <p><strong>Departemen Asal:</strong> {{ $traveler->deptAsal->name ?? '-' }}</p>
            <p><strong>Status:</strong> {{ $traveler->status }}</p>
        </div>
        <div>
            <p><strong>Created At:</strong> {{ $traveler->created_at }}</p>
            <p><strong>Updated At:</strong> {{ $traveler->updated_at }}</p>
        </div>
    </div>
</div>
