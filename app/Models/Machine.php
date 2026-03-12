<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    public function department()
    {
        return $this->belongsTo(Departments::class);
    }
}
