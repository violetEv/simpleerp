<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traveler extends Model
{
    use HasFactory;

    protected $fillable = [
        'surat_jalan_id',
        'parent_traveler_id',
        'no_traveler',
        'pic',
        'qty',
        'dept_asal_id',
        'dept_tujuan_id',
        'current_dept_id',
        'tanggal',
        'notes'
    ];

    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class);
    }
    public function suratJalanOuts()
    {
        return $this->belongsToMany(
            SuratJalanOut::class,
            'surat_jalan_out_traveler',
            'traveler_id',
            'surat_jalan_out_id'
        );
    }

    public function parent()
    {
        return $this->belongsTo(Traveler::class, 'parent_traveler_id');
    }

    public function movements()
    {
        return $this->hasMany(TravelerMovement::class);
    }
    public function latestMovement()
    {
        return $this->hasOne(TravelerMovement::class)->latestOfMany();
    }

    public function children()
    {
        return $this->hasMany(Traveler::class, 'parent_traveler_id');
    }

    public function deptAsal()
    {
        return $this->belongsTo(Departments::class, 'dept_asal_id');
    }

    public function deptTujuan()
    {
        return $this->belongsTo(Departments::class, 'dept_tujuan_id');
    }
    public function currentDepartment()
    {
        return $this->belongsTo(Departments::class, 'current_dept_id');
    }
}
