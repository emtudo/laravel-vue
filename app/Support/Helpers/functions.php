<?php

if (!function_exists('debug')) {
    function debug()
    {
        $values = func_get_args();
        if (1 === count($values)) {
            return Log::info(json_encode($values));
        }
        foreach ($values as $value) {
            Log::info(json_encode($value));
        }
    }
}
