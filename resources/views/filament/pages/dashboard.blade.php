@vite(['resources/js/app.js'])
<x-filament::page>
    {{-- Tagline ucapan selamat datang --}}
    <div class="mb-6 text-xl font-semibold text-gray-700">
        Selamat datang, {{ auth()->user()->name }}! 👋
    </div>

    {{-- Widget Statistik --}}
    <div class="mb-6">
        @livewire(\App\Filament\Widgets\StatsOverview::class)
    </div>

    {{-- Peta Aduan --}}
    <div class="mb-6 bg-white rounded-lg shadow-md border-none border outline-none dark:bg-gray-800">
        @livewire(\App\Filament\Widgets\ComplaintMap::class)
    </div>

    {{-- Grafik Dusun & Kategori → 2 kolom --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            @livewire(\App\Filament\Widgets\HamletComplaintChart::class)
        </div>
        <div>
            @livewire(\App\Filament\Widgets\CategoryComplaintChart::class)
        </div>
    </div>
</x-filament::page>
