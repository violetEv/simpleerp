<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJalanOut extends Model
{
 protected $fillable = [
        'no_surat_jalan',
        'kkpo_management_id',
        'qty',
        'tanggal',
        'notes',
    ];

    public function kkpoManagement()
    {
        return $this->belongsTo(KkpoManagement::class, 'kkpo_management_id');
    }
    public function travelers()
    {
        return $this->hasMany(Traveler::class);
    }
    public function suratJalanIn()
    {
        return $this->belongsTo(SuratJalan::class);
    }
}
