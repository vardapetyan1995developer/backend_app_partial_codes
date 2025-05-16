<?php

namespace App\View\Components\Pdf;

use Illuminate\View\Component;

final class Header extends Component
{
    public function __construct(
        public ?string $title = null,
    ) {
        //
    }

    public function render()
    {
        return view('components.pdf.header');
    }
}
