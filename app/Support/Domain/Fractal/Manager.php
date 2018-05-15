<?php

namespace Emtudo\Support\Domain\Fractal;

use Emtudo\Support\Domain\Repositories\Fractal\Transformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\TransformerAbstract;
use Spatie\Fractal\Fractal;

class Manager
{
    public function isTransformable($resource)
    {
    }

    public function extractFirst($resource)
    {
        if ($this->isPaginated($resource) || $this->isCollection($resource)) {
            return $resource->first();
        }

        return $resource;
    }

    public function extractTransformer($resource)
    {
        $transformer = null;

        $evaluate = $this->extractFirst($resource);

        if ($evaluate && $this->isObject($evaluate) && method_exists($evaluate, 'getTransformer')) {
            $transformer = $evaluate->getTransformer();
        }

        return $transformer ?? new Transformer();
    }

    /**
     * @param $resource
     * @param array                    $includes
     * @param null|TransformerAbstract $transformer
     *
     * @return Fractal
     */
    public function transform($resource = [], $includes = [], TransformerAbstract $transformer = null)
    {
        if (!$transformer) {
            $transformer = $this->extractTransformer($resource);
        }

        if ($this->isPaginated($resource)) {
            return \fractal()->collection($resource, $transformer)
                ->paginateWith(new IlluminatePaginatorAdapter($resource))
                ->parseIncludes($includes);
        }

        if ($this->isCollection($resource)) {
            return \fractal()->collection($resource, $transformer)->parseIncludes($includes);
        }

        return \fractal()->item($resource, $transformer)->parseIncludes($includes);
    }

    protected function isCollection($resource)
    {
        return $resource instanceof Collection;
    }

    protected function isPaginated($resource)
    {
        return $resource instanceof LengthAwarePaginator;
    }

    protected function isObject($resource)
    {
        return is_object($resource);
    }

    protected function isModel($resource)
    {
        return $resource instanceof Model;
    }
}
