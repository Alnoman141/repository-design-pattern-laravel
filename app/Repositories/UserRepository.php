<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends AbstractBaseRepository {

    // model name

    protected $modelName = User::class;
}