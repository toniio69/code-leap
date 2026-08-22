<?php

namespace App\Livewire\Pages\Settings;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class DeleteUserForm extends Component
{
    public function render(): View
    {
        return view('pages.settings.delete-user-form');
    }
}
