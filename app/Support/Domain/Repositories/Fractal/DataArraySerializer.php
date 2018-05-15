<?php

namespace Emtudo\Support\Domain\Repositories\Fractal;

use League\Fractal\Serializer\DataArraySerializer as BaseSerializer;

class DataArraySerializer extends BaseSerializer
{
    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        if (false === $resourceKey) {
            return $data;
        }

        return ['data' => $data];
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        if (false === $resourceKey) {
            return $data;
        }

        return ['data' => $data];
    }

    /**
     * Serialize null resource.
     *
     * @return array
     */
    public function null()
    {
        return ['data' => []];
    }
}
