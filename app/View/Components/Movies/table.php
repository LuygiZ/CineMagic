<?php

namespace App\View\Components\movies;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class table extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public object $movies,
        public bool $showView = true,
        public bool $showEdit = true,
        public bool $showDelete = true,
    )
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.movies.table');
    }
}
