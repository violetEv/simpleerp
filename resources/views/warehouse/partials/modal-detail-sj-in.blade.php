{{-- Modal Detail --}}
<div id="detail-modal"
    class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 max-w-7xl mx-auto p-6">
    <div class="bg-white rounded-lg p-6 w-full max-w-2xl overflow-auto max-h-[90vh] ">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-4 border-b pb-3">
            <h3 class="text-lg font-semibold text-gray-700">
                Detail Surat Jalan
            </h3>

            <button onclick="closeDetail()" title="Close" class="text-gray-400 hover:text-gray-600 text-2xl">
                &times;
            </button>
        </div>


        {{-- ORDER ID + STATUS --}}
        <div class="grid grid-cols-2 gap-7-3 text-sm mb-6">

            <div>
                <p class="text-gray-400 text-sm">No Surat Jalan</p>
                <p id="detail_sj" class="font-semibold"></p>
            </div>

            <div>
                <p class="text-gray-400 text-sm">Status</p>
                <span id="detail_status" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                </span>
            </div>

        </div>


        {{-- DETAIL --}}
        <div class="grid grid-cols-2 gap-y-3 text-sm">

            <span class="text-gray-500">KKPO</span>
            <span id="detail_kkpo"></span>

            {{-- <span class="text-gray-500">No Surat Jalan</span>
            <span id="detail_sj"></span> --}}

            <span class="text-gray-500">Customer</span>
            <span id="detail_customer"></span>

            <span class="text-gray-500">Category Process</span>
            <span id="detail_category"></span>

            <span class="text-gray-500">Style</span>
            <span id="detail_style"></span>

            <span class="text-gray-500">Color</span>
            <span id="detail_color"></span>

            <span class="text-gray-500">Qty</span>
            <span id="detail_qty"></span>

            {{-- <span class="text-gray-500">Dept Tujuan</span>
            <span id="detail_dept"></span> --}}

            <span class="text-gray-500">Tanggal</span>
            <span id="detail_tanggal"></span>

            <span class="text-gray-500">Notes</span>
            <span id="detail_notes"></span>

        </div>

    </div>
</div>
    <script>


        function openDetail(btn) {
            document.getElementById('detail-modal').classList.remove('hidden');
            document.getElementById('detail-modal').classList.add('flex');

            document.getElementById('detail_kkpo').innerText = btn.dataset.kkpo;
            document.getElementById('detail_customer').innerText = btn.dataset.customer;
            document.getElementById('detail_sj').innerText = btn.dataset.sj;
            document.getElementById('detail_qty').innerText = btn.dataset.qty;
            document.getElementById('detail_style').innerText = btn.dataset.style;
            document.getElementById('detail_color').innerText = btn.dataset.color;
            document.getElementById('detail_category').innerText = btn.dataset.category;
            document.getElementById('detail_tanggal').innerText = btn.dataset.tanggal;
            document.getElementById('detail_status').innerText = btn.dataset.status;
            document.getElementById('detail_notes').innerText = btn.dataset.notes;
        }

        function closeDetail() {
            document.getElementById('detail-modal').classList.add('hidden');
            document.getElementById('detail-modal').classList.remove('flex');
        }

        
    </script>