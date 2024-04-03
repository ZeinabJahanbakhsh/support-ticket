<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Status extends Model
{
    // use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'code' => StatusEnum::class
    ];


   /*
  |--------------------------------------------------------------------------
  | Model Scopes
  |--------------------------------------------------------------------------
  */

}
