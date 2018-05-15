<?php

namespace Emtudo\Domains\Users\Queries;

use Emtudo\Support\Queries\BaseQueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class UserQueryFilter extends BaseQueryBuilder
{
    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    public function getQuery()
    {
        $this->applyWhere('id');
        $this->applyLike(['name', 'email']);
        $this->applyBoolean('is_admin');
        $this->query->orderBy('name');

        return $this->query;
    }
}
