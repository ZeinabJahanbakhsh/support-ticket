<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    protected $casts = [
        'priority_id' => 'integer',
        'user_id'     => 'integer',
        'status_id'   => 'integer',
    ];


}
