<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PerPageSelector extends Component
{
    public $perPage;
    public $route;
    
    /**
     * Create a new component instance.
     *
     * @param string $route
     * @param int $perPage
     */
    public function __construct($route, $perPage = 10)
    {
        $this->route = $route; // The route to submit the form
        $this->perPage = $perPage; // The current perPage value
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.per-page-selector');
    }
}
