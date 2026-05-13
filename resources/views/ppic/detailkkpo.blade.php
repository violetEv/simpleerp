<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto">

            {{-- BACK --}}
            <div class="flex justify-between items-center mb-4 mt-2">
                <a href="{{ route('ppic.kkpo') }}" class="text-sm text-gray-500 hover:text-[#136566] transition">
                    ← Back
                </a>
            </div>

            {{-- HEADER --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-4">
                <h2 class="text-xl font-semibold text-gray-800">
                    KKPO Detail - {{ $detail->kkpo->no_kkpo }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Complete information related to KKPO, product, and customer.
                </p>
            </div>

            {{-- MAIN GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                {{-- LEFT SIDE --}}
                <div class="lg:col-span-2 space-y-4">

                    {{-- KKPO INFORMATION --}}
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

                        <div class="border-b border-gray-200 pb-3 mb-5">
                            <h3 class="text-sm font-semibold text-[#136566] uppercase tracking-wide">
                                KKPO Information
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    No KKPO
                                </div>

                                <div class="font-semibold text-gray-800">
                                    {{ $detail->kkpo->no_kkpo }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    KP / PO
                                </div>

                                <div class="text-gray-800">
                                    {{ $detail->kkpo->kp_po ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Issue Date
                                </div>

                                <div class="text-gray-800">
                                    {{ $detail->kkpo->date ? \Carbon\Carbon::parse($detail->kkpo->date)->format('d M Y') : '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Payment Terms
                                </div>

                                <div class="text-gray-800">
                                    {{ $detail->kkpo->payment_terms ?? '-' }} Days
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Currency
                                </div>

                                <div class="text-gray-800">
                                    {{ $detail->kkpo->currency->code ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    NPWP
                                </div>

                                <div class="text-gray-800">
                                    {{ $detail->kkpo->npwp ?? '-' }}
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- PRODUCT INFORMATION --}}
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

                        <div class="border-b border-gray-200 pb-3 mb-5">
                            <h3 class="text-sm font-semibold text-[#136566] uppercase tracking-wide">
                                Product Information
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Category
                                </div>

                                <div class="text-gray-800">
                                    {{ $detail->category->name ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Style
                                </div>

                                <div class="text-gray-800">
                                    {{ $detail->style->name ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Color
                                </div>

                                <div class="text-gray-800">
                                    {{ $detail->color->name ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Item
                                </div>

                                <div class="text-gray-800">
                                    {{ $detail->item->name ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Brand
                                </div>

                                <div class="text-gray-800">
                                    {{ $detail->brand->name ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Quantity
                                </div>

                                <div class="font-semibold text-gray-800">
                                    {{ number_format($detail->qty, 0, ',', '.') }}
                                    <span class="text-gray-500 text-xs">
                                        {{ $detail->unit->name ?? '-' }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Unit Price
                                </div>

                                <div class="font-semibold text-gray-800">
                                    {{ number_format($detail->price, 0, ',', '.') }}

                                    <span class="text-gray-500 text-xs">
                                        {{ $detail->kkpo->currency->code ?? '-' }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Reject Allowance
                                </div>

                                <div class="text-gray-800">
                                    {{ $detail->reject_allowance ?? 0 }}%
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- RIGHT SIDE --}}
                <div class="space-y-4">

                    {{-- CUSTOMER --}}
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

                        <div class="border-b border-gray-200 pb-3 mb-5">
                            <h3 class="text-sm font-semibold text-[#136566] uppercase tracking-wide">
                                Customer Information
                            </h3>
                        </div>

                        <div class="space-y-5 text-sm">

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Customer Name
                                </div>

                                <div class="font-semibold text-gray-800">
                                    {{ $detail->kkpo->customer->name ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    PIC
                                </div>

                                <div class="text-gray-800">
                                    {{ $detail->pic ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Telephone
                                </div>

                                <div class="text-gray-800">
                                    {{ $detail->kkpo->customer->phone ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500 text-xs mb-1">
                                    Address
                                </div>

                                <div class="text-gray-800 leading-relaxed">
                                    {{ $detail->kkpo->customer->address ?? '-' }}
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- REMARK --}}
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

                        <div class="border-b border-gray-200 pb-3 mb-5">
                            <h3 class="text-sm font-semibold text-[#136566] uppercase tracking-wide">
                                Notes
                            </h3>
                        </div>

                        <div class="text-sm text-gray-700 leading-relaxed">
                            {{ $detail->remark ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
