<?php

namespace Tests\Modules\Order\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Modules\Order\Mail\ServiceReportMail;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Modules\AbstractModuleTestCase as TestCase;

final class ServiceReportMailTest extends TestCase
{
    use LazilyRefreshDatabase;

    private function assertSeeOrderDetails(Order $order, Mailable $mail): void
    {
        $mail->assertSeeInHtml(htmlspecialchars($order->kitchen_number));
    }

    public function testServiceReportMail(): void
    {
        $order = Order::factory()->serviceFinishedAdministration()->escaped()->create();
        $mail = new ServiceReportMail($order);

        $this->assertSeeOrderDetails($order, $mail);
    }
}
