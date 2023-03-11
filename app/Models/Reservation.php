<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'reserve_date',
        'reserve_time',
        'user_id',
        'speciality_id',
        'status',
        'expect_waiting'


    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Speciality()
    {
        return $this->belongsTo(speciality::class);
    }
}