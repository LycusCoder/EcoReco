<div class="testimonial-section bg-gradient-to-r from-indigo-50 to-blue-50 rounded-3xl p-8 md:p-12 shadow-xl relative">
    <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-10">Apa Kata Mereka?</h2>

    <!-- Grid Responsif -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($testimonials->take(3) as $testimonial)
            <div class="testimonial-card bg-white rounded-2xl p-6 md:p-8 transform transition-all duration-300 shadow-md hover:scale-105 hover:shadow-lg">
                <div class="flex items-center mb-4">
                    <img src="{{ $testimonial->image }}" alt="Profile Image"
                         class="w-12 h-12 rounded-full mr-4 flex-shrink-0" />
                    <div>
                        <p class="font-semibold text-gray-800">{{ $testimonial->user->name }}</p>
                        <div class="flex space-x-1 text-yellow-500">
                            @php
                                $rating = $testimonial->rating ?? rand(3, 5);
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Diposting pada: {{ $testimonial->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                <p class="text-gray-600 leading-relaxed">{{ $testimonial->message }}</p>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-10">
        <a href="{{ route('testimonials') }}"
           class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-full hover:from-blue-700 hover:to-indigo-700 transition duration-300 shadow-md">
            Lihat Semua Testimonial
        </a>
    </div>
</div>

<style scoped>
.testimonial-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url('https://www.transparenttextures.com/patterns/cubes.png');
    opacity: 0.1;
    z-index: -10;
}
</style>
