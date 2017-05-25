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

        if ($this instanceof Illuminate\Database\Eloquent\Model) {
            foreach($fields as $field) {
                if (is_array($field)) {
                    $this->getRelationalField($field);
                } else {
                    $output[] = $this->{$field};
                }

            }
        }

        return implode('<br>', $output);
    }

    public function getRelationalField($field)
    {
        if (! method_exists($this, $field[0])) {
            throw new RelationshipNotDefinedException();
        }

        return $this->{$field[0]}->{$field[1]};

    }

    /**
     * Return address fields
     *
     * @return array
     */
    public function addressBlockFields()
    {
        return [
            'street_1',
            'street_2',
            'city',
            'county',
            'postcode',
            'country_id',
        ];
    }
}