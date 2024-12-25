<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $user;

    public function __construct()
    {
        $this->user = Auth::user(); // Get the currently authenticated user
    }

    public function render()
    {
        return view('components.navbar'); // This returns the view for the navbar component
    }
}

