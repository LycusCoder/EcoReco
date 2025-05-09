{{-- resources/views/components/staff/card-summary.blade.php --}}
@php
    /**
     * Format angka ke notasi Indonesia: ribu, juta, miliar
     */
    if (!function_exists('formatIDRShort')) {
        function formatIDRShort($value) {
            if ($value >= 1000000000) {
                return round($value / 1000000000, 1) . ' Miliar';
            } elseif ($value >= 1000000) {
                return round($value / 1000000, 1) . ' Juta';
            } elseif ($value >= 1000) {
                return round($value / 1000, 1) . ' Ribu';
            }
            return number_format($value, 0, ',', '.');
        }
    }
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
    <div class="p-5 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="mt-2 text-2xl font-semibold text-gray-800">
                @if(!empty($isCurrency))
                    {{ formatIDRShort($value) }}
                @else
                    {{ $value }}
                @endif
            </p>
        </div>
        <div class="p-3 rounded-full bg-{{ $color }}-100 text-{{ $color }}-600">
            <i class="fas {{ $icon }} text-lg"></i>
        </div>
    </div>
</div>
