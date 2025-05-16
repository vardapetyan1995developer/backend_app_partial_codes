<?php

namespace Tests\Modules\Worker\Mail;

use App\Models\Worker;
use Illuminate\Mail\Mailable;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Worker\Mail\WorkerCredentialsMail;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Modules\AbstractModuleTestCase as TestCase;

final class WorkerCredentialsMailTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    private function assertSeePassword(string $password, Mailable $mail): void
    {
        $mail->assertSeeInHtml(htmlspecialchars($password));
    }

    public function testSeeAssignmentDetails(): void
    {
        $worker = Worker::factory()->escaped()->create();
        $password = $this->faker->uuid();

        $mail = new WorkerCredentialsMail($worker, $password);

        $this->assertSeePassword($password, $mail);
    }
}
