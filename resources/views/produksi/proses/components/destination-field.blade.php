@if ($dept != 'Warehouse Send')
    <div class="mb-4">
        <label for="dept_tujuan_id" class="block text-sm font-medium text-gray-700">Destination
            Department</label>
        <select name="dept_tujuan_id" id="dept_tujuan_id"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            required>
            <option value="">Select Department</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
    </div>
@endif
