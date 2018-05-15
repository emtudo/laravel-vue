<?php

namespace Emtudo\Units\Auth\Http\Controllers;

use Emtudo\Domains\Users\User;
use Emtudo\Support\Http\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, User::rules()->forgotPassword());

        User::$resetPasswordRoute = $request->get('route');

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $data = $request->only('email');
        $response = $this->broker()->sendResetLink(
            $data
        );

        return Password::RESET_LINK_SENT === $response
        ? $this->sendResetLinkResponse($response)
        : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param string $response
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return $this->respond->ok(['status' => 'Se existir o endereço de email cadastrado será enviado um link para recuperar a senha'], Response::HTTP_OK);
//        return $this->respond->ok(['status' => trans($response)], Response::HTTP_OK);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request
     * @param string $response
     *
     * @return JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return $this->respond->ok(['status' => 'Se existir o endereço de email cadastrado será enviado um link para recuperar a senha'], Response::HTTP_OK);
    }
}
