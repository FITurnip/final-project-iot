<?php
namespace App\View\Components;

use Illuminate\View\Component;

class BottleVisualization extends Component
{
    public $rotated;
    public $waterLevel;

    /**
     * Create a new component instance.
     *
     * @param bool $rotated
     * @param int $waterLevel
     * @return void
     */
    public function __construct($rotated = false, $waterLevel = 0)
    {
        $this->rotated = $rotated;
        $this->waterLevel = $waterLevel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.bottle-visualization');
    }
}
