<?php

namespace App\View\Components;

use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;

class Error extends Component
{
    public $id;

    public $for;

    public $value;

    public $bag;

    public function __construct($for, $value = null, $bag = 'default')
    {
        $this->id = $for;
        $this->for = trim(str_replace(['[', ']'], ['.', ''], $for), '.');
        $this->value = $value;
        $this->bag = $bag;
    }

    public function messages(ViewErrorBag $errors)
    {
        $bag = $errors->getBag($this->bag);

        return $bag->has($this->field) ? $bag->get($this->field) : [];
    }

    public function render()
    {
        return view('components.error');
    }
}
