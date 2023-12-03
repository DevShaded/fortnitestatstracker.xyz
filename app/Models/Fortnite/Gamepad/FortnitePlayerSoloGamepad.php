<?php

namespace App\Models\Fortnite\Gamepad;

use App\Models\Fortnite\FortnitePlayer;
use App\Traits\Guid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FortnitePlayerSoloGamepad extends Model
{
    use Guid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'score',
        'scorePerMin',
        'scorePerMatch',
        'wins',
        'top10',
        'top25',
        'kills',
        'killsPerMin',
        'killsPerMatch',
        'deaths',
        'kd',
        'matches',
        'winRate',
        'minutesPlayed',
        'playersOutLived',
    ];

    /**
     * Get the fortnite player that owns the solo gamepad stats
     */
    public function fortnitePlayer(): BelongsTo
    {
        return $this->belongsTo(FortnitePlayer::class, 'account_id', 'account_id');
    }
}
