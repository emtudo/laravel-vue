<?php

namespace Emtudo\Domains\Users\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class UserRules extends Rules
{
    public function defaultRules()
    {
        return [
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|string|max:255|email|unique:users',
            'password_confirmation' => 'required_with:password',
        ];
    }

    public function creating($callback = null)
    {
        return $this->returnRules([
            'password' => 'required|min:6|confirmed',
        ], $callback);
    }

    public function updating($callback = null)
    {
        return $this->returnRules([
            'email' => 'required|email',
            //'password' => 'sometimes|min:6|confirmed',
        ], $callback);
    }

    public function resetPassword($callback = null)
    {
        return $this->rules([
                'email' => 'required|email',
                'token' => 'required',
                'password' => 'required|min:6',
            ], $callback);
    }

    public function forgotPassword($callback = null)
    {
        return $this->rules([
                'email' => 'required|email',
                'route' => 'required|url',
            ], $callback);
    }
}
