<?php

namespace Emtudo\Support\Hash;

use Hashids\Hashids;

class ID
{
    protected $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    protected $projectKey = '9cAzV8ccVCxZTL2PhW8sN9nD';

    protected $padLength = 7;

    protected $hash;

    public function __construct()
    {
        $this->hash = new Hashids($this->projectKey, $this->padLength, $this->alphabet);
    }

    public function encode($value)
    {
        return $this->hash->encode($value);
    }

    public function decode($hashed)
    {
        $value = array_first($this->hash->decode($hashed));

        return $value ?? $hashed;
    }
}
