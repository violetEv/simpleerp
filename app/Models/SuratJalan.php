<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_surat_jalan',
        'kkpo_id',
        'qty',
        'tanggal',
        'notes',
    ];

    public function kkpo()
    {
        return $this->belongsTo(Kkpo::class);
    }
    public function travelers()
    {
        return $this->hasMany(Traveler::class);
    }
}
