<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['name', 'code'];

    public function details()
    {
        return $this->hasMany(KkpoDetail::class);
    }
}
