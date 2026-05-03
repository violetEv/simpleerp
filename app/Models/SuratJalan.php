<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;
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
    public function suratJalanOut()
    {
        return $this->hasMany(SuratJalanOut::class);
    }
}
