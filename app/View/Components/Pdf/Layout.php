<?php

namespace App\View\Components\Pdf;

use Illuminate\View\Component;

final class Layout extends Component
{
    public function __construct(
        public ?string $title = null,
        public bool $hasFooter = true,
    ) {
        //
    }

    public function render()
    {
        return view('components.pdf.layout');
    }
}
