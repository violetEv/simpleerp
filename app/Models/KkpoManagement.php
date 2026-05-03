<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KkpoManagement extends Model
{
    protected $table = 'kkpo_managements';
    protected $fillable = ['no_kkpo','customer_id', 'category_id', 'style_id', 'color_id', 'unit_id', 'brand_id', 'item_id', 'kp_po', 'qty_total', 'currency_id', 'price', 'reject_allowance','payment_terms','notes', 'npwp', 'remark', 'tanggal'];

    // public function kkpo()
    // {
    //     return $this->belongsTo(Kkpo::class, 'kkpo_id');
    // }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'kkpo_management_category');
    }
    public function styles()
    {
        return $this->belongsToMany(Style::class, 'kkpo_management_style');
    }
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'kkpo_management_color');
    }
    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'kkpo_management_brand');
    }
    public function items()
    {
        return $this->belongsToMany(Item::class, 'kkpo_management_item');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
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
