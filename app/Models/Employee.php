<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id', 'employee_name', 'employee_type'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
