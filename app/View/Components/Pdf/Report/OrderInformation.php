<?php

namespace App\View\Components\Pdf\Report;

use App\Models\Order;
use App\Models\Client;
use Illuminate\View\Component;

final class OrderInformation extends Component
{
    public function __construct(
        public Order $order,
        public Client $client,
    ) {
        //
    }

    public function render()
    {
        return view('components.pdf.report.order-information');
    }
}
