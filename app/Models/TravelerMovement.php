<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelerMovement extends Model
{
    use HasFactory;
    protected $fillable = [
        'traveler_id',
        'dept_id',
        'qty_in',
        'qty_out',
        'date_in',
        'date_out',
        'dept_destination_id',
        'qty_reject',
        'type_reject',
        'notes',
        'machine_id'
    ];

    public function traveler()
    {
        return $this->belongsTo(Traveler::class);
    }
}
