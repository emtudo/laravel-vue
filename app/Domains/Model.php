<?php

namespace Emtudo\Domains;

use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    use PivotEventTrait;

    /**
     * @return string
     */
    public function getTransformerClass()
    {
        return $this->transformerClass;
    }

    /**
     * @return League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return app()->make($this->getTransformerClass());
    }

    public function publicId()
    {
        return app('hash.id')->encode($this->id);
    }

    public function getValue($key)
    {
        $value = array_get($this->attributes, $key, null);

        if ($value instanceof Carbon) {
            return $value->format('Y-m-d H:i:s');
        }

        return $value;
    }
}
