<?php

namespace App\Models\Fortnite\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FortniteEvent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'event_display_id',
        'event_region',
        'event_name_1',
        'event_name_2',
        'event_poster',
        'event_description',
        'event_schedule',
        'event_start_time',
        'event_end_time',
    ];

    public function FortniteEventPlatform(): HasMany
    {
        return $this->hasMany(FortniteEventPlatform::class, 'event_id', 'event_id');
    }

    public function FortniteEventWindow(): HasMany
    {
        return $this->hasMany(FortniteEventWindow::class, 'event_id', 'event_id');
    }
}
