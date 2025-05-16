<?php

namespace App\View\Components\Pdf\Invoice;

use App\Models\Invoice;
use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

final class Items extends Component
{
    public function __construct(
        public Invoice $invoice,
        public Collection $items,
    ) {
        //
    }

    public function render()
    {
        return view('components.pdf.invoice.items');
    }
}
