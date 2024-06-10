<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Thermometer extends Component
{
    public $percentage;
    public $temperature;

    /**
     * Create a new component instance.
     *
     * @param  int  $percentage
     * @param  string  $temperature
     * @return void
     */
    public function __construct($percentage, $temperature)
    {
        $this->percentage = $percentage;
        $this->temperature = $temperature;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return <<<'blade'
            <div class="thermometer" style="width: 100px; height: 300px; background-color: #f5f5f5; border-radius: 10px; border: 1px solid #ccc; position: relative;">
                <div class="level" style="background-color: #007bff; width: 100%; position: absolute; bottom: 0; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; height: {{ $percentage }}%;"></div>
            </div>
            <div class="temperature" style="text-align: center; margin-top: 20px; font-weight: bold;">
                <span>{{ $temperature }}</span>
            </div>
        blade;
    }
}
