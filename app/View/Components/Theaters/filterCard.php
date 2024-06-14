<?php

namespace App\View\Components\Theaters;

use Illuminate\View\Component;

class filterCard extends Component
{

    public function __construct(
        public string $filterAction,
        public string $resetUrl,
        public ?string $name = null,
    ) {
        //
    }

    public function render()
    {
        return view('components.theater.filterCard');
    }
}
