<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-green-700">Tambah Potensi Area</h2>
    </div>
    <div class="bg-green-50 p-4 rounded-lg mb-6 border border-green-200">
        <p class="text-sm text-green-800">
            <span class="font-medium">Lokasi dipilih!</span> Tentukan detail potensi area pada titik ini.
        </p>
    </div>
    <form id="locationForm" method="POST" action="/potensi-area" class="space-y-4">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="mb-4">
            <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
            <input type="text" id="latitude" name="latitude" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" readonly>
        </div>
        <div class="mb-4">
            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
            <input type="text" id="longitude" name="longitude" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" readonly>
        </div>
        <div class="pt-4 flex flex-col gap-3">
            <a href="/potensi-area/create" class="w-full inline-flex justify-center items-center px-4 py-2 border border-black text-sm font-medium rounded-md shadow-sm text-black bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                <x-icons.plus class="h-5 w-5 mr-2"/>
                Tambah Potensi Area
            </a>
            <a href="/potensi-area" class="w-full inline-flex justify-center items-center px-4 py-2 border border-green-600 text-sm font-medium rounded-md text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                <x-icons.arrow class="h-5 w-5 mr-2"/>
                Lihat Semua Potensi Area
            </a>
            <button type="button" onclick="closeSidebar()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">
                <x-icons.close class="h-5 w-5 mr-2"/>
                Batal
            </button>
        </div>
    </form>
</div>
