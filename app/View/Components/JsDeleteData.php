<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class JsDeleteData extends Component
{
    /**
     * Create a new component instance.
     */
    public $url;
    public function __construct(string $url = '')
    {
        //
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.js-delete-data', ['url' => $this->url]);
    }
}
