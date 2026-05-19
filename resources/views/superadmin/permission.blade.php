<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col gap-2 mb-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">Permission Management</h2> --}}
                    <p class="mt-2 text-sm text-gray-500 max-w-2xl">Atur hak akses Create, Read, Update, dan Delete untuk masing-masing role.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-6">
                <form action="{{ route('superadmin.permission.store') }}" method="POST">
                    @csrf

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed text-gray-800">
                            <thead class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">
                                <tr>
                                    <th class="px-4 py-3 text-left">Role</th>
                                    @foreach ($actions as $action)
                                        <th class="px-4 py-3 text-center">{{ $action }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                @foreach ($roles as $role => $label)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $label }}</td>

                                        @foreach ($actions as $action => $actionLabel)
                                            <td class="px-4 py-3 text-center">
                                                <label class="inline-flex items-center justify-center gap-2 p-2 rounded-lg cursor-pointer hover:bg-gray-50">
                                                    <input
                                                        type="checkbox"
                                                        name="permissions[{{ $role }}][{{ $action }}]"
                                                        value="1"
                                                        class="h-4 w-4 text-[#136566] border-gray-300 rounded focus:ring-[#136566]"
                                                        {{ data_get($permissions, "$role.$action") ? 'checked' : '' }}
                                                    />
                                                </label>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm text-gray-500">Simpan pengaturan hak akses untuk setiap role agar sistem mengikuti aturan yang ditentukan.</p>
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded bg-[#136566] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0f4f50] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Permissions
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
