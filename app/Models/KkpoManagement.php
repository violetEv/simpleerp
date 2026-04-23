<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KkpoManagement extends Model
{
    protected $table = 'kkpo_managements';
    protected $fillable = ['no_kkpo','customer_id', 'category_id', 'style_id', 'color_id', 'unit_id', 'brand_id', 'item_id', 'kp_po', 'qty_total', 'currency_id', 'price', 'reject_allowance'];

    // public function kkpo()
    // {
    //     return $this->belongsTo(Kkpo::class, 'kkpo_id');
    // }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function style()
    {
        return $this->belongsTo(Style::class);
    }
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
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
