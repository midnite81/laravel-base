<?php
namespace Midnite81\LaravelBase\Repositories;

use Illuminate\Database\Query\Builder;

abstract class BaseRepository
{
    /**
     * An array of relationships to eager load.
     *
     * @var array
     */
    protected $withs = [];

    /**
     * An array of relationships to count.
     *
     * @var array
     */
    protected $withCounts = [];

    /**
     * An array of where has queries
     *
     * @var array
     */
    protected $whereHas = [];

    /**
     * A nested array of relationships that must exist on a record.
     *
     * @var array
     */
    protected $has = [];

    /**
     * A set of scopes to add to the query
     */
    protected $scopes = [];

    /**
     * The column to order the selects by.
     *
     * @var string
     */
    protected $orderBy;

    /**
     * The direction to order selects in.
     *
     * @var string
     */
    protected $orderByDirection = 'ASC';

    /**
     * Find record
     *
     * @param $id
     * @return mixed
     */
    public function findRecord($id)
    {
        if (is_object($id)) {
            return $id;
        }

        if (is_numeric($id) or $this->shouldBeNumber($id)) {
            return $this->findById($id);
        }

        if (is_string($id)) {
            return $this->findByIdentifier($id);
        }
    }

    /**
     * Check to see if record exists
     *
     * @param $id
     * @return bool|mixed
     */
    public function recordExists($id)
    {
        if (is_object($id)) {
            return true;
        }
        if (is_numeric($id) or $this->shouldBeNumber($id)) {
            return $this->findById($id, true);
        }
        if (is_string($id)) {
            return $this->findByIdentifier($id, true);
        }
    }

    /**
     * Find record by Id
     *
     * @param      $id
     * @param bool $existCheck
     * @return mixed
     */
    public function findById($id, $existCheck = false)
    {
        $record = $this->prepareQuery($this->model)->find($id);

        if ($existCheck) {
            return ! empty($record);
        }

        return $record;
    }

    /**
     * Find by identifier
     *
     * @param $uuid
     * @param $checkExists
     * @return mixed
     */
    public function findByIdentifier($uuid, $checkExists = false)
    {
        $record = $this->prepareQuery($this->model->where('identifier', $uuid))->first();

        if ($checkExists) {
            return ! empty($record);
        }

        return $record;
    }

    /**
     * Find by an array of credentials (return first)
     *
     * @param $array
     * @return mixed
     */
    public function findByCredentialsFirst($array = [])
    {
        return $this->prepareQuery($this->createBuilder($array))->first();
    }


    /**
     * Find by an array of credentials (return all)
     *
     * @param $array
     * @return mixed
     */
    public function findByCredentialsAll($array = [])
    {
        return $this->prepareQuery($this->createBuilder($array))->get();
    }

    /**
     * Create a record
     *
     * @param $data
     * @return static
     */
    public function create($data)
    {
        return $this->model->create($data);
    }


    /**
     * Update a record
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {

        $model = $this->findRecord($id);

        $model->update($data);

        return $model;

    }

    /**
     * Update or Create record
     *
     * @param $updateArray
     * @param $data
     * @return mixed
     */
    public function updateOrCreate($updateArray, $data)
    {
        return $this->model->updateOrCreate($updateArray, $data);
    }

    /**
     * Delete a record
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $model = $this->findRecord($id);

        if ($model) {
            return $model->delete();
        }
        return false;

    }

    /**
     * Get all items
     *
     * @param null $order
     * @return mixed
     */
    public function all($order = null)
    {
        $query = $this->createBuilder();

        if ( ! empty($order) and is_string($order)) {
            return $this->prepareQuery($query)->orderBy($order)->get();
        }

        if ( ! empty($order) and is_array($order)) {
            $build = $this->prepareQuery($query);

            foreach ($order as $orderItem) {
                $build = $build->orderBy($orderItem);
            }

            return $build->with($this->withs)->get();
        }

        return $this->prepareQuery($query)->get();
    }

    /**
     * Returns a key pair value list from the model
     *
     * @param $idColumn
     * @param $valueColumn
     * @return mixed
     */
    public function lists($idColumn, $valueColumn)
    {
        return $this->model->all()->pluck($valueColumn, $idColumn);
    }

    /**
     * Adds withs to eager load
     *
     * @param $withs
     * @return $this
     */
    public function with($withs)
    {
        if ( ! is_array($withs)) {
            $withs = func_get_args();
        }

        $this->withs = $withs;

        return $this;
    }

    /**
     * Adds relations to count
     *
     * @param $withs
     * @return $this
     */
    public function withCount($withs)
    {
        if ( ! is_array($withs)) {
            $withs = func_get_args();
        }

        $this->withCounts = $withs;

        return $this;
    }

    /**
     * Adds in array of relationships that must exist on a record
     *
     * @param        $relation
     * @param string $operator
     * @param int    $value
     * @return $this
     */
    public function has($relation, $operator = '>=', $value = 1)
    {
        $this->has[] = compact('relation', 'operator', 'value');

        return $this;
    }

    /**
     * @param       $scope
     * @param array $arguments
     * @return $this
     */
    public function addScope($scope, $arguments = [])
    {
        $this->scopes[$scope] = $arguments;

        return $this;
    }

    /**
     * Adds an array of whereHas queries
     *
     * @param $relation
     * @return $this
     */
    public function whereHas($relation)
    {
        if ( ! is_array($relation)) {
            $relation = func_get_args();
        }

        $this->whereHas[] = $relation;

        return $this;
    }


    /**
     * Orders the query
     *
     * @param        $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderBy = $column;
        $this->orderByDirection = $direction;

        return $this;
    }

    /**
     * Prepare the query for execution
     *
     * @param $query
     * @return mixed
     */
    protected function prepareQuery($query)
    {
        $query = $query->with($this->withs);

        if ($this->withCounts) {
            $query = $query->withCount($this->withCounts);
        }

        if ($this->orderBy) {
            $query = $query->orderBy($this->orderBy, $this->orderByDirection);
        }

        if ( ! empty($this->has)) {
            foreach ($this->has as $has) {
                $query = $query->has($has['relation'], $has['operator'], $has['value']);
            }
        }

        if ( ! empty($this->whereHas)) {
            foreach ($this->whereHas as $has) {
                $query = $query->whereHas($has[0], isset($has[1]) ? $has[1] : null);
            }
        }

        return $query;
    }

    /**
     * Determines if the ID should be a number.
     *
     * @param $id
     * @return bool
     */
    protected function shouldBeNumber($id)
    {
        $pattern = "/^[0-9]+?$/";

        if (preg_match($pattern, $id)) {
            return true;
        }

        return false;
    }

    /**
     * Create Builder
     *
     * @param $array
     * @return Builder
     */
    protected function createBuilder($array = [])
    {
        $builder = $this->model->newQuery();

        if (! empty($array)) {
            $builder->where($array);
        }

        if (! empty($this->scopes)) {
            foreach($this->scopes as $scope=>$args) {
                $builder->{$scope}($args);
            }
        }

        return $builder;
    }

}
