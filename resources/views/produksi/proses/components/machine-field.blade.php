@if (in_array($dept, ['Dyeing', 'Washing']))
    <div class="mb-4">
        <label for="machine_id" class="block text-sm font-medium text-gray-700">Mesin</label>
        <select name="machine_id" id="machine_id" required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            <option value="">Select Mesin</option>
            @foreach ($machines as $machine)
                <option value="{{ $machine->id }}">{{ $machine->name }}</option>
            @endforeach
        </select>
    </div>
@endif
