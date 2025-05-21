<?php

namespace App\Http\Controllers\Pengurus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PotensiArea;
use App\Models\PotensiDesa;

class PengurusController extends Controller
{
    public function index(){
        return view('pengurus.index');
    }

    public function dashboard(){
        return view('pengurus.dashboard');
    }
    public function approvalIndex(){
       $potensiAreas = PotensiArea::where('is_approved', false)->get();
       $potensiDesas = PotensiDesa::where('is_approved', false)->get();
       return view('pengurus.approval.index', compact('potensiAreas', 'potensiDesas'));
    }
} 