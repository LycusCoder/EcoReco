<a href="{{ route('cart.index') }}"
    class="relative p-2 text-gray-700 hover:text-blue-600 transition-colors"
    aria-label="Shopping cart">
    <i class="fas fa-shopping-cart text-xl"></i>
    <span id="cart-count"
        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center
        {{ cart_count() > 0 ? '' : 'hidden' }}">
        {{ cart_count() }}
    </span>
</a>
