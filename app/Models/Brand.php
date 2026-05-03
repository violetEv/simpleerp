<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name'];
    public function kkpoManagements()
    {
        return $this->belongsToMany(KkpoManagement::class, 'kkpo_management_brand');
    }
}
