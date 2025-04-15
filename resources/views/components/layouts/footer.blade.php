<footer class="bg-blue-600 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Tentang -->
            <div class="md:col-span-2">
                <h3 class="text-xl font-bold mb-4 flex items-center">
                    <i class="fas fa-leaf mr-2"></i> EcoReco
                </h3>
                <p class="text-blue-100">
                    Tempat berbelanja yang berkelanjutan. Kami berkomitmen untuk menyediakan produk ramah lingkungan
                    yang membantu mengurangi dampak lingkungan.
                </p>
            </div>
            <!-- Tautan Cepat -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Tautan Cepat</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}"
                            class="text-blue-100 hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="{{ route('recommendations') }}"
                            class="text-blue-100 hover:text-white transition-colors">Rekomendasi</a></li>
                    <li><a href="{{ route('about') }}" class="text-blue-100 hover:text-white transition-colors">Tentang
                            Kami</a></li>
                    <li><a href="{{ route('contact') }}"
                            class="text-blue-100 hover:text-white transition-colors">Kontak</a></li>
                </ul>
            </div>
            <!-- Kontak -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Hubungi Kami</h4>
                <ul class="space-y-2">
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-2 text-blue-200"></i>
                        <span>contact@ecoreco.com</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone mr-2 text-blue-200"></i>
                        <span>+62 123 4567 890</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-200"></i>
                        <span>Jl. Pendidikan No.1, Pesurunan Lor, Kec. Margadana, Kota Tegal, Jawa Tengah 52142</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-blue-500 mt-8 pt-6 flex flex-col md:flex-row items-center justify-between">
            <div class="mb-4 md:mb-0">
                &copy; {{ date('Y') }} EcoReco. Hak cipta dilindungi undang-undang.
            </div>
            <div class="flex space-x-4 text-xl">
                <a href="https://facebook.com/404xtrap" target="_blank" rel="noopener noreferrer"
                    class="text-white hover:text-blue-200 transition-colors" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://x.com/lycusbendln" target="_blank" rel="noopener noreferrer"
                    class="text-white hover:text-blue-200 transition-colors" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://linkedin.com/in/nourivex" target="_blank" rel="noopener noreferrer"
                    class="text-white hover:text-blue-200 transition-colors" aria-label="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="https://instagram.com/richlycus" target="_blank" rel="noopener noreferrer"
                    class="text-white hover:text-blue-200 transition-colors" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
