<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJalanOut extends Model
{
    protected $fillable = [
        'surat_jalan_in_id',
        'no_surat_jalan',
        'qty',
        'tanggal',
        'notes',
        'status',
    ];

    public function kkpoManagement()
    {
        return $this->belongsTo(KkpoManagement::class, 'kkpo_management_id');
    }
    public function travelers()
    {
        return $this->belongsToMany(
            Traveler::class,
            'surat_jalan_out_traveler', // nama tabel pivot
            'surat_jalan_out_id',
            'traveler_id'
        );
    }
    public function suratJalanIn()
    {
        return $this->belongsTo(SuratJalan::class);
    }
}
