<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TemperatureDisplay extends Component
{
    public $temperature;

    public function __construct()
    {
        // Simulate fetching temperature data
        $this->temperature = $this->fetchTemperature();
    }

    protected function fetchTemperature()
    {
        // Replace this with actual data fetching logic
        return 22; // Example temperature data
    }

    public function render()
    {
        return view('components.temperature-display');
    }
}
