<?php

namespace Tests\Modules\Order\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Modules\Order\Mail\OrderAssignmentRequestMail;
use Tests\Modules\AbstractModuleTestCase as TestCase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

final class OrderAssignmentRequestMailTest extends TestCase
{
    use LazilyRefreshDatabase;

    private function assertSeeOrderDetails(Order $order, Mailable $mail): void
    {
        $mail->assertSeeInHtml(htmlspecialchars((string) $order->id));
        $mail->assertSeeInHtml(htmlspecialchars($order->workflow->value));
        $mail->assertSeeInHtml(htmlspecialchars($order->kitchen_number));
        $mail->assertSeeInHtml(htmlspecialchars($order->start_time->toDateTimeString()));
        $mail->assertSeeInHtml(htmlspecialchars($order->country));
        $mail->assertSeeInHtml(htmlspecialchars($order->city));
        $mail->assertSeeInHtml(htmlspecialchars($order->street));
        $mail->assertSeeInHtml(htmlspecialchars($order->postcode));
        $mail->assertSeeInHtml(htmlspecialchars($order->house_number));
        $mail->assertSeeInHtml(htmlspecialchars($order->addition));
        $mail->assertSeeInHtml(htmlspecialchars($order->instructions));
    }

    public function testSeeMechanicOrderDetails(): void
    {
        $order = Order::factory()->mechanic()->escaped()->create();
        $mail = new OrderAssignmentRequestMail($order);

        $this->assertSeeOrderDetails($order, $mail);
    }

    public function testSeeServiceOrderDetails(): void
    {
        $order = Order::factory()->mechanic()->escaped()->create();
        $mail = new OrderAssignmentRequestMail($order);

        $this->assertSeeOrderDetails($order, $mail);
    }
}
