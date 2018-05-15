<?php

namespace Emtudo\Domains\Users\Transformers;

use Emtudo\Domains\Users\User;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class UserTransformer extends Transformer
{
    public $availableIncludes = [];

    public function transform(User $user)
    {
        return [
            'id' => $user->publicId(),
            'email' => $user->email,
            'name' => $user->name,
            'is_admin' => $user->isAdmin(),
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'two_factor' => [
                'enabled' => $user->twoFactorEnabled(),
                'valid' => User::$twoFactoryIsValid,
            ],

            'deleted_at' => $user->getValue('deleted_at'),
        ];
    }
}
