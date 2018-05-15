<?php

namespace Emtudo\Units\Auth\Http\Controllers;

use Emtudo\Domains\Users\Transformers\AuthTransformer;
use Emtudo\Support\Http\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request, Guard $auth)
    {
        $credentials = $request->only(['email', 'password']);
        if ($auth->attempt($credentials)) {
            return $this->respond->ok([
                'token' => $auth->issue(),
                'user' => $auth->user(),
            ], null, ['user'], [], [], new AuthTransformer());
        }

        return $this->respond->error('Erro ao autenticar.');
    }

    public function user()
    {
        return $this->respond->ok($this->user, null);
    }

    public function refresh(Guard $auth)
    {
        // refresh token.
        $token = $auth->refresh();

        if (!$token) {
            return $this->respond->error('Erro ao atualizar token.');
        }

        return $this->respond->ok([
            'token' => $token,
            'user' => $auth->user(),
        ], null, [], [], [], new AuthTransformer());
    }
}
