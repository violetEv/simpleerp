<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['name'];
    public function kkpoManagements()
    {
        return $this->belongsToMany(KkpoManagement::class, 'kkpo_management_color');
    }
}
