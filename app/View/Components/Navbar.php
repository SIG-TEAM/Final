<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Kategori;

class Navbar extends Component
{
    public $categories;

    public function __construct()
    {
        $this->categories = Kategori::all();
    }

    public function render()
    {
        return view('components.navbar');
    }
}
