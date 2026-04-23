<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departments extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    // Relasi: 1 department punya banyak user
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function travelersCurrent()
    {
        return $this->hasMany(Traveler::class, 'current_dept_id');
    }
    public function travelersAsal()
    {
        return $this->hasMany(Traveler::class, 'dept_asal_id');
    }

    public function travelersTujuan()
    {
        return $this->hasMany(Traveler::class, 'dept_tujuan_id');
    }
    // Relasi: 1 department punya banyak machine
    public function machines()
    {
        return $this->hasMany(Machine::class);
    }
}
