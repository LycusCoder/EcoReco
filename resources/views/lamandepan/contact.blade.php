@extends('layouts.app')

@section('content')
    <div class="container py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Hubungi Kami</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Formulir Kontak -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Kontak Kami</h2>

                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf

                        <!-- Nama -->
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 mb-2">Nama Anda</label>
                            <input type="text" id="name" name="name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 mb-2">Alamat Email</label>
                            <input type="email" id="email" name="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <!-- Subjek -->
                        <div class="mb-4">
                            <label for="subject" class="block text-gray-700 mb-2">Subjek</label>
                            <input type="text" id="subject" name="subject"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <!-- Pesan -->
                        <div class="mb-4">
                            <label for="message" class="block text-gray-700 mb-2">Pesan</label>
                            <textarea id="message" name="message" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required></textarea>
                        </div>

                        <!-- Tombol Kirim -->
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                <!-- Informasi Kontak -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Informasi Kontak</h2>

                    <!-- Alamat -->
                    <div class="flex items-start mb-4">
                        <i class="fas fa-map-marker-alt text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <h3 class="font-medium">Alamat</h3>
                            <p class="text-gray-600">Jl. Pendidikan No.1, Pesurungan Lor, Kec. Margadana, Kota Tegal, Jawa Tengah 52142</p>
                        </div>
                    </div>

                    <!-- Didirikan -->
                    <div class="flex items-start mb-4">
                        <i class="fas fa-calendar-alt text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <h3 class="font-medium">Didirikan</h3>
                            <p class="text-gray-600">10 Oktober 2003</p>
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="flex items-start mb-4">
                        <i class="fas fa-phone-alt text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <h3 class="font-medium">Telepon</h3>
                            <p class="text-gray-600">0818-0450-0505</p>
                        </div>
                    </div>

                    <!-- Website -->
                    <div class="flex items-start mb-4">
                        <i class="fas fa-globe text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <h3 class="font-medium">Website</h3>
                            <p class="text-gray-600"><a href="https://stmik-tegal.ac.id" target="_blank">stmik-tegal.ac.id</a></p>
                        </div>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="flex items-start mb-4">
                        <i class="fas fa-clock text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <h3 class="font-medium">Jam Operasional</h3>
                            <p class="text-gray-600">Senin - Jumat: 08.00 - 16.00 WIB</p>
                            <p class="text-gray-600">Sabtu: 08.00 - 12.00 WIB</p>
                        </div>
                    </div>

                    <!-- Media Sosial -->
                    <div class="mt-6">
                        <h3 class="font-medium mb-2">Follow Us</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-blue-500 hover:text-blue-700 text-xl">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="text-blue-500 hover:text-blue-700 text-xl">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-blue-500 hover:text-blue-700 text-xl">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-blue-500 hover:text-blue-700 text-xl">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
