<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $fillable = ['name'];
    public function details()
    {
        return $this->hasMany(KkpoDetail::class);
    }
}
