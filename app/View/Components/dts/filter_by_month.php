<?php

namespace App\View\Components\dts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class filter_by_month extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dts.filter_by_month');
    }
}
