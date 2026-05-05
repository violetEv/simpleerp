<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KkpoManagement extends Model
{
    protected $table = 'kkpo_managements';
    protected $fillable = ['no_kkpo', 'customer_id', 'kp_po', 'payment_terms', 'notes', 'npwp', 'tanggal'];

    public function details()
    {
        return $this->hasMany(KkpoDetail::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class, 'kkpo_management_category');
    // }
    // public function styles()
    // {
    //     return $this->belongsToMany(Style::class, 'kkpo_management_style');
    // }
    // public function colors()
    // {
    //     return $this->belongsToMany(Color::class, 'kkpo_management_color');
    // }
    // public function brands()
    // {
    //     return $this->belongsToMany(Brand::class, 'kkpo_management_brand');
    // }
    // public function items()
    // {
    //     return $this->belongsToMany(Item::class, 'kkpo_management_item');
    // }
    // public function unit()
    // {
    //     return $this->belongsTo(Unit::class);
    // }
    // public function currency()
    // {
    //     return $this->belongsTo(Currency::class);
    // }
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
