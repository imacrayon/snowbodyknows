<?php

namespace App\View\Components;

use Illuminate\Support\Collection;

class Checkbox extends FormControl
{
    public $checked;

    public function __construct($name, $id = null, $value = '1', $disabled = false, $bag = 'default', $checked = false)
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->value = $value;
        $sessionPath = self::sessionPath($name);
        $this->disabled = $disabled;
        $this->invalid = $this->errorBag($bag)->has($sessionPath);
        $checked = old($sessionPath, $checked);
        $this->checked = match (true) {
            is_array($checked) => in_array($value, $checked),
            $checked instanceof Collection => $checked->contains($value),
            default => $checked
        };
    }

    public function render()
    {
        return view('components.checkbox');
    }
}
