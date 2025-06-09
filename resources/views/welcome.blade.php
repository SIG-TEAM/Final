@extends('layouts.app')

@section('head')
@include('components.map-script')
@endsection

@section('body_attributes')
onload="initMap()"
@endsection

@section('content')
<div class="fixed inset-0 w-screen h-screen m-0 p-0 overflow-hidden">
    <!-- Informasi UX di atas peta -->
    <div class="absolute top-4 left-1/2 z-30 -translate-x-1/2">
        <div class="bg-white/90 border border-green-200 rounded-lg shadow px-5 py-3 flex items-center space-x-3 text-green-900 text-sm font-medium">
            <svg class="w-5 h-5 text-green-700 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/>
            </svg>
            <span>
                <b>Panduan Peta:</b>
                Klik marker hijau untuk melihat detail potensi area.<br>
                @if(Auth::check() && Auth::user()->role === 'penduduk')
                    Klik pada peta untuk menambahkan potensi area baru.
                @else
                    Login sebagai <b>penduduk</b> untuk dapat menambahkan potensi area.
                @endif
            </span>
        </div>
    </div>
    <div class="flex h-full w-full overflow-hidden">
        <div id="map" class="flex-grow h-full w-full"></div>
        <div id="sidebar" class="w-0 bg-white transition-all duration-300 shadow-xl border-l border-gray-200 h-full">
            <div id="sidebar-content" class="p-5 h-full overflow-y-auto">
                <x-sidebar-default />
            </div>
        </div>
    </div>
    <!-- Template form sidebar, siap di-clone oleh JS -->
    <template id="potensi-area-form-template">
        @component('components.potensi-area-form')
        @endcomponent
    </template>
</div>
@endsection
