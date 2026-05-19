<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Approval') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>Halaman ini digunakan untuk menampilkan daftar surat jalan yang menunggu approval. Anda dapat melihat detail surat jalan dan memberikan persetujuan atau penolakan.</p>
                    <table class="min-w-full mt-4 bg-white border">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">No. Surat Jalan</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                                <th class="px-4 py-2 border">Tujuan</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suratJalans as $sj)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $sj->no_surat_jalan }}</td>
                                    <td class="px-4 py-2 border">{{ $sj->tanggal }}</td>
                                    <td class="px-4 py-2 border">{{ $sj->tujuan }}</td>
                                    <td class="px-4 py-2 border">{{ $sj->status }}</td>
                                    <td class="px-4 py-2 border">
                                        <a href="{{ route('manager.approval.show', ['id' => $sj->id]) }}"
                                            class="text-blue-500 border border-blue-500 rounded-xl py-1 px-4 hover:bg-blue-50">
                                            Detail</a>  
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>      
    </div>
</x-app-layout>