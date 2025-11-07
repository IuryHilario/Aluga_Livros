<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Header extends Component
{

    public $title;
    public $icon;
    public $name;
    public $route;

    public function __construct($title, $icon, $name, $route)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->name = $name;
        $this->route = $route;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.header');
    }
}
