<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];


    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'label_ticket')
                    ->using(LabelTicket::class)
                    ->withTimestamps();
    }

}
