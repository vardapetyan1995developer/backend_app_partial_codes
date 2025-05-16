<?php

namespace Modules\Auth\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Infrastructure\Utils\ClientUrl;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

final class PasswordResetMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $email,
        public string $token,
    ) {
        //
    }

    public function build()
    {
        return $this
            ->subject(trans('messages.mail.password_reset.subject'))
            ->markdown('email.auth.password-reset', [
                'email' => $this->email,
                'url' => ClientUrl::resetPassword($this->email, $this->token),
            ]);
    }
}
