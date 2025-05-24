<?php

namespace App\Http\Controllers\Pengurus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index(){
        return view('pengurus.index');
    }
} 