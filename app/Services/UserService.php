<?php 

namespace App\Services;

use App\Entities\User;
use App\Repositories\UserRepository;
use App\Traits\CrudTrait;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService{

    use CrudTrait;

    private $userRepository;

    /**
     * userService constructor
     * @param UserRepository $userRepository 
    */

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
        $this->setActionRepository($this->userRepository);
    }

    /**
     * store model data
     * @param array $data
     * @return mixed
    */

    public function store(array $data){
        DB::transaction(function () use ($data){
            $user = $this->save($data);
        });

        return new Response("User has been created successfully");
    }

    /** 
     * update model data
     * @param Model $model
     * @param array $data
     * @return mixed
    */

    public function update($id, array $data){
        $user = $this->findOrFail($id);
        DB::transaction(function() use ($user, $data) {
            $this->update($user, $data);
        });

        return new Response("User has been updated successfully");
    }

    /** 
     * delete a model
     * @param Model $user
     * @return mixed
    */

    public function destroy($id){
        $user = $this->findOrFail($id);
        DB::transation(function() use ($user) {
            $user->delete();
        });

        return new Response("User has been deleted successfully");
    }

}