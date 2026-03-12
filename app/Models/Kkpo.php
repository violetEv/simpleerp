<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kkpo extends Model
{
    protected $fillable = ['no_kkpo', 'customer_id', 'category_id', 'style_id', 'color_id', 'qty_total', 'price', 'reject_allowance'];

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
    public function suratJalan()
    {
        return $this->hasMany(SuratJalan::class);
    }
    public function travelers()
    {
        return $this->hasManyThrough(Traveler::class, SuratJalan::class);   
    }
}
