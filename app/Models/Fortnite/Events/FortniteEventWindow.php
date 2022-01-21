<?php

namespace App\Models\Fortnite\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FortniteEventWindow extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'window_id',
        'begin_time',
        'end_time',
    ];

    public function FortniteEvent(): BelongsTo
    {
        return $this->belongsTo(FortniteEvent::class, 'event_id', 'event_id');
    }
}
