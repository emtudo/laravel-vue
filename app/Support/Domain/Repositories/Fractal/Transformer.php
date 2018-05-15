<?php

namespace Emtudo\Support\Domain\Repositories\Fractal;

use Illuminate\Contracts\Support\Arrayable;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    public function __call($name, $arguments)
    {
        if ('transform' === $name && !method_exists($this, 'transform')) {
            $name = 'transformAbstract';
        }

        return $this->$name(...$arguments);
    }

    /**
     * @param mixed $data
     *
     * @return array
     */
    public function transformAbstract($data)
    {
        if (is_array($data)) {
            return $data;
        }

        if (is_object($data) && $data instanceof Arrayable) {
            return $data->toArray();
        }

        return (array) $data;
    }

    /**
     * Create a new item resource object.
     *
     * @param mixed                        $data
     * @param callable|TransformerAbstract $transformer
     * @param string                       $resourceKey
     *
     * @return Item
     */
    protected function item($data, $transformer, $resourceKey = null)
    {
        return new Item($data, $transformer, $resourceKey ?? false);
    }

    /**
     * Create a new collection resource object.
     *
     * @param mixed                        $data
     * @param callable|TransformerAbstract $transformer
     * @param string                       $resourceKey
     *
     * @return Collection
     */
    protected function collection($data, $transformer, $resourceKey = null)
    {
        return new Collection($data, $transformer, $resourceKey ?? false);
    }

    protected function parseAddress(array $data = [])
    {
        $newData = array_merge([
            'label' => null,
            'label2' => null,
            'city' => null,
            'district' => null,
            'street' => null,
            'state' => null,
            'number' => null,
            'zip' => null,
            'complement' => null,
        ], $data);
        if (empty($data)) {
            return $newData;
        }

        $label = $newData['street'].', '.$newData['number'];
        if (!empty($newData['complement'])) {
            $label .= ' - '.$newData['complement'];
        }
        $label2 = $newData['zip'].' - '
            .$newData['district'].' - '
            .$newData['city'].' - '
            .$newData['state'];

        return array_merge($newData, [
            'label' => $label,
            'label2' => $label2,
        ]);
    }

    protected function parsePhone(array $data = [])
    {
        return [
            'work' => $data['work'] ?? null,
            'home' => $data['home'] ?? null,
            'mobile' => $data['mobile'] ?? null,
        ];
    }
}
