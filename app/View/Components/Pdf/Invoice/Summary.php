<?php

namespace App\View\Components\Pdf\Invoice;

use Illuminate\Support\Carbon;
use Illuminate\View\Component;

final class Summary extends Component
{
    public function __construct(
        public int $invoiceId,
        public int $clientId,
        public bool $isCredit,
        public ?Carbon $sentAt = null,
    ) {
        //
    }

    public function render()
    {
        return view('components.pdf.invoice.summary');
    }
}
