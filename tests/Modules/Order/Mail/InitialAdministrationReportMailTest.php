<?php

namespace Tests\Modules\Order\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Tests\Modules\AbstractModuleTestCase as TestCase;
use Modules\Order\Mail\InitialAdministrationReportMail;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

final class InitialAdministrationReportMailTest extends TestCase
{
    use LazilyRefreshDatabase;

    private function assertSeeOrderDetails(Order $order, Mailable $mail): void
    {
        $mail->assertSeeInHtml(htmlspecialchars($order->kitchen_number));
    }

    public function testInitialAdministrationReportMail(): void
    {
        $order = Order::factory()->mechanicFinishedInitialAdministration()->escaped()->create();
        $mail = new InitialAdministrationReportMail($order);

        $this->assertSeeOrderDetails($order, $mail);
    }
}
