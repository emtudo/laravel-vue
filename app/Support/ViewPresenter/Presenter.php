<?php

namespace Emtudo\Support\ViewPresenter;

use Carbon\Carbon;
use Illuminate\Support\Str;

abstract class Presenter
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $entity;

    /**
     * @param $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Allow for property-style retrieval.
     *
     * @param $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return $this->{$property}();
        }

        return $this->entity->{$property};
    }

    /**
     * @param Carbon $date
     * @param string $fallback
     *
     * @return string
     */
    protected function formatDateTime($date, $fallback = null)
    {
        return (null === $date) ? $fallback : $date->toDateTimeString();
    }

    /**
     * @param Carbon $date
     * @param string $fallback
     * @param string $format
     *
     * @return string
     */
    protected function formatDate($date, $fallback = null, $format = 'd/m/Y')
    {
        return (null === $date) ? $fallback : $date->format($format);
    }

    /**
     * Limit a string into chars.
     *
     * @param string $string
     * @param string $limit
     * @param string $ending
     *
     * @return string
     */
    protected function strLimitChars($string, $limit, $ending = '...')
    {
        return empty($limit) ? $string : Str::limit($string, $limit, $ending);
    }

    /**
     * Limit a string into words.
     *
     * @param string $string
     * @param string $limit
     * @param string $ending
     *
     * @return string
     */
    protected function strLimitWords($string, $limit, $ending = '...')
    {
        return empty($limit) ? $string : Str::words($string, $limit, $ending);
    }

    protected function cpf($document)
    {
        return $this->mask($document, '###.###.###-##');
    }

    protected function mask($value, $mask)
    {
        $masked = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
            if ('#' === $mask[$i]) {
                if (isset($value[$k])) {
                    $masked .= $value[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $masked .= $mask[$i];
                }
            }
        }

        return $masked;
    }
}
