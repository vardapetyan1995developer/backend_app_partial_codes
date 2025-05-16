<?php

namespace Tests\Modules\Invoice\Mail;

use App\Models\Order;
use App\Models\Invoice;
use Illuminate\Mail\Mailable;
use Modules\Invoice\Mail\InvoiceMail;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Modules\AbstractModuleTestCase as TestCase;

final class InvoiceMailTest extends TestCase
{
    use LazilyRefreshDatabase;

    private function assertSeeOrderDetails(Order $order, Mailable $mail): void
    {
        $mail->assertSeeInHtml(htmlspecialchars($order->kitchen_number));
    }

    public function testInvoiceMail(): void
    {
        $invoice = Invoice::factory()->paid()->escaped()->create();
        $invoice = Invoice::withTotals()->find($invoice->id);

        $mail = new InvoiceMail($invoice);

        $this->assertSeeOrderDetails($invoice->order, $mail);
    }
}
