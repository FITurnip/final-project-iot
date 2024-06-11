<?php
namespace App\View\Components;

use Illuminate\View\Component;

class BottleVisualization extends Component
{
    public $rotated;
    public $mountLevel;

    /**
     * Create a new component instance.
     *
     * @param bool $rotated
     * @param int $mountLevel
     * @return void
     */
    public function __construct($rotated = false, $mountLevel = 0)
    {
        $this->rotated = $rotated;
        $this->mountLevel = $mountLevel;
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
