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
            if ($model->shouldRunEvent($model, 'created')) {
                $model->slug = $model->buildSlug();
                $model->save();
            }
        });

        static::updating(function($model) {
            if ($model->shouldRunEvent($model, 'updating')) {
                $model->slug = $model->buildSlug();
            }
        });

        static::saving(function($model) {
            if ($model->shouldRunEvent($model, 'saving')) {
                $model->slug = $model->buildSlug();
            }
        });

    }

    /**
     * Checks to see if the event should run
     *
     * @param $model
     * @param $type
     * @return bool
     */
    function shouldRunEvent($model, $type)
    {
        return property_exists($model, 'sluggableEvents') && in_array($type, $model->sluggableEvents)
            || ! property_exists($model, 'sluggableEvents');
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
        $name = $this->getAttribute($this->getSluggableColumn());
        return str_slug($name . '-' . $this->getAttribute('id'));

    }
}