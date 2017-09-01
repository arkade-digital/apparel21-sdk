<?php

namespace App\Models\Concerns;

use Ramsey\Uuid\Uuid;

trait HasUuid
{
    protected static function bootHasUuid()
    {
        static::creating(function($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }
}