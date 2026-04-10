<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KkpoManagement extends Model
{
    protected $table = 'kkpo_managements';
    protected $fillable = ['kkpo_id', 'customer_id', 'category_id', 'style_id', 'color_id', 'kp_po', 'qty_total', 'price', 'reject_allowance'];

    public function kkpo()
    {
        return $this->belongsTo(Kkpo::class, 'kkpo_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function style()
    {
        return $this->belongsTo(Style::class, 'style_id');
    }
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
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
