<?php

namespace Emtudo\Support\Shield\Contracts;

interface Rules
{
    /**
     * @return mixed
     */
    public function defaultRules();

    /**
     * @param string $type
     * @param mixed  $callback
     *
     * @return array
     */
    public function byRequestType($type, $callback = null);
}
