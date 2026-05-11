<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['name', 'code'];

    public function kkpos()
    {
        return $this->hasMany(KkpoManagement::class);
    }
}
