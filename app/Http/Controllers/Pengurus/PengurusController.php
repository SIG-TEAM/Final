<?php

namespace App\Http\Controllers\Pengurus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PotensiArea;

class PengurusController extends Controller
{
    public function index(){
        $potensiAreas = \App\Models\PotensiArea::all();
        return view('pengurus.index', compact('potensiAreas'));
    }
}