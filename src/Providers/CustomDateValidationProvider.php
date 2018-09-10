<?php

namespace Midnite81\LaravelBase\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Midnite81\LaravelBase\Exceptions\Validators\ComparisonDirectionIsRequired;
use Midnite81\LaravelBase\Exceptions\Validators\ComparisonFieldIsRequiredException;

class CustomDateValidationProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('beforeDateField', function ($attribute, $value, $parameters, $validator) {
            return $this->checkDate($value, $parameters, $validator, 'lt');
        });

        Validator::extend('afterDateField', function ($attribute, $value, $parameters, $validator) {
            return $this->checkDate($value, $parameters, $validator, 'gt');
        });
    }

    /**
     * Check the date
     *
     * @param $value
     * @param $parameters
     * @param $validator
     * @param $direction
     * @return bool
     */
    function checkDate($value, $parameters, $validator, $direction)
    {
        $comparisonField = $this->getComparisonField($parameters);
        $dateFormat = $this->getDateFormat($parameters);


        $comparisonFieldValue = $this->getComparisonValue($validator, $comparisonField);

        if ($this->canCompare($value, $comparisonFieldValue)) {
            $dateFormat = 'Y-m-d';

            return Carbon::createFromFormat($dateFormat, $value)->{$direction}(
                Carbon::createFromFormat($dateFormat, $comparisonFieldValue)
            );
        }

        return true;
    }

    /**
     * Get Comparison Field
     *
     * @param $parameters
     * @return null
     * @throws ComparisonFieldIsRequiredException
     */
    protected function getComparisonField($parameters)
    {
        $comparisonField = isset($parameters[0]) ? $parameters[0] : null;

        if (empty($comparisonField)) {
            throw new ComparisonFieldIsRequiredException('Comparison field is missing');
        }

        return $comparisonField;
    }

    /**
     * Get Date Format
     *
     * @param $parameters
     * @return null
     * @throws ComparisonDirectionIsRequired
     */
    protected function getDateFormat($parameters)
    {
        $comparisonDirection = isset($parameters[1]) ? $parameters[1] : null;

        if (empty($comparisonDirection)) {
            throw new ComparisonDirectionIsRequired('Comparison field is missing');
        }

        return $comparisonDirection;
    }

    /**
     * Get comparison value
     *
     * @param $validator
     * @param $comparisonField
     * @return null
     */
    protected function getComparisonValue($validator, $comparisonField)
    {
        $comparisonFieldValue = isset($validator->getData()[$comparisonField]) ? $validator->getData()[$comparisonField] : null;
        return $comparisonFieldValue;
    }

    /**
     * Check if dates can be compared
     *
     * @param $value
     * @param $comparisonFieldValue
     * @return bool
     */
    protected function canCompare($value, $comparisonFieldValue)
    {
        return !empty($comparisonFieldValue) && !empty($value);
    }

}