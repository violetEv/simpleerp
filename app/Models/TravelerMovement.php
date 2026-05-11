<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelerMovement extends Model
{
    use HasFactory;
    protected $fillable = [
        'traveler_id',
        'current_dept_id',
        'qty_in',
        'qty_out',
        'balance',
        'date_in',
        'date_out',
        'dept_asal_id',
        'dept_tujuan_id',
        'qty_reject',
        'type_reject',
        'notes',
        'machine_id',
        'type',
        'created_by',
        'updated_by',
        'status_case'
    ];

    public function traveler()
    {
        return $this->belongsTo(Traveler::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function department()
    {
        return $this->belongsTo(Departments::class, 'dept_id');
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
    public function currentDepartment()
    {
        return $this->belongsTo(Departments::class, 'current_dept_id');
    }

    public function deptAsal()
    {
        return $this->belongsTo(Departments::class, 'dept_asal_id');
    }

    public function deptTujuan()
    {
        return $this->belongsTo(Departments::class, 'dept_tujuan_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function getBalanceAttribute()
    {
        return ($this->qty_in ?? 0) - ($this->qty_out ?? 0) - ($this->qty_reject ?? 0);
    }

}
