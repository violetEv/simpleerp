<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KkpoDetail extends Model
{
    protected $table = 'kkpo_details';

    protected $fillable = [
        'kkpo_management_id',
        'category_id',
        'style_id',
        'color_id',
        'item_id',
        'brand_id',
        'qty',
        'unit_id',
        'price',
        'reject_allowance',
        'remark',
        'pic'
    ];

    //  BALIK KE HEADER
    public function kkpo()
    {
        return $this->belongsTo(KkpoManagement::class, 'kkpo_management_id');
    }
    public function suratJalans()
    {
        return $this->hasMany(SuratJalan::class);
    }
    //  RELASI MASTER 
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

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

}
