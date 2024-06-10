<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TemperatureDisplay extends Component
{
    public $temperature;

    public function __construct($temperature)
    {
        // Simulate fetching temperature data
        $this->temperature = $temperature;
    }

    public function render()
    {
        return view('components.temperature-display');
    }
}
