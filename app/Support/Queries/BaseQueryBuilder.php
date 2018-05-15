<?php

namespace Emtudo\Support\Queries;

use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

abstract class BaseQueryBuilder
{
    /**
     * @var array
     */
    protected $params;

    /**
     * @var EloquentQueryBuilder|QueryBuilder
     */
    protected $query;

    /**
     * @param EloquentQueryBuilder|QueryBuilder $query
     * @param array                             $params
     */
    public function __construct($query, array $params = [])
    {
        $this->params = $params;
        $this->query = $query;
    }

    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    abstract public function getQuery();

    /**
     * @param array|string $field
     */
    public function applyBoolean($field)
    {
        if (is_array($field)) {
            return array_map(function ($item) {
                $this->applyBoolean($item);
            }, $field);
        }
        $value = array_get($this->params, $field, null);
        if (null === $value) {
            return;
        }

        if (null === filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)) {
            return;
        }
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        $this->query->where($this->getFieldWithTable($field), $value);
    }

    public function applyDateTimeStart($field, $key = null)
    {
        if (!$key) {
            $key = "{$field}_start";
        }

        $date = array_get($this->params, $key, null);

        if (!$date) {
            return;
        }

        $this->query->where($this->getFieldWithTable($field), '>=', $date.' 00:00:00');
    }

    public function applyDateTimeEnd($field, $key = null)
    {
        if (!$key) {
            $key = "{$field}_end";
        }
        $date = array_get($this->params, $key, null);

        if (!$date) {
            return;
        }

        $this->query->where($this->getFieldWithTable($field), '<=', $date.' 23:59:59');
    }

    protected function getFieldWithTable($field)
    {
        return $this->query->getModel()->getTable().'.'.$field;
    }

    /**
     * @param array|string $field
     */
    protected function applyLike($field)
    {
        if (is_array($field)) {
            return array_map(function ($item) {
                return $this->applyLike($item);
            }, $field);
        }
        $term = array_get($this->params, $field, null);

        if (!$term) {
            return;
        }

        $this->query->where($this->getFieldWithTable($field), 'LIKE', "%{$term}%");
    }

    /**
     * @param string $field
     * @param string $queryFilter
     * @param string $fieldId
     */
    protected function applyRelation($field, $queryFilter, $fieldId = 'id')
    {
        $relations = array_get($this->params, $field, []);
        if (empty($relations)) {
            return;
        }

        if (!is_array($relations)) {
            return;
        }

        $this->query->whereHas($field, function ($query) use ($queryFilter, $relations, $field, $fieldId) {
            $query->select($fieldId);

            return (new $queryFilter($query, $relations))->getQuery();
        });
    }

    /**
     * @param array|string $field
     */
    protected function applyWhere($field)
    {
        if (is_array($field)) {
            return array_map(function ($item) {
                $this->applyWhere($item);
            }, $field);
        }
        $term = array_get($this->params, $field, null);

        if (!$term) {
            return;
        }

        $this->query->where($this->getFieldWithTable($field), $term);
    }

    /**
     * @param array|string $field
     */
    protected function applyWhereIn($field)
    {
        if (is_array($field)) {
            return array_map(function ($item) {
                $this->applyWhereIn($item);
            }, $field);
        }
        $term = array_get($this->params, $field, []);

        if (!is_array($term) || empty($term)) {
            return;
        }

        $this->query->whereIn($this->getFieldWithTable($field), $term);
    }

    /**
     * @param array|string $field
     */
    protected function applyBetweenIn($field)
    {
        if (is_array($field)) {
            return array_map(function ($item) {
                $this->applyBetweenIn($item);
            }, $field);
        }
        $term = array_get($this->params, $field, []);

        if (!is_array($term) || empty($term)) {
            return;
        }

        if (2 === count($term)) {
            $this->query->whereBetween($this->getFieldWithTable($field), $term);

            return;
        }

        $this->query->where($this->getFieldWithTable($field), $term);
    }

    /**
     * @param array|string $field
     */
    protected function applyBetween($field)
    {
        if (is_array($field)) {
            return array_map(function ($item) {
                $this->applyBetween($item);
            }, $field);
        }
        $term = array_get($this->params, $field, []);

        if (!is_array($term) || 2 !== count($term)) {
            return;
        }

        $this->query->whereBetween($this->getFieldWithTable($field), $term);
    }
}
