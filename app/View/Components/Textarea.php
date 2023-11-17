<?php

namespace App\View\Components;

class Textarea extends FormControl
{
    public function __construct($name, $id = null, $value = '', $disabled = false, $bag = 'default')
    {
        parent::__construct($name, $id, $value, $disabled, $bag);
    }

    public function render()
    {
        return view('components.textarea');
    }
}
