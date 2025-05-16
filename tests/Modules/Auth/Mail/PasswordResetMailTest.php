<?php

namespace Tests\Modules\Auth\Mail;

use Illuminate\Mail\Mailable;
use Infrastructure\Utils\ClientUrl;
use Modules\Auth\Mail\PasswordResetMail;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Modules\AbstractModuleTestCase as TestCase;

final class PasswordResetMailTest extends TestCase
{
    use WithFaker;

    private function assertSeeUrl(string $email, string $token, Mailable $mail): void
    {
        $mail->assertSeeInHtml(htmlspecialchars(ClientUrl::resetPassword($email, $token)));
    }

    public function testPasswordResetMail(): void
    {
        $mail = new PasswordResetMail(
            $email = $this->faker->email(),
            $token = $this->faker->sha256(),
        );

        $this->assertSeeUrl($email, $token, $mail);
    }
}
