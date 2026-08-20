<?php

namespace App\Livewire\Pages\Settings;

use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Contracts\View\View;

#[Title('Appearance settings')]
class Appearance extends Component
{
    public function render(): View
    {
        return view('pages.settings.appearance');
    }
}
