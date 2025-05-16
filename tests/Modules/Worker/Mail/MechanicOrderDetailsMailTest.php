<?php

namespace Tests\Modules\Worker\Mail;

use App\Models\File;
use App\Models\Order;
use App\Enums\AvailabilityPart;
use Modules\Worker\Mail\MechanicOrderDetailsMail;
use Tests\Modules\AbstractModuleTestCase as TestCase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

final class MechanicOrderDetailsMailTest extends TestCase
{
    use LazilyRefreshDatabase;

    private function assertSeeAssignmentDetails(Order $order, MechanicOrderDetailsMail $mail): void
    {
        $mail->assertSeeInHtml(htmlspecialchars($order->start_time->format('Y-m-d')));
        $mail->assertSeeInHtml(htmlspecialchars(AvailabilityPart::fromDateTime($order->start_time)->value));

        $mail->assertSeeInHtml(htmlspecialchars($order->country));
        $mail->assertSeeInHtml(htmlspecialchars($order->city));
        $mail->assertSeeInHtml(htmlspecialchars($order->street));
        $mail->assertSeeInHtml(htmlspecialchars($order->house_number));
        $mail->assertSeeInHtml(htmlspecialchars($order->instructions));

        foreach ($order->pipingDiagrams as $image) {
            $mail->assertSeeInHtml(htmlspecialchars($image->url));
        }
    }

    public function testSeeAssignmentDetails(): void
    {
        $order = Order::factory()
            ->mechanicAssigned()
            ->has(File::factory()->image()->count(5), 'pipingDiagrams')
            ->escaped()
            ->create();

        $mail = new MechanicOrderDetailsMail($order);

        $this->assertSeeAssignmentDetails($order, $mail);
    }
}
