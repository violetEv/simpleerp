<?php

namespace App\Exports;

use App\Models\TravelerMovement;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TravelerMovementExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return TravelerMovement::query()
            ->with([
                'traveler.suratJalan.kkpoManagement.customer',
                'traveler.suratJalan.kkpoManagement.category',
                'traveler.suratJalan.kkpoManagement.style',
                'traveler.suratJalan.kkpoManagement.brand',
                'traveler.suratJalan.kkpoManagement.item',
                'traveler.suratJalan.kkpoManagement.color',
                
            ])

            // SEARCH
            ->when($this->request->search, function ($q, $search) {
                $q->whereHas('traveler', function ($t) use ($search) {
                    $t->where('no_traveler', 'like', "%$search%");
                });
            })

            // KKPO
            ->when($this->request->kkpo, function ($q, $kkpo) {
                $q->whereHas('traveler.suratJalan.kkpoManagement', function ($k) use ($kkpo) {
                    $k->where('no_kkpo', $kkpo);
                });
            })

            // SURAT JALAN
            ->when($this->request->no_surat_jalan, function ($q, $sj) {
                $q->whereHas('traveler.suratJalan', function ($s) use ($sj) {
                    $s->where('no_surat_jalan', $sj);
                });
            })

            // CUSTOMER
            ->when($this->request->customer, function ($q, $customer) {
                $q->whereHas('traveler.suratJalan.kkpoManagement.customer', function ($c) use ($customer) {
                    $c->where('name', $customer);
                });
            })

            // STYLE
            ->when($this->request->style, function ($q, $style) {
                $q->whereHas('traveler.suratJalan.kkpoManagement.style', function ($s) use ($style) {
                    $s->where('name', $style);
                });
            })
            ->when($this->request->brand, function ($q, $brand) {
                $q->whereHas('traveler.suratJalan.kkpoManagement.brand', function ($b) use ($brand) {
                    $b->where('name', $brand);
                });
            })
            ->when($this->request->item, function ($q, $item) {
                $q->whereHas('traveler.suratJalan.kkpoManagement.item', function ($i) use ($item) {
                    $i->where('name', $item);
                });
            })
            ->when($this->request->color, function ($q, $color) {
                $q->whereHas('traveler.suratJalan.kkpoManagement.color', function ($c) use ($color) {
                    $c->where('name', $color);
                });
            })
            ->when($this->request->date_from, function ($q) {
                $q->whereDate('created_at', '>=', $this->request->date_from);
            })

            ->when($this->request->date_to, function ($q) {
                $q->whereDate('created_at', '<=', $this->request->date_to);
            })

            ->get()

            ->map(function ($m) {
                return [
                    'KKPO'        => $m->traveler->suratJalan->kkpoManagement->no_kkpo ?? '-',
                    'Surat Jalan' => $m->traveler->suratJalan->no_surat_jalan ?? '-',
                    'Customer'    => $m->traveler->suratJalan->kkpoManagement->customer->name ?? '-',
                    'Category'    => $m->traveler->suratJalan->kkpoManagement->category->name ?? '-',
                    'Style'       => $m->traveler->suratJalan->kkpoManagement->style->name ?? '-',
                    'Brand'       => $m->traveler->suratJalan->kkpoManagement->brand->name ?? '-',
                    'Item'        => $m->traveler->suratJalan->kkpoManagement->item->name ?? '-',
                    'Color'       => $m->traveler->suratJalan->kkpoManagement->color->name ?? '-',
                    'Qty In'      => $m->qty_in,
                    'Qty Out'     => $m->qty_out,
                    'Balance'     => $m->balance,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'KKPO',
            'Surat Jalan',
            'Customer',
            'Category',
            'Style',
            'Brand',
            'Item',
            'Color',
            'Qty In',
            'Qty Out',
            'Balance',
        ];
    }
}
