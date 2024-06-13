<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Song;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class layout extends Component
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
        // $songs = Song::all();
        // $categories = Category::all();
        return view('components.layout');
    }
}
