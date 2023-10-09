<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public function __construct(
        public $title = '',
    ) {
    }

    public function render(): View
    {
        return view('layouts.app');
    }
}
