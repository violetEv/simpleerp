<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'npwp', 'payment_terms'];
    public function kkpos()
    {
        return $this->hasMany(KkpoManagement::class, 'customer_id');
    }
}
