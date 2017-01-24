<?php
namespace Midnite81\LaravelBase\Repositories;

abstract class BaseRepository
{

    protected $uuid = false;

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
     * Find record by Id
     * @param $id
     * @return
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Find by identifier
     *
     * @param $uuid
     * @return mixed
     */
    public function findByIdentifier($uuid)
    {
        return $this->model->where('identifier', $uuid)->first();
    }

    /**
     * Find by an array of credentials (return first)
     */
    public function findByCredentialsFirst($array)
    {
        return $this->model->where($array)->first();
    }


    /**
     * Find by an array of credentials (return all)
     */
    public function findByCredentialsAll($array)
    {
        return $this->model->where($array)->get();
    }

    /**
     * Create a record
     * @param $data
     * @return static
     */
    public function create($data)
    {
        return $this->model->create($data);
    }


    /**
     * Update a record
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

        if (! empty($order) and is_string($order)) {
            return $this->model->orderBy($order)->get();
        }
        if (! empty($order) and is_array($order)) {
            $build = $this->model;
            foreach($order as $orderItem) {
                $build = $build->orderBy($orderItem);
            }
            return $build->get();
        }

        return $this->model->all();

    }

    public function lists($idColumn, $valueColumn)
    {
        return $this->model->all()->pluck($valueColumn, $idColumn);
    }

    public function usingUuid() {
        $this->uuid = true;
    }

    protected function shouldBeNumber($id)
    {
        $pattern = "/^[0-9]+?$/";

        if (preg_match($pattern, $id)) {
            return true;
        }

        return false;
    }


}