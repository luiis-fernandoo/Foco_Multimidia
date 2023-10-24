<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserves extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'hotelCOde',
        'roomCode',
        'checkIn',
        'checkOut',
        'total',
    ];
}

class Guests extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastName',
        'phone',
        'reserves_id',
    ];
}

class Dailies extends Model
{
    protected $fillable = [
        'date',
        'value',
        'reserves_id',
    ];
}

class Payments extends Model
{
    protected $fillable = [
        'method',
        'value',
        'reserves_id',
    ];
}
