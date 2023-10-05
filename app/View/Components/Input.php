<?php

namespace App\View\Components;

class Input extends FormControl
{
    public $type;

    public function __construct($name, $id = null, $value = '', $disabled = false, $bag = 'default', $type = 'text')
    {
        parent::__construct($name, $id, $value, $disabled, $bag);
        $this->type = $type;
    }

    public function render()
    {
        return view('components.input');
    }
}
