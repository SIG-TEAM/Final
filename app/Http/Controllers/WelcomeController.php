<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PotensiArea;

class WelcomeController extends Controller
{
    public function index()
    {

        $approvedAreas = PotensiArea::where('status', 'approved')->get();
        return view('welcome', compact('approvedAreas'));
    }
}
