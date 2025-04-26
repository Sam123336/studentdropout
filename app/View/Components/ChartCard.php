<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;



class ChartCard extends Component
{
    public $title;
    public $chartId;

    public function __construct($title, $chartId)
    {
        $this->title = $title;
        $this->chartId = $chartId;
    }

    public function render()
    {
        return view('components.chart-card');
    }
}
