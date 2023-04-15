<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

trait Guid
{
    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }

    /**
     * @throws Exception
     */
    public static function bootGuid(): void
    {
        self::creating(function (Model $model) {
            $model->id = (string) Uuid::generate(4);
        });
    }
}
