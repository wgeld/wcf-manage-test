<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{

    public bool $isThemeDark = false;
    public bool $isThemeLight = false;



    public function themeClicked()
    {
        //this will give you toggling behavior
        $this->isThemeDark == false ? $this->isThemeDark = true : $this->isThemeDark = false;
    }
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.app');
    }
}
