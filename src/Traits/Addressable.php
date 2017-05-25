<?php
namespace Midnite81\LaravelBase\Traits;

use Midnite81\LaravelBase\Exceptions\RelationshipNotDefinedException;

trait Addressable
{
    /**
     * Return the address block
     *
     */
    public function getAddressBlock()
    {
        $fields = $this->addressBlockFields();

        $output = [];

        if ($this instanceof \Illuminate\Database\Eloquent\Model) {
            foreach($fields as $field) {
                if (is_array($field)) {
                    $fieldValue = $this->getRelationalField($field);
                    if (! empty($fieldValue)) {
                        $output[] = $fieldValue;
                    }
                } else {
                    $fieldValue = $this->{$field};
                    if (! empty($fieldValue)) {
                        $output[] = $fieldValue;
                    }
                }
            }
        }

        return implode('<br>', $output);
    }

    public function getRelationalField($relationalArray)
    {
        list($relation, $field) = $relationalArray;
        if (! method_exists($this, $relation)) {
            throw new RelationshipNotDefinedException();
        }

        return $this[$relation][$field];
    }

    /**
     * Return address fields
     *
     * @return array
     */
    public function addressBlockFields()
    {
        return [
            'address_line_1',
            'address_line_2',
            'city',
            'county',
            'postcode',
        ];
    }
}