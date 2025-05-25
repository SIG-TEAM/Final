@extends('layouts.penguruslayout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-6">Approval Potensi Desa</h2>
            
            <!-- Tab Navigation -->
            <div class="mb-6 border-b">
                <div class="flex space-x-4">
                    <button 
                        class="py-2 px-4 border-b-2 border-green-500 tab-button active text-green-500"
                        id="titik-tab"
                        type="button"
                        data-tab="titik">
                        Potensi Titik
                    </button>
                    <button 
                        class="py-2 px-4 border-b-2 border-transparent tab-button text-gray-500"
                        id="area-tab"
                        type="button"
                        data-tab="area">
                        Potensi Area
                    </button>
                </div>
            </div>

            <!-- Potensi Titik Table -->
            <div id="titik-content" class="tab-content">
                @if($potensiDesas->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($potensiDesas as $potensi)
                            <tr>
                                <td class="px-6 py-4">{{ $potensi->nama_potensi }}</td>
                                <td class="px-6 py-4">{{ $potensi->kategori }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('potensi-desa.approve', $potensi->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                            Setujui
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500 text-center py-4">Tidak ada potensi titik yang menunggu persetujuan</p>
                @endif
            </div>

            <!-- Potensi Area Table -->
            <div id="area-content" class="tab-content hidden">
                @if($potensiAreas->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($potensiAreas as $area)
                            <tr>
                                <td class="px-6 py-4">{{ $area->nama }}</td>
                                <td class="px-6 py-4">{{ $area->kategori }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('pengurus.potensi-area.approve', $area->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                            Setujui
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500 text-center py-4">Tidak ada potensi area yang menunggu persetujuan</p>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.tab-button').forEach(btn => {
    btn.addEventListener('click', function() {
        // Sembunyikan semua konten tab
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Reset semua tab ke tidak aktif
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active', 'border-green-500', 'text-green-500');
            button.classList.add('border-transparent', 'text-gray-500');
        });

        // Tampilkan konten tab yang dipilih
        const tabName = this.getAttribute('data-tab');
        document.getElementById(`${tabName}-content`).classList.remove('hidden');

        // Aktifkan tab yang dipilih
        this.classList.add('active', 'border-green-500', 'text-green-500');
        this.classList.remove('border-transparent', 'text-gray-500');
    });
});
</script>
@endpush

<style>
.tab-button.active {
    border-bottom-width: 2px;
    border-color: rgb(34 197 94);
}

.tab-button {
    transition: all 0.3s ease;
}

.tab-button:hover {
    color: rgb(34 197 94);
}
</style>
@endsection