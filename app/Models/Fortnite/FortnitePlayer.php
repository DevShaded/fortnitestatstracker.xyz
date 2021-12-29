<?php

namespace App\Models\Fortnite;

use App\Models\Fortnite\Gamepad\{FortnitePlayerDuoGamepad,
    FortnitePlayerLTMGamepad,
    FortnitePlayerOverallGamepad,
    FortnitePlayerSoloGamepad,
    FortnitePlayerSquadGamepad};
use App\Models\Fortnite\KeyboardMouse\{FortnitePlayerDuoKeyboard,
    FortnitePlayerLTMKeyboard,
    FortnitePlayerOverallKeyboard,
    FortnitePlayerSoloKeyboard,
    FortnitePlayerSquadKeyboard};
use App\Models\Fortnite\Lifetime\{FortnitePlayerDuoLifetime,
    FortnitePlayerLTMLifetime,
    FortnitePlayerOverallLifetime,
    FortnitePlayerSoloLifetime,
    FortnitePlayerSquadLifetime};
use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, Relations\HasMany};

class FortnitePlayer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'account_id',
        'username',
        'level',
        'progress',
        'image'
    ];

    /**
     * !!!!
     * Here you can find the relationship for the lifetime tables
     */

    /**
     * Get all the of the duo lifetime stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerDuoLifetime(): HasMany
    {
        return $this->hasMany(FortnitePlayerDuoLifetime::class, 'account_id', 'account_id');
    }

    /**
     * Get all the of the LTM lifetime stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerLTMLifetime(): HasMany
    {
        return $this->hasMany(FortnitePlayerLTMLifetime::class, 'account_id', 'account_id');
    }

    /**
     * Get all the of the overall lifetime stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerOverallLifetime(): HasMany
    {
        return $this->hasMany(FortnitePlayerOverallLifetime::class, 'account_id', 'account_id');
    }

    /**
     * Get all the of the solo lifetime stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerSoloLifetime(): HasMany
    {
        return $this->hasMany(FortnitePlayerSoloLifetime::class, 'account_id', 'account_id');
    }

    /**
     * Get all the of the squad lifetime stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerSquadLifetime(): HasMany
    {
        return $this->hasMany(FortnitePlayerSquadLifetime::class, 'account_id', 'account_id');
    }


    /**
     * !!!!
     * Here you can find the relationship for the Keyboard & Mouse tables
     */

    /**
     * Get all the of the duo keyboard&mouse stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerDuoKeyboard(): HasMany
    {
        return $this->hasMany(FortnitePlayerDuoKeyboard::class, 'account_id', 'account_id');
    }

    /**
     * Get all the of the LTM keyboard&mouse stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerLTMKeyboard(): HasMany
    {
        return $this->hasMany(FortnitePlayerLTMKeyboard::class, 'account_id', 'account_id');
    }

    /**
     * Get all the of the overall keyboard&mouse stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerOverallKeyboard(): HasMany
    {
        return $this->hasMany(FortnitePlayerOverallKeyboard::class, 'account_id', 'account_id');
    }

    /**
     * Get all the of the solo keyboard&mouse stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerSoloKeyboard(): HasMany
    {
        return $this->hasMany(FortnitePlayerSoloKeyboard::class, 'account_id', 'account_id');
    }

    /**
     * Get all the of the squad keyboard&mouse stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerSquadKeyboard(): HasMany
    {
        return $this->hasMany(FortnitePlayerSquadKeyboard::class, 'account_id', 'account_id');
    }

    /**
     * !!!!
     * Here you can find the relationship for the Gamepad tables
     */

    /**
     * Get all the of the duo gamepad stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerDuoGamepad(): HasMany
    {
        return $this->hasMany(FortnitePlayerDuoGamepad::class, 'account_id', 'account_id');
    }

    /**
     * Get all the of the LTM gamepad stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerLTMGamepad(): HasMany
    {
        return $this->hasMany(FortnitePlayerLTMGamepad::class, 'account_id', 'account_id');
    }

    /**
     * Get all the of the overall gamepad stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerOverallGamepad(): HasMany
    {
        return $this->hasMany(FortnitePlayerOverallGamepad::class, 'account_id', 'account_id');
    }

    /**
     * Get all the of the solo gamepad stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerSoloGamepad(): HasMany
    {
        return $this->hasMany(FortnitePlayerSoloGamepad::class, 'account_id', 'account_id');
    }

    /**
     * Get all the of the squad gamepad stats for the Fortnite Player
     *
     * @return HasMany
     */
    public function FortnitePlayerSquadGamepad(): HasMany
    {
        return $this->hasMany(FortnitePlayerSquadGamepad::class, 'account_id', 'account_id');
    }
}
