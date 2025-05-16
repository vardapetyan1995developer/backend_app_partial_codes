<?php

namespace Tests\Modules\Order\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Modules\Order\Mail\OrderAssignmentScheduledMail;
use Tests\Modules\AbstractModuleTestCase as TestCase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

final class OrderAssignmentScheduledMailTest extends TestCase
{
    use LazilyRefreshDatabase;

    private function assertSeeOrderAssignmentDetails(Order $order, Mailable $mail): void
    {
        $mail->assertSeeInHtml(htmlspecialchars((string) $order->id));
        $mail->assertSeeInHtml(htmlspecialchars($order->workflow->value));
        $mail->assertSeeInHtml(htmlspecialchars($order->kitchen_number));
        $mail->assertSeeInHtml(htmlspecialchars($order->start_time->toDateTimeString()));
        $mail->assertSeeInHtml(htmlspecialchars($order->start_time->format('H:i')));
        $mail->assertSeeInHtml(htmlspecialchars($order->country));
        $mail->assertSeeInHtml(htmlspecialchars($order->city));
        $mail->assertSeeInHtml(htmlspecialchars($order->street));
        $mail->assertSeeInHtml(htmlspecialchars($order->postcode));
        $mail->assertSeeInHtml(htmlspecialchars($order->house_number));
        $mail->assertSeeInHtml(htmlspecialchars($order->addition));
        $mail->assertSeeInHtml(htmlspecialchars($order->instructions));
        $mail->assertSeeInHtml(htmlspecialchars($order->start_time->englishDayOfWeek));
        $mail->assertSeeInHtml(htmlspecialchars($order->start_time->englishMonth));
        $mail->assertSeeInHtml(htmlspecialchars($order->start_time->englishMonth));
        $mail->assertSeeInHtml(htmlspecialchars($order->start_time->format('d')));
        $mail->assertSeeInHtml(htmlspecialchars($order->start_time->format('Y')));

        $mail->assertSeeInHtml($order->worker->first_name);
    }

    public function testSeeMechanicOrderPlanningDetails(): void
    {
        $order = Order::factory()->mechanicAccepted()->escaped()->create();
        $mail = new OrderAssignmentScheduledMail($order);

        $this->assertSeeOrderAssignmentDetails($order, $mail);
    }
}
