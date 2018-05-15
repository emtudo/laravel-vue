<?php

namespace Emtudo\Support\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as LaravelResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends LaravelResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage())
            ->line('Você recebeu esse email pois recebemos uma solicitação de recuperação de senha para a sua conta.')
            ->action('Recuperar Senha', $this->token, false)
            ->line('Se você não fez essa requisição, fique tranquilo, nenhum ação é necessária e você pode ignorar esse email.')
            ->subject('Recuperar Senha')
            ->template('auth::email.recover_password');
    }
}
