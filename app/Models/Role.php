<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    // use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'code' => RoleEnum::class
    ];


    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user')
                    ->using(RoleUser::class)
                    ->withTimestamps();
    }


}
