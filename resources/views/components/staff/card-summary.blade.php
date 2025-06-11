@php
    /**
     * Format angka ke notasi Indonesia yang lebih ringkas: Ribu, Juta, Miliar.
     * Berguna agar tampilan card tetap rapi meskipun angkanya besar.
     */
    if (!function_exists('formatIDRShort')) {
        function formatIDRShort($value) {
            if ($value >= 1000000000) {
                return round($value / 1000000000, 1) . ' Miliar';
            } elseif ($value >= 1000000) {
                return round($value / 1000000, 1) . ' Juta';
            } elseif ($value >= 1000) {
                // Untuk ribuan, kita format biasa saja agar lebih jelas
                return number_format($value, 0, ',', '.');
            }
            // Jika di bawah seribu, tampilkan angkanya langsung
            return number_format($value, 0, ',', '.');
        }
    }
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
    <div class="p-5 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="mt-2 text-2xl font-semibold text-gray-800">
                {{-- Cek apakah ini adalah nilai mata uang, jika iya format dengan fungsi di atas --}}
                @if(!empty($isCurrency))
                    Rp {{ formatIDRShort($value) }}
                @else
                    {{ number_format($value, 0, ',', '.') }}
                @endif
            </p>
        </div>
        {{-- Warna ikon dan background-nya dinamis sesuai parameter 'color' --}}
        <div class="p-3 rounded-full bg-{{ $color }}-100 text-{{ $color }}-600">
            <i class="fas {{ $icon }} text-xl"></i>
        </div>
    </div>
</div>