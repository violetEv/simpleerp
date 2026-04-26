<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = [
        'name',
        'department_id'
    ];
    public function department()
    {
        return $this->belongsTo(Departments::class);
    }
}
