<?php

namespace Emtudo\Domains\Users\Transformers;

use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

/**
 * Class AuthTransformer.
 */
class AuthTransformer extends Transformer
{
    public $availableIncludes = ['user'];

    public function transform($auth)
    {
        return [
            'token' => $auth['token'],
        ];
    }

    public function includeUser($auth)
    {
        $user = $auth['user'];

        return $this->item($user, new UserTransformer());
    }
}
