<?php

namespace Emtudo\Units\Auth\Http\Controllers;

use Emtudo\Domains\Users\Transformers\AuthTransformer;
use Emtudo\Domains\Users\User;
use Emtudo\Support\Http\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class ResetPasswordController.
 *
 * Password reset (recovery) related logic.
 */
class ResetPasswordController extends Controller
{
    // use the main laravel trait to bootstrap the logic.
    use ResetsPasswords;

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return User::rules()->resetPassword();
    }

    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string                                      $password
     */
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => $password,
            'remember_token' => Str::random(60),
        ])->save();

        $this->guard()->login($user);
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param string $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse($response)
    {
        $auth = $this->guard();

        return $this->respond->ok([
            'token' => $auth->issue(),
            'user' => $auth->user(),
        ], null, ['user'], [], [], new AuthTransformer());
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request
     * @param string $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return $this->respond->notFound(trans($response));
    }
}
