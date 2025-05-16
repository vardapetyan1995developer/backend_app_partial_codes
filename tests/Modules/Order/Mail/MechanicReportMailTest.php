<?php

namespace Tests\Modules\Order\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Modules\Order\Mail\MechanicReportMail;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Modules\AbstractModuleTestCase as TestCase;

final class MechanicReportMailTest extends TestCase
{
    use LazilyRefreshDatabase;

    private function assertSeeOrderDetails(Order $order, Mailable $mail): void
    {
        $mail->assertSeeInHtml(htmlspecialchars($order->kitchen_number));
    }

    public function testMechanicReportMail(): void
    {
        $order = Order::factory()->mechanicFinishedFinalAdministration()->escaped()->create();
        $mail = new MechanicReportMail($order);

        $this->assertSeeOrderDetails($order, $mail);
    }
}
