<?php

namespace Emtudo\Domains\Users\Database\Factories;

use Emtudo\Domains\Users\User;
use Emtudo\Support\Domain\Database\ModelFactory;

class UserFactory extends ModelFactory
{
    /**
     * @var User Factory for the User Model
     */
    protected $model = User::class;

    /**
     * Define the User's Model Factory.
     */
    public function fields()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => 'abc123',
        ];
    }
}
