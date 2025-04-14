<!-- Modal -->
<div x-show="showModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center p-4"
     @click.away="showModal = false">

    <div class="bg-white rounded-lg max-w-4xl w-full max-h-[80vh] overflow-y-auto backdrop-blur-lg">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold">Semua Kategori</h3>
                <button @click="showModal = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach ($allCategories as $category)
                    <div class="flex flex-col items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                        <img src="storage/{{ $category->icon }}" alt="icon" class="w-10 h-10 mb-2 object-contain">
                        <span class="text-sm text-center capitalize">{{ $category->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
