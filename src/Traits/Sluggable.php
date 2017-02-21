<?php
namespace Midnite81\LaravelBase\Traits;

trait Sluggable
{
    /**
     * Register the model events for adding the slug.
     */
    public static function bootSluggable()
    {
        static::created(function($model) {
            $model->slug = $model->buildSlug();
            $model->save();
        });

        static::updating(function($model) {
            $model->slug = $model->buildSlug();
        });

    }

    /**
     * Return the Sluggable Column
     *
     * @return string
     */
    public function getSluggableColumn()
    {
        return 'name';
    }

    protected function buildSlug()
    {
        $name = $this->getAttribute($this->getName());
        return str_slug($name . '-' . $this->getAttribute('id'));

    }
}