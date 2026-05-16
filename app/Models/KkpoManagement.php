<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KkpoManagement extends Model
{
    protected $table = 'kkpo_managements';
    protected $fillable = ['no_kkpo', 'customer_id', 'kp_po', 'payment_terms', 'npwp', 'date', 'currency_id'];

    public function details()
    {
        return $this->hasMany(KkpoDetail::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function suratJalan()
    {
        return $this->hasMany(SuratJalan::class);
    }
    public function suratJalanOut()
    {
        return $this->hasMany(SuratJalanOut::class);
    }
    public function travelers()
    {
        return $this->hasManyThrough(Traveler::class, SuratJalan::class);
    }
}
