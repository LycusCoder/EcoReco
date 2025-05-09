{{-- resources/views/components/staff/card-statistic.blade.php --}}
<div
    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:-translate-y-1 transition-all duration-200">
    <div class="p-6 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
                <p id="{{ $key }}" class="text-3xl font-bold text-{{ $color }}-600 mt-2">
                    {{ $initial ?? 0 }}
                </p>
            </div>
            <div class="bg-{{ $color }}-100 p-4 rounded-full">
                <i class="fas {{ $icon }} text-2xl text-{{ $color }}-600"></i>
            </div>
        </div>
        <div class="mt-4 space-x-2">
            @foreach ($periods as $p => $lbl)
                <button
                    class="period-label hidden text-sm text-{{ $color }}-500 bg-{{ $color }}-100 px-3 py-1 rounded-full"
                    data-period="{{ $p }}">
                    {{ $lbl }}
                </button>
            @endforeach
        </div>
    </div>
</div>
