<?php

namespace Midnite81\LaravelBase\Traits;

trait HasUuid
{
    /**
     * Register the model events for generating the UUID.
     */
    public static function bootHasUUID()
    {
        static::creating(function($model) {
            $column = $model->getUuidColumn();

            $model->$column = uuid();
        });
    }

    /**
     * Get the column that contains the UUID.
     *
     * @return string
     */
    public function getUuidColumn()
    {
        return 'identifier';
    }
}