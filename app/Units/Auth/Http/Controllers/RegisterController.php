<?php

namespace Emtudo\Units\Auth\Http\Controllers;

use Emtudo\Domains\Users\Repositories\UserRepository;
use Emtudo\Domains\Users\Transformers\AuthTransformer;
use Emtudo\Support\Http\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return \Emtudo\Domains\Users\User
     */
    protected function create(array $data)
    {
        $repository = app()->make(UserRepository::class);

        return $repository->create($data);
    }

    /**
     * The user has been registered.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed                    $user
     *
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $auth = $this->guard();

        return $this->respond->ok([
            'token' => $auth->issue(),
            'user' => $auth->user(),
        ], null, ['user'], [], [], new AuthTransformer());
    }
}
