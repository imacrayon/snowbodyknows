<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\AppendableAttributeValue;
use Illuminate\View\Component;

abstract class FormControl extends Component
{
    public $name;

    public $id;

    public $value;

    public $disabled;

    protected $invalid;

    public function __construct($name, $id = null, $value = '', $disabled = false, $bag = 'default')
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $sessionPath = self::sessionPath($name);
        $this->value = old($sessionPath, $value);
        $this->disabled = $disabled;
        $this->invalid = $this->errorBag($bag)->has($sessionPath);
    }

    public function formControlAttributes()
    {
        $invalidAttributes = [];
        if ($this->invalid) {
            $invalidAttributes['aria-invalid'] = 'true';
            $invalidAttributes['aria-describedby'] = new AppendableAttributeValue($this->name.'_error');
        }

        return $this->attributes->merge([
            'name' => $this->name,
            'id' => $this->id,
            'disabled' => $this->disabled,
        ] + $invalidAttributes);
    }

    protected function errorBag($name = 'default')
    {
        $bags = View::shared('errors', fn () => Session::get('errors', new ViewErrorBag));

        return $bags->getBag($name);
    }

    public static function sessionPath($name)
    {
        return trim(str_replace(['[', ']'], ['.', ''], $name), '.');
    }
}
