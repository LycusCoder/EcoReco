<div class="bg-white rounded-lg shadow-md overflow-hidden h-full flex flex-col">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800 flex items-center">
            <i class="fas fa-comment-alt mr-2 text-green-500"></i> Testimoni Terbaru
        </h3>
        <a href="#" class="text-sm text-blue-500 hover:text-blue-700 font-medium">Lihat Semua</a>
    </div>
    <div class="divide-y divide-gray-200 flex-grow">
        @forelse ($testimonials as $testimonial)
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold">
                        {{ Str::upper(substr($testimonial->user->name, 0, 1)) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ $testimonial->user->name }}</p>
                        <p class="text-sm text-gray-500 mt-1">"{{ Str::limit($testimonial->message, 40) }}"</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-gray-500">
                <i class="fas fa-comment-slash text-2xl mb-2"></i>
                <p>Belum ada testimoni.</p>
            </div>
        @endforelse
    </div>
</div>