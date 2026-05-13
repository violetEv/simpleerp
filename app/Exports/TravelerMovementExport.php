<?php

namespace App\Exports;

use App\Models\TravelerMovement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TravelerMovementExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters ?? [];
    }

    public function collection()
    {
        $query = TravelerMovement::with([
            'traveler.suratJalan.kkpoManagement.customer',
            'traveler.suratJalan.kkpoManagement.details.category',
            'traveler.suratJalan.kkpoManagement.details.style',
            'traveler.suratJalan.kkpoManagement.details.brand',
            'traveler.suratJalan.kkpoManagement.details.item',
            'traveler.suratJalan.kkpoManagement.details.color',
        ])

        ->whereIn('id', function ($q) {
            $q->selectRaw('MAX(id)')
                ->from('traveler_movements')
                ->groupBy('traveler_id');
        })

        //hanya yg sudah selesai (ada OUT)
        ->whereNotNull('qty_out');

        // ================= FILTER =================

        $query->when($this->filters['search'] ?? null, function ($q, $search) {
            $q->whereHas('traveler', function ($t) use ($search) {
                $t->where('no_traveler', 'like', "%$search%");
            });
        });

        $query->when($this->filters['kkpo'] ?? null, function ($q, $kkpo) {
            $q->whereHas('traveler.suratJalan.kkpoManagement', function ($k) use ($kkpo) {
                $k->where('no_kkpo', $kkpo);
            });
        });

        $query->when($this->filters['no_surat_jalan'] ?? null, function ($q, $sj) {
            $q->whereHas('traveler.suratJalan', function ($s) use ($sj) {
                $s->where('no_surat_jalan', $sj);
            });
        });

        $query->when($this->filters['customer'] ?? null, function ($q, $customer) {
            $q->whereHas('traveler.suratJalan.kkpoManagement.customer', function ($c) use ($customer) {
                $c->where('name', $customer);
            });
        });

        $query->when($this->filters['style'] ?? null, function ($q, $style) {
            $q->whereHas('traveler.suratJalan.kkpoManagement.details.style', function ($s) use ($style) {
                $s->where('name', $style);
            });
        });

        $query->when($this->filters['category'] ?? null, function ($q, $category) {
            $q->whereHas('traveler.suratJalan.kkpoManagement.details.category', function ($c) use ($category) {
                $c->where('name', $category);
            });
        });

        $query->when($this->filters['color'] ?? null, function ($q, $color) {
            $q->whereHas('traveler.suratJalan.kkpoManagement.details.color', function ($c) use ($color) {
                $c->where('name', $color);
            });
        });

        $query->when($this->filters['date_from'] ?? null, function ($q) {
            $q->whereDate('date_out', '>=', $this->filters['date_from']);
        });

        $query->when($this->filters['date_to'] ?? null, function ($q) {
            $q->whereDate('date_out', '<=', $this->filters['date_to']);
        });

        return $query->get()->map(function ($m) {

            $traveler = $m->traveler;
            $suratJalan = optional($traveler)->suratJalan;
            $kkpo = optional($suratJalan)->kkpoManagement;

            return [
                'KKPO'        => $kkpo->no_kkpo ?? '-',
                'Surat Jalan' => $suratJalan->no_surat_jalan ?? '-',
                'Customer'    => optional($kkpo->customer)->name ?? '-',
                'Category'    => optional($kkpo->details->category)->name ?? '-',
                'Style'       => optional($kkpo->details->style)->name ?? '-',
                'Brand'       => optional($kkpo->details->brand)->name ?? '-',
                'Item'        => optional($kkpo->details->item)->name ?? '-',
                'Color'       => optional($kkpo->details->color)->name ?? '-',
                'Qty In'      => $m->qty_in ?? 0,
                'Qty Out'     => $m->qty_out ?? 0,
                'Balance'     => $m->balance ?? 0,
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