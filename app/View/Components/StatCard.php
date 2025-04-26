<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;




class StatCard extends Component
{
    public $title;
    public $value;
    public $icon;

    public function __construct($title, $value, $icon = null)
    {
        $this->title = $title;
        $this->value = $value;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('components.stat-card');
    }
}
