<?php

namespace App\Livewire\Pages\Settings;

use Livewire\Component;
use Illuminate\Contracts\View\View;

class DeleteUserForm extends Component
{
    public function render(): View
    {
        return view('pages.settings.delete-user-form');
    }
}
