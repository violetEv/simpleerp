<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name'];
    public function details()
    {
        return $this->hasMany(KkpoDetail::class);
    }
}
