<?php

namespace Emtudo\Units\Auth\Http\Controllers;

use Emtudo\Domains\Users\Jobs\TwoFactorJob;
use Emtudo\Domains\Users\Transformers\AuthTransformer;
use Emtudo\Domains\Users\User;
use Emtudo\Support\Http\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    public function activeTwoFactor(Guard $auth)
    {
        $this->dispatchCode();

        return $this->respond->ok($this->user);
    }

    public function disableTwoFactor(Guard $auth)
    {
        $user = $this->user;

        $user->two_factor = false;
        $user->save();

        return $this->refreshToken($auth, false);
    }

    public function verifyCode(Guard $auth)
    {
        $code = request()->get('code', null);
        $user = $this->user;

        $valid = $code === $user->two_factor_code;
        if ($valid) {
            $user->two_factor_code = null;
            $user->save();
        } else {
            $this->dispatchCode();

            return $this->respond->invalid(['code' => 'Código Inválido!']);
        }

        return $this->refreshToken($auth, true);
    }

    private function refreshToken(Guard $auth, bool $valid = true)
    {
        User::$twoFactoryIsValid = $valid;
        $token = $auth->refresh(null, ['two_factor' => $valid]);

        if (!$token) {
            return $this->respond->error('Erro ao atualizar token.');
        }

        return $this->respond->ok([
            'token' => $token,
            'user' => $auth->user(),
        ], null, ['user'], [], [], new AuthTransformer());
    }

    private function dispatchCode()
    {
        $user = $this->user;

        $user->two_factor = true;
        $user->two_factor_code = null;
        $user->save();

        dispatch(new TwoFactorJob($user));
    }
}
