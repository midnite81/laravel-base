<?php
namespace Midnite81\LaravelBase\Traits;

use Illuminate\Database\Eloquent\Model;
use Midnite81\LaravelBase\Exceptions\EloquentModelNotFoundException;
use Midnite81\LaravelBase\Exceptions\RelationshipNotDefinedException;

trait Addressable
{

    /**
     * Return the address block
     * @return string
     * @throws EloquentModelNotFoundException
     */
    public function getAddressBlock()
    {
        if (! $this instanceof Model) {
            throw new EloquentModelNotFoundException();
        }

        $fields = $this->addressBlockFields();

        $output = [];

        if (! empty($fields)) {
            foreach($fields as $field) {
                $fieldValue = $this->getAddressFieldValue($field);

                if (! empty($fieldValue)) {
                    $output[] = $fieldValue;
                }
            }
        }

        return implode('<br>', $output);
    }

    /**
     * Return address fields
     *
     * @return array
     */
    protected function addressBlockFields()
    {
        return [
            'address_line_1',
            'address_line_2',
            'city',
            'county',
            'postcode',
        ];
    }

    /**
     * Get address field value
     *
     * @param $field
     * @return mixed
     */
    protected function getAddressFieldValue($field)
    {
        if ($field instanceof \Closure) {
            return call_user_func($field, $this);
        }

        if (is_array($field)) {
            return $this->getRelationalField($field);
        }

        return $this->{$field};
    }

    /**
     * Return the field value from the relationship
     *
     * @param $relationalArray
     * @return mixed
     * @throws RelationshipNotDefinedException
     */
    protected function getRelationalField($relationalArray)
    {
        list($relation, $field) = $relationalArray;
        if (! method_exists($this, $relation)) {
            throw new RelationshipNotDefinedException();
        }

        return $this[$relation][$field];
    }
}