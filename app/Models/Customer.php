<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'attention'];
    public function kkpos()
    {
        return $this->hasMany(KkpoManagement::class);
    }
}
