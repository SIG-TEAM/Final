@props(['area'])
<div class="space-y-3 font-[Inter,sans-serif] text-[#111827]">
    <div class="mb-2">
        <h1 class="text-xl font-extrabold text-[#047857] uppercase tracking-wide">Informasi Potensi Area</h1>
    </div>
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-[#059669]">{{ $area['nama'] ?? '' }}</h2>
        <button onclick="closeSidebar()" class="text-gray-500 hover:text-red-600 text-xl font-bold">&times;</button>
    </div>
    <div class="text-sm text-[#059669] font-semibold">
        <b>{{ $area['nama'] ?? '' }}</b>
    </div>
    <div class="text-[#059669] font-semibold">{{ $area['kategori'] ?? '-' }}</div>
    @if(!empty($area['foto']))
        <div>
            <img src="{{ \Illuminate\Support\Str::startsWith($area['foto'], 'http') ? $area['foto'] : '/storage/' . $area['foto'] }}" alt="Foto {{ $area['nama'] ?? '' }}" class="rounded shadow max-h-48 max-w-full mx-auto">
        </div>
    @endif
    <div class="text-[#6B7280]">{{ $area['deskripsi'] ?? '-' }}</div>
    <div class="text-[#6B7280] text-sm">
        <b>Alamat:</b> {{ $area['alamat'] ?? '-' }}
    </div>
    <div class="text-xs text-[#6B7280]">
        <b>Koordinat:</b> <span class="font-mono">{{ $area['latitude'] ?? '-' }}, {{ $area['longitude'] ?? '-' }}</span>
    </div>
    @if(!empty($area['polygon']) && is_array($area['polygon']) && count($area['polygon']) > 2)
        <div class="text-xs text-[#6B7280]">
            <b>Polygon:</b> {{ count($area['polygon']) }} titik
        </div>
    @endif
    @if(Auth::check() && Auth::user()->role !== 'penduduk')
        <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded text-yellow-800 flex items-start space-x-3 animate-pulse">
            <svg class="w-6 h-6 text-yellow-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
            </svg>
            <div>
                <div class="font-bold mb-1">Ingin Menjadi Penduduk?</div>
                <div>
                    Untuk dapat menambahkan potensi area, Anda harus menjadi <b>penduduk</b>.<br>
                    Silakan ajukan permintaan pada halaman 
                    <a href="/profile" class="underline text-[#059669] font-semibold hover:text-[#047857]">Profile</a> Anda.
                </div>
            </div>
        </div>
    @endif
</div>
