<?php

namespace App\View\Components;

use Closure;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

class Sidebar extends Component
{
    public array $items = [];
    public string $active = '';

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->items = config('sidebar');
        $this->active = Route::currentRouteName();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
