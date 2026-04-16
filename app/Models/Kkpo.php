<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kkpo extends Model
{
    protected $fillable = ['no_kkpo', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function kkpoManagements()
    {
        return $this->hasMany(KkpoManagement::class);
    }
}
