{{-- resources/views/components/staff/recent-testimonials.blade.php --}}
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800 flex items-center">
            <i class="fas fa-comment-alt mr-2 text-green-500"></i> Testimoni Terbaru
        </h3>
        <a href="#" class="text-sm text-blue-500 hover:text-blue-700">Lihat
            Semua</a>
    </div>
    <div class="divide-y divide-gray-200">
        @foreach ($testimonials as $testimonial)
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                <div class="flex items-start">
                    <div
                        class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
                        {{ Str::upper(substr($testimonial->user->name, 0, 1)) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ $testimonial->user->name }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($testimonial->message, 50) }}</p>
                    </div>
                </div>
                <div class="flex items-center mt-2 text-xs text-gray-400">
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    {{ $testimonial->rating }}/5
                    <span class="mx-2">•</span>
                    {{ $testimonial->created_at->diffForHumans() }}
                </div>
            </div>
        @endforeach
    </div>
</div>
