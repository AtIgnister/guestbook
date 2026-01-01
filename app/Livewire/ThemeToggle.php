<?php

namespace App\Livewire;

use Livewire\Component;

class ThemeToggle extends Component
{

    public function toggle(){
        $themeValue = session('theme');

        if($themeValue==='dark'){
            session(['theme' => 'light']);
        }
        else{
            session(['theme' => 'dark']);
        }
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }
}
