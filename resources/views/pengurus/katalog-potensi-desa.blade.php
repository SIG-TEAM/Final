
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Katalog Potensi Desa</h1>
    <div class="row">
        @foreach($potensiAreas as $potensi)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($potensi->foto)
                <img src="{{ asset('storage/' . $potensi->foto) }}" class="card-img-top" alt="{{ $potensi->nama }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title