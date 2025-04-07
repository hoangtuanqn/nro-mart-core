<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PreviewImage extends Component
{
    /**
     * Create a new component instance.
     */
    public string $title;
    public string $image;

    public function __construct(string $title = '', string $image = 'https://i.imgur.com/NpL6V6y.png')
    {
        $this->title = $title;
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.preview-image', [
            'title' => $this->title,
            'image' => $this->image
        ]);
    }
}
