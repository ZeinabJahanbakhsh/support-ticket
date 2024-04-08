<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;


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

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }


    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeAdminRole(Builder $builder): Builder
    {
        return $builder->where('code', RoleEnum::admin);
    }

    public function scopeAgentRole(Builder $builder): Builder
    {
        return $builder->where('code', RoleEnum::agent);
    }

    public function scopeDefaultRole(Builder $builder): Builder
    {
        return $builder->where('code', RoleEnum::default);
    }


}
