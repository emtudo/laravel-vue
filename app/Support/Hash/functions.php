<?php

if (!function_exists('encode_id')) {
    /**
     * @param string $id
     *
     * @return string
     */
    function encode_id($id)
    {
        if (empty($id)) {
            return null;
        }

        return app('hash.id')->encode($id);
    }
}

if (!function_exists('decode_id')) {
    /**
     * @param string $encodedId
     *
     * @return string
     */
    function decode_id($encodedId)
    {
        return app('hash.id')->decode($encodedId);
    }
}
