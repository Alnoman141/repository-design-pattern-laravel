<?php
 
 namespace App\Traits;

use App\Repositories\AbstractBaseRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait CrudTrait {

    /**
     * Instance that extends App\Repositories\AbstractBaseRepository
     * @var AbstractBaseRepository
    */

    private $actionRepository;

    /**
     * @param  AbstractBaseRepository $actionRepository
    */

    public function setActionRepository(AbstractBaseRepository $actionRepository){
        $this->actionRepository = $actionRepository; 
    }

    /**
     * @param $id
     * @param null $relation
     * @return Model|null
    */

    public function findOne($id, $relation = null){
        return $this->actionRepository->findOne($id, $relation);
    }

    /**
     * @param null $perPage
     * @param null $relation
     * @param array|null $orderBy [[column], [direction]]
     * @return \App\Repositories\Contracts\Collection|LengthAwarePaginator|Builder[]|Collection|Model[]
    */

    public function findAll($perPage = null, $relation = null, array $orderBy = null){
        return $this->actionRepository->findAll($perPage, $relation, $orderBy);
    }

    /**
     * @param array $data
     * @return Model 
    */

    public function save(array $data){
        return $this->actionRepository->save($data);
    }

    /**
     * @param Model $model
     * @param array $data
     * @return Model|mixed 
    */

    public function update(Model $model, array $data){
        // create or update project assigned role service data
        return $this->actionRepository->update($model, $data);
    }

    /** 
     * @param $id
     * @return bool|mixed|null
     * @throws Exception
    */

    public function delete($id){
        $model = $this->actionRepository->findOrFail($id);
        return $model->delete();
    }

}