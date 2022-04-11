<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface {

    /** 
     * find a resource by id
     * @param $relation
     * @param $id
     * @return model | null
    */

    public function findOne($id, $relation);

    /**
     * @param $id
     * @param null $relation
     * @param array|null $orderBy
     * @return mixed
     */
    public function findOrFail($id, $relation = null, array $orderBy = null);

    /**
     * get all resource
     * @param null $perPage
     * @param null $relation
     * @param array|null $orderBy
     * @return Collection
    */

    public function findAll($perPage = null, $relation = null, array $orderBy = null);

    /**
     * save a resource
     * @param  array $data
     * @return model
    */

    public function save(array $data);

    /**
     * update a resource
     * @param model
     * @param array $data
     * @return model
    */

    public function update(Model $model, array $data);

    /**
     * delete a resource
     * @param model
     * @return mixed
    */

    public function delete(Model $model);


}