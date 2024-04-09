<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BootedModelUserActions
{
    /**
     * Adds global scope to the model's query builder to filter records by the authenticated user.
     * Sets the "user_id" attribute of the model being created, updated, or deleted to the authenticated user ID.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope('by_user', function (Builder $builder) {
            if ($userId = self::getAuthUserId()) {
                $builder->where('user_id', $userId);
            }
        });

        static::creating(function ($model) {
            if ($userId = self::getAuthUserId()) {
                $model->user_id = $userId;
            }
        });

        static::updating(function ($model) {
            if ($userId = self::getAuthUserId()) {
                $model->user_id = $userId;
            }
        });

        static::deleting(function ($model) {
            if ($userId = self::getAuthUserId()) {
                $model->user_id = $userId;
            }
        });
    }

    /**
     * Retrieve the authenticated user's ID.
     *
     * @return int|null The ID of the authenticated user if available, or null if not authenticated.
     */
    private static function getAuthUserId(): int|null
    {
        return auth()->check() ? auth()->id() : null;
    }
}
