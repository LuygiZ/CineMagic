<?php

namespace App\View\Components\movies;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class filterCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $genres,
        public string $filterAction,
        public string $resetUrl,
        public ?string $genre_code = null,
        public ?string $year = null,
        public ?string $title = null,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.movies.filterCard');
    }
}
