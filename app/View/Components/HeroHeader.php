<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeroHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public $title, $description;
    public function __construct($title, $description)
    {
        //
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $title = $this->title;
        $description = $this->description;
        return view('components.hero-header', compact('title', 'description'));
    }
}
