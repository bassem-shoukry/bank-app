<?php

namespace App\Livewire\Layout;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navigation extends Component
{
    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.layout.navigation');
    }



    public function logout(): Application|Redirector|RedirectResponse
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }
}
