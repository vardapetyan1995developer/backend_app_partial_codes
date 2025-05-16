<?php

namespace App\View\Components\Email\Order;

use Illuminate\Support\Carbon;
use Illuminate\View\Component;

final class AssignmentDate extends Component
{
    public function __construct(
        public Carbon $date,
    ) {
        //
    }

    public function render()
    {
        return view('components.email.order.assignment-date');
    }
}
