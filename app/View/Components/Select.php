<?php

namespace App\View\Components;

use Illuminate\Support\Collection;

class Select extends FormControl
{
    public $options;

    public $multiple;

    public $placeholder;

    public function __construct($name, $id = null, $value = '', $disabled = false, $bag = 'default', $options = [], $multiple = false, $placeholder = '')
    {
        parent::__construct($name, $id, $value, $disabled, $bag);
        $this->placeholder = $placeholder;
        $this->multiple = $multiple;
        if (is_string($options) && enum_exists($options)) {
            $options = collect($options::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->all();
        }
        $this->options = $options;
    }

    public function isSelected($option): bool
    {
        return match (true) {
            is_array($this->value) => in_array($option, $this->value),
            $this->value instanceof Collection => $this->value->contains($option),
            default => (string) $option === (string) $this->value
        };
    }

    public function render()
    {
        return view('components.select');
    }
}
