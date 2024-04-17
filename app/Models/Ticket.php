<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Http\Controllers\Admin\TicketController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Ticket extends Model
{
    use HasFactory;

    use HasApiTokens, HasFactory, Notifiable;
    use LogsActivity;

    protected static $logOnlyDirty = true;


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                         ->useLogName(request()->route()->getActionMethod())
                         ->logOnly(['*']);
    }


    protected $fillable = [
        'title',
        'description',
    ];

    protected $casts = [
        'priority_id' => 'integer',
        'user_id'     => 'integer',
        'status_id'   => 'integer',
        'assigned_to' => 'integer',
    ];


    /*
   |--------------------------------------------------------------------------
   | Relations
   |--------------------------------------------------------------------------
   */

    public function priority(): belongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_ticket')
                    ->using(CategoryTicket::class)
                    ->withTimestamps();
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'label_ticket')
                    ->using(LabelTicket::class)
                    ->withTimestamps();
    }


    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'ticket_id');
    }


    /*
    |--------------------------------------------------------------------------
    |  Model Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeOpenStatus(Builder $builder): Builder
    {
        return $builder->where('status_id', Status::whereCode(StatusEnum::open)->value('id'));
    }

    public function scopeCloseStatus(Builder $builder): Builder
    {
        return $builder->where('status_id', Status::whereCode(StatusEnum::close)->value('id'));
    }

}
