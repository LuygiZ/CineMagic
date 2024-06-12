<?php

namespace App\View\Components\screenings;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    public function __construct(
        public array $alltheaters,
        public string $filterAction,
        public string $resetUrl,
        public ?string $theater = null,
        public ?string $movieName = null,
        public ?string $date = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.screenings.filterCard');
    }
}
