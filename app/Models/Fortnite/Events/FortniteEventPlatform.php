<?php

namespace App\Models\Fortnite\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FortniteEventPlatform extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'event_platform'
    ];

    public function FortniteEvent(): BelongsTo
    {
        return $this->belongsTo(FortniteEvent::class, 'event_id', 'event_id');
    }
}
