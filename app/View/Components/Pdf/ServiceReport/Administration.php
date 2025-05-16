<?php

namespace App\View\Components\Pdf\ServiceReport;

use App\Models\Client;
use App\Models\Worker;
use App\Models\ServiceReport;
use Illuminate\View\Component;

final class Administration extends Component
{
    public function __construct(
        public Worker $worker,
        public Client $client,
        public ?ServiceReport $report,
    ) {
        //
    }

    public function render()
    {
        return view('components.pdf.service-report.administration');
    }
}
