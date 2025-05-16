<?php

namespace App\View\Components\Pdf\Invoice;

use App\Models\Client;
use Illuminate\View\Component;

final class Metadata extends Component
{
    public function __construct(
        public Client $client,
    ) {
        //
    }

    public function render()
    {
        return view('components.pdf.invoice.metadata');
    }
}
