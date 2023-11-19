<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    /**
     * The action.
     *
     * @var boolean
     */
    public $action;

    
    /**
     * The Checkbox.
     *
     * @var boolean
     */
    public $checkbox;

    /**
     * The keys.
     *
     * @var array
     */
    public $keys;

    /**
     * Create a new component instance.
     *
     * @param  boolean  $action
     * @param  boolean  $checkbox
     * @param  array  $keys
     * @return void
     */
    public function __construct($action = false, $checkbox = false, $keys)
    {
        $this->action = $action;        
        $this->checkbox =  $checkbox;
        $this->keys = $keys;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table');
    }
}
