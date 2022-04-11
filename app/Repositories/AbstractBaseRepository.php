<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
/**
 * class AbstractBaseRepository
 * @package App\Repositories
*/
abstract class AbstractBaseRepository implements RepositoryInterface {

    /**
     * name of the model with absulate namespace
     * @var string
     */

     protected $modelName;

     /**
      *  @var model
      * Instance that extends Illuminate\Database\Eloquent\Model
    */

    protected $model;

    /**
     * Constructor
     * @throws Exception 
    */

    public function __construct(){
        $this->setModel();
    }

    /**
     * Instantiate Model
     * @throws Exception 
    */

    public function setModel(){
        // check if the class exists

        if(class_exists($this->modelName)){
            $this->model = new $this->modelName;
            // check object is instanceof Illuminate\Database\Eloquente\Model
            if(!$this->model instanceof Model){
                throw new Exception("{$this->modelName} must be the instance of Illuminate\Database\Eloquent\Model");
            }
        } else {
            throw new Exception("No Model Name Defined");
        }
    }

    /**
     * Get Model instance
     * @return Model 
    */

    public function getModel(){
        return $this->model;
    }

    /**
     * Find a resource by id
     * @param $id
     * @return Model|null 
    */

    public function findOne($id, $relation){
        return $this->findOneBy(['id' => $id], $relation);
    }

    /**
     * Find a resource by criteria
     * @param array $criteria 
     * @return Model/null
    */

    public function findOneBy(array $criteria, $relation = null){
        return $this->prepareModelForRelationAndOrder($relation)->where($criteria)->first();
    }

    /**
     * @param null $perPage
     * @param null $relation
     * @param array|null $orderBy
     * @return Collection|LengthAwarePaginator|Builder[]|Collection|Model[]
    */

    public function findAll($perPage = null, $relation = null, array $orderBy = null){
        $model = $this->prepareModelForRelationAndOrder($relation, $orderBy);

        if($perPage) {
            return $model->paginate($perPage);
        }

        return $model->get();
    }

    /**
     * @param $id
     * @param null $relation
     * @param array|null $orderBy
     * @return Builder|Builder[]|Collection|Model|Model[]|mixed
     */
    public function findOrFail($id, $relation = null, array $orderBy = null)
    {
        return $this->prepareModelForRelationAndOrder($relation, $orderBy)->findOrFail($id);
    }

    /**
     * Save a resource
     * @param array $data
     * @return Model 
    */

    public function save(array $data){
        return $this->model->create($data);
    }

    /**
     * Update a resource
     * @param Model $model
     * @param array $data
     * @return Model
    */

    public function update(Model $model, array $data){
        $fillAbleProperties = $this->model->getFillable();
        foreach ($data as $key => $value){
            // update only fillAble properties
            if(in_array($key, $fillAbleProperties)){
                $model[$key] = $value;
            }
        }
        // update the model
        $model->save();

        // return updated model
        return $model;
    }

    /**
     * Delete a resource
     * @param Model $model
     * @return mixed 
     * @throws Exception
    */

    public function delete(Model $model){
        return $model->delete();
    }

    /**
     * @param $relation
     * @param array|null $orderBy [[column], [direction]]
     * @return Builder|Model
    */

    public function prepareModelForRelationAndOrder($relation = null, array $orderBy = null){
        $model = $this->model;

        if($relation){
            $model = $model->with($relation);
        }

        if($orderBy){
            $model = $model->orderBy($orderBy['column'], $orderBy['direction']);
        }

        // return the model

        return $model;
    }
}