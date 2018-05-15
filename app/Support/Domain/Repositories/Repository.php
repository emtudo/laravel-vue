<?php

namespace Emtudo\Support\Domain\Repositories;

use Emtudo\Domains\UserModel;
use Emtudo\Support\Domain\Repositories\Contracts\Repository as RepositoryContract;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;
use Emtudo\Support\Exception\QueryFilterUndefinedException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Spatie\Fractal\Fractal;

abstract class Repository implements RepositoryContract
{
    /**
     * Model class for repo.
     *
     * @var string
     */
    protected $modelClass;

    /**
     * QueryFilter class for repo.
     *
     * @var string
     */
    protected $queryFilterClass;

    /**
     * @var bool
     */
    protected $userOnly = false;

    /**
     * @var array
     */
    protected $with = [];

    /**
     * @var mixed
     */
    protected $select;

    /**
     * @var mixed
     */
    protected $trashed = false;

    /**
     * @var int
     */
    protected $maxLimit = 100;

    /**
     * Switch between user only and global scopes.
     *
     * @param bool $userOnly
     *
     * @return $this
     */
    public function userOnly(bool $userOnly = true)
    {
        $this->userOnly = $userOnly;

        return $this;
    }

    /**
     * @param mixed      $select
     * @param null|mixed $value
     *
     * @return $this
     */
    public function select($value = null)
    {
        $this->select = $value;

        return $this;
    }

    public function setTrashed($value)
    {
        $this->trashed = $value;

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function newQuery()
    {
        $query = app()->make($this->modelClass)->newQuery();

        if ('only' === $this->trashed) {
            $query->onlyTrashed();
        }

        if ('with' === $this->trashed) {
            $query->withTrashed();
        }

        if ($this->userOnly) {
            $query->where('user_id', auth()->user()->id);
        }

        if (!empty($this->with)) {
            $query->with($this->with);
        }

        if (!empty($this->select)) {
            $query->select($this->select);
        }

        return $query;
    }

    public function with(array $data = [])
    {
        $this->with = $data;

        return $this;
    }

    /**
     * Query against deleted records only.
     *
     * @return $this
     */
    public function onlyTrashed()
    {
        $this->trashed = 'only';

        return $this;
    }

    /**
     * Query against all records, including deleted.
     *
     * @return $this
     */
    public function withTrashed()
    {
        $this->trashed = 'with';

        return $this;
    }

    /**
     * Reset trashed state so results will only include non-deleted records;.
     *
     * @return $this
     */
    public function withoutTrashed()
    {
        $this->trashed = false;

        return $this;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @param bool|int                                                                 $take
     * @param bool                                                                     $paginate
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function doQuery($query = null, $take = 15, $paginate = true)
    {
        if (null === $query) {
            $query = $this->newQuery();
        }

        if (true === $paginate) {
            return $query->paginate($take);
        }

        if ($take > 0 && false !== $take) {
            $query->take($take > $this->maxLimit ? $this->maxLimit : $take);
        }

        return $query->get();
    }

    /**
     * Creates a Model object with the $data information.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function factory(array $data = [])
    {
        $model = $this->newQuery()->getModel()->newInstance();

        $this->setModelData($model, $data);

        return $model;
    }

    /**
     * Performs the save method of the model
     * The goal is to enable the implementation of your business logic before the command.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return bool
     */
    public function save($model)
    {
        return $model->save();
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data = [])
    {
        $model = $this->factory($data);

        $this->save($model);

        return $model;
    }

    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param int  $take
     * @param bool $paginate
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAll($take = 15, $paginate = true)
    {
        return $this->doQuery(null, $take, $paginate);
    }

    /**
     * @param string      $column
     * @param null|string $key
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function pluck($column, $key = null)
    {
        return $this->newQuery()->lists($column, $key);
    }

    /**
     * Retrieves a record by his id
     * If fail is true $ fires ModelNotFoundException.
     *
     * @param string $id
     * @param bool   $fail
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByPublicID($id, $fail = false)
    {
        $id = decode_id($id);

        return $this->findByID($id, $fail);
    }

    /**
     * Retrieves a record by his id
     * If fail is true $ fires ModelNotFoundException.
     *
     * @param int  $id
     * @param bool $fail
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByID($id, $fail = false)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }

        return $this->newQuery()->find($id);
    }

    /**
     * Updated model data, using $data
     * The sequence performs the Model update.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array                               $data
     *
     * @return bool
     */
    public function update($model, array $data = [])
    {
        $this->setModelData($model, $data);

        return $this->save($model);
    }

    /**
     * Run the delete command model.
     * The goal is to enable the implementation of your business logic before the command.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param bool                                $force
     *
     * @return bool
     */
    public function delete($model, $force = false)
    {
        if ($force) {
            return $model->forceDelete();
        }

        return $model->delete();
    }

    /**
     * Run the delete command model.
     *
     * @param \Illuminate\Database\Eloquent\Collection $collection
     *
     * @return bool
     */
    public function deleteAll($collection)
    {
        return $collection->each(function ($item) {
            return $item->delete();
        });
    }

    /**
     * Run the restore command model.
     * The goal is to enable the implementation of your business logic before the command.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return bool
     */
    public function restore($model)
    {
        return $model->restore();
    }

    /**
     * @param \Illuminate\Contracts\Support\Arrayable|\Illuminate\Database\Eloquent\Model $item
     * @param array                                                                       $includes
     * @param Transformer                                                                 $transformer
     *
     * @return Fractal
     */
    public function transformItem($item, $includes = [], Transformer $transformer = null)
    {
        return fractal()->item($item, $transformer ?? $this->getTransformer())->parseIncludes($includes);
    }

    /**
     * @param \Illuminate\Support\Collection|LengthAwarePaginator $collection
     * @param bool                                                $paginated
     * @param array                                               $includes
     * @param Transformer                                         $transformer
     *
     * @return Fractal
     */
    public function transformCollection($collection, $paginated = false, $includes = [], Transformer $transformer = null)
    {
        if (is_a($collection, LengthAwarePaginator::class)) {
            return fractal()
                ->collection($collection, $transformer ?? $this->getTransformer())
                ->paginateWith(new IlluminatePaginatorAdapter($collection))
                ->parseIncludes($includes);
        }

        return fractal()
            ->collection($collection, $transformer ?? $this->getTransformer())
            ->parseIncludes($includes);
    }

    /**
     * Extract a UUID file from the request data.
     *
     * @param UserModel $model
     * @param array     $data
     * @param null      $field
     *
     * @return bool
     */
    public function extractAndAttachUUID($model, $data = [], $field = null)
    {
        // get the file uuid
        $UUID = array_get($data, $field, null);

        // return false if no UUID was found.
        if (!$UUID) {
            return false;
        }

        // do attach the UUID into the model.
        return $this->attachUUID($model, $UUID);
    }

    /**
     * Attach a uploaded file UUID into a model.
     *
     * @param UserModel $model
     * @param string    $UUID
     *
     * @return bool
     */
    public function attachUUID($model, $UUID = null)
    {
        // return false if the UUID passed was null
        // or if the model does not support attaching files
        // by it's UUID.
        if (!$UUID || !method_exists($model, 'attachUUID')) {
            return false;
        }

        // attach the UUID into the model.
        $model->attachUUID($UUID);

        // return true as attached.
        return true;
    }

    /**
     * @param array $data
     * @param bool  $idWithUUID
     *
     * @return [type]
     */
    public function insert(array $data = [], bool $idWithUUID = false)
    {
        $model = $this->newQuery()->getModel()->newInstance();
        if (!$idWithUUID) {
            return $model->insert($data);
        }

        $newData = array_map(function ($item) {
            return array_merge($item, [
                'id' => uuid(),
            ]);
        }, $data);
    }

    public function insertWithTimestamps(array $data = [], bool $idToUUID = false)
    {
        $newData = array_map(function ($item) {
            return array_merge($item, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $data);

        return $this->insert($newData, $idToUUID);
    }

    public function count()
    {
        return $this->newQuery()->count();
    }

    public function exists()
    {
        return $this->newQuery()->exists();
    }

    public function getAllByParams(array $params = [], $take = 15, $paginate = true)
    {
        if (!$this->queryFilterClass) {
            throw new QueryFilterUndefinedException();
        }

        $queryFilter = $this->queryFilterClass;
        $query = (new $queryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array                               $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function setModelData($model, array $data)
    {
        return $model->fill($data);
    }

    /**
     * @return \League\Fractal\TransformerAbstract
     */
    protected function getTransformer()
    {
        return app($this->modelClass)->getTransformer();
    }
}
