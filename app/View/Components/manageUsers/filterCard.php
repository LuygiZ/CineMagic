<?php

namespace App\View\Components\manageUsers;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class filterCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $types,
        public string $filterAction,
        public string $resetUrl,
        public ?string $type = null,
        public ?string $blocked = null,
        public ?string $name = null,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.manage-users.filterCard');
    }
}
