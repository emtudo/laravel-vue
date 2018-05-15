<?php

namespace Emtudo\Domains\Users\Repositories;

use Emtudo\Domains\Users\Contracts\UserRepository as Contract;
use Emtudo\Domains\Users\Queries\UserQueryFilter;
use Emtudo\Domains\Users\User;
use Emtudo\Support\Domain\Repositories\Repository;

class UserRepository extends Repository implements Contract
{
    protected $modelClass = User::class;
    protected $queryFilterClass = UserQueryFilter::class;

    public function setModelData($model, array $data)
    {
        parent::setModelData($model, $data);

        if (isset($data['password']) && !empty($data['password'])) {
            $model->password = $data['password'];
        }
    }
}
