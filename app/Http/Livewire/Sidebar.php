<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Sidebar extends Component
{
    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh-sidebar' => '$refresh',
    ];

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.sidebar');
    }
}
