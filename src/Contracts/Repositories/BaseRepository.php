<?php

namespace Midnite81\LaravelBase\Contracts\Repositories;

interface BaseRepository
{
    /**
     * Find record
     *
     * @param $id
     * @return mixed
     */
    public function findRecord($id);

    /**
     * Check to see if record exists
     *
     * @param $id
     * @return bool|mixed
     */
    public function recordExists($id);

    /**
     * Find record by Id
     *
     * @param      $id
     * @param bool $existCheck
     * @return mixed
     */
    public function findById($id, $existCheck = false);

    /**
     * Find by identifier
     *
     * @param $uuid
     * @param $checkExists
     * @return mixed
     */
    public function findByIdentifier($uuid, $checkExists = false);

    /**
     * Find by an array of credentials (return first)
     *
     * @param $array
     * @return mixed
     */
    public function findByCredentialsFirst($array = []);

    /**
     * Find by an array of credentials (return all)
     *
     * @param $array
     * @return mixed
     */
    public function findByCredentialsAll($array = []);

    /**
     * Create a record
     *
     * @param $data
     * @return static
     */
    public function create($data);

    /**
     * Update a record
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data);

    /**
     * Update or Create record
     *
     * @param $updateArray
     * @param $data
     * @return mixed
     */
    public function updateOrCreate($updateArray, $data);

    /**
     * Delete a record
     *
     * @param $id
     * @return bool
     */
    public function delete($id);

    /**
     * Get all items
     *
     * @param null $order
     * @return mixed
     */
    public function all($order = null);

    /**
     * Returns a key pair value list from the model
     *
     * @param $idColumn
     * @param $valueColumn
     * @return mixed
     */
    public function lists($idColumn, $valueColumn);

    /**
     * Adds withs to eager load
     *
     * @param $withs
     * @return \Midnite81\LaravelBase\Repositories\BaseRepository
     */
    public function with($withs);

    /**
     * Adds relations to count
     *
     * @param $withs
     * @return \Midnite81\LaravelBase\Repositories\BaseRepository
     */
    public function withCount($withs);

    /**
     * Adds in array of relationships that must exist on a record
     *
     * @param        $relation
     * @param string $operator
     * @param int    $value
     * @return \Midnite81\LaravelBase\Repositories\BaseRepository
     */
    public function has($relation, $operator = '>=', $value = 1);

    /**
     * @param       $scope
     * @param array $arguments
     * @return \Midnite81\LaravelBase\Repositories\BaseRepository
     */
    public function addScope($scope, $arguments = []);

    /**
     * Adds an array of whereHas queries
     *
     * @param $relation
     * @return \Midnite81\LaravelBase\Repositories\BaseRepository
     */
    public function whereHas($relation);

    /**
     * Orders the query
     *
     * @param        $column
     * @param string $direction
     * @return \Midnite81\LaravelBase\Repositories\BaseRepository
     */
    public function orderBy($column, $direction = 'ASC');
}