<?php

namespace Emtudo\Support\Domain\Repositories\Contracts;

use Emtudo\Domains\UserModel;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Fractal\Fractal;

interface Repository
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function newQuery();

    /**
     * Creates a Model object with the $data information.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function factory(array $data = []);

    /**
     * Creates a Model object with the $data information.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data = []);

    /**
     * Performs the save method of the model
     * The goal is to enable the implementation of your business logic before the command.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return bool
     */
    public function save($model);

    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param int  $take
     * @param bool $paginate
     *
     * @return \Illuminate\Pagination\AbstractPaginator|\Illuminate\Support\Collection
     */
    public function getAll($take = 15, $paginate = true);

    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Pagination\AbstractPaginator|\Illuminate\Support\Collection
     */
    public function getAllByParams(array $params = [], $take = 15, $paginate = true);

    /**
     * Retrieves a record by his id
     * If $fail is true fires ModelNotFoundException. When no record is found.
     *
     * @param int  $id
     * @param bool $fail
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByID($id, $fail = true);

    /**
     * @param string      $column
     * @param null|string $key
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function pluck($column, $key = null);

    /**
     * Updated model data, using $data
     * The sequence performs the Model update.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array                               $data
     *
     * @return bool
     */
    public function update($model, array $data = []);

    /**
     * Run the delete command model.
     * The goal is to enable the implementation of your business logic before the command.
     *
     * @param \Illuminate\Database\Eloquent\Model
     * @param mixed $model
     *
     * @return bool
     */
    public function delete($model);

    /**
     * @param \Illuminate\Contracts\Support\Arrayable|\Illuminate\Database\Eloquent\Model $item
     * @param array                                                                       $includes
     * @param Transformer                                                                 $transformer
     *
     * @return Fractal
     */
    public function transformItem($item, $includes = [], Transformer $transformer = null);

    /**
     * @param \Illuminate\Support\Collection|LengthAwarePaginator $collection
     * @param bool                                                $paginated
     * @param array                                               $includes
     * @param Transformer                                         $transformer
     *
     * @return Fractal
     */
    public function transformCollection($collection, $paginated = false, $includes = [], Transformer $transformer = null);

    /**
     * Switch between user only and global scopes.
     *
     * @param bool $userOnly
     *
     * @return $this
     */
    public function userOnly(bool $userOnly = true);

    /**
     * Query against deleted records only.
     *
     * @return $this
     */
    public function onlyTrashed();

    /**
     * Query against all records, including deleted.
     *
     * @return $this
     */
    public function withTrashed();

    /**
     * Reset trashed state so results will only include non-deleted records;.
     *
     * @return $this
     */
    public function withoutTrashed();

    /**
     * Run the restore command model.
     * The goal is to enable the implementation of your business logic before the command.
     *
     * @param \Illuminate\Database\Eloquent\Model
     * @param mixed $model
     *
     * @return bool
     */
    public function restore($model);

    /**
     * Extract a UUID file from the request data.
     *
     * @param UserModel $model
     * @param array     $data
     * @param null      $field
     *
     * @return bool
     */
    public function extractAndAttachUUID($model, $data = [], $field = null);

    /**
     * Attach a uploaded file UUID into a model.
     *
     * @param UserModel $model
     * @param string    $UUID
     *
     * @return bool
     */
    public function attachUUID($model, $UUID = null);

    /**
     * Retrieves a record by his id
     * If fail is true $ fires ModelNotFoundException.
     *
     * @param string $id
     * @param bool   $fail
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByPublicID($id, $fail = false);

    /**
     * @return bool
     */
    public function exists();

    /**
     * @return int
     */
    public function count();
}
