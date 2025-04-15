@extends('layouts.app')

@section('content')
    <div class="container py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section with Animation -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 mb-4 animate__animated animate__fadeInDown">
                    <i class="fas fa-shopping-cart text-blue-500 mr-2"></i> Tentang EcoReco
                </h1>
                <p class="text-lg text-gray-600 animate__animated animate__fadeIn animate__delay-1s">
                    Platform e-commerce cerdas dengan sistem rekomendasi produk berbasis pola pembelian pengguna.
                </p>
            </div>

            <!-- Our Story Section with Icon -->
            <div
                class="bg-white rounded-xl shadow-lg p-8 mb-10 transition duration-500 hover:shadow-xl animate__animated animate__fadeIn">
                <div class="flex items-start">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <i class="fas fa-book-open text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Kisah Kami</h2>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            <i class="fas fa-quote-left text-blue-200 mr-1"></i>
                            EcoReco didirikan pada tahun 2025 dengan tujuan untuk merevolusi pengalaman belanja online melalui teknologi AI dan algoritma canggih.
                        </p>
                        <p class="text-gray-600 leading-relaxed">
                            Kami menggunakan Collaborative Filtering dan Apriori Algorithm untuk memberikan rekomendasi produk yang relevan berdasarkan riwayat pembelian pengguna. Dengan ini, kami membantu pengguna menemukan produk yang tepat dengan cepat dan efisien.
                            <i class="fas fa-quote-right text-blue-200 ml-1"></i>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Our Mission Section with Cards -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-10 animate__animated animate__fadeIn">
                <h2 class="text-2xl font-semibold mb-6 text-gray-800 flex items-center">
                    <i class="fas fa-bullseye text-blue-600 mr-3"></i> Misi Kami
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div
                        class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500 hover:bg-blue-100 transition duration-300">
                        <div class="flex items-start">
                            <i class="fas fa-brain text-blue-600 text-2xl mr-4 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-lg mb-2 text-gray-800">Personalisasi Rekomendasi</h3>
                                <p class="text-gray-600">Menggunakan Collaborative Filtering untuk memberikan rekomendasi produk yang relevan.</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500 hover:bg-blue-100 transition duration-300">
                        <div class="flex items-start">
                            <i class="fas fa-chart-bar text-blue-600 text-2xl mr-4 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-lg mb-2 text-gray-800">Analisis Pola Pembelian</h3>
                                <p class="text-gray-600">Mengidentifikasi pola pembelian umum menggunakan Apriori Algorithm.</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500 hover:bg-blue-100 transition duration-300">
                        <div class="flex items-start">
                            <i class="fas fa-check-double text-blue-600 text-2xl mr-4 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-lg mb-2 text-gray-800">Keakuratan dan Efisiensi</h3>
                                <p class="text-gray-600">Memastikan rekomendasi produk didasarkan pada data terkini.</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500 hover:bg-blue-100 transition duration-300">
                        <div class="flex items-start">
                            <i class="fas fa-user-shield text-blue-600 text-2xl mr-4 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-lg mb-2 text-gray-800">Pengalaman Pengguna</h3>
                                <p class="text-gray-600">Menyederhanakan proses pencarian produk dengan rekomendasi otomatis.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="bg-blue-600 rounded-xl shadow-lg p-8 mb-10 text-white animate__animated animate__fadeIn">
                <h2 class="text-2xl font-semibold mb-6 flex items-center">
                    <i class="fas fa-chart-line mr-3"></i> Dalam Angka
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="p-4">
                        <div class="text-3xl font-bold mb-2">250+</div>
                        <div class="text-blue-100">Produk Direkomendasikan</div>
                    </div>
                    <div class="p-4">
                        <div class="text-3xl font-bold mb-2">15K+</div>
                        <div class="text-blue-100">Pengguna Aktif</div>
                    </div>
                    <div class="p-4">
                        <div class="text-3xl font-bold mb-2">50+</div>
                        <div class="text-blue-100">Mitra Bisnis</div>
                    </div>
                    <div class="p-4">
                        <div class="text-3xl font-bold mb-2">5 Ton</div>
                        <div class="text-blue-100">Produk Terjual</div>
                    </div>
                </div>
            </div>

            <!-- Team Section -->
            <div class="bg-white rounded-xl shadow-lg p-8 animate__animated animate__fadeIn">
                <h2 class="text-2xl font-semibold mb-8 text-gray-800 flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 mr-3"></i> Kenali Tim Kami
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($teamMembers as $member)
                        <div
                            class="text-center bg-gray-50 rounded-lg p-6 transition duration-300 hover:bg-white hover:shadow-md">
                            <div class="relative inline-block">
                                <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}"
                                    class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-white shadow-md">
                                <div class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-2">
                                    <i class="{{ $member['icon'] ?? 'fas fa-user' }} text-white text-sm"></i>
                                </div>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800">{{ $member['name'] }}</h3>
                            <p class="text-blue-600 font-medium mb-3">{{ $member['role'] }}</p>
                            <p class="text-gray-600 text-sm mb-4">{{ $member['bio'] }}</p>
                            <div class="flex justify-center space-x-3">
                                @if (isset($member['social']))
                                    @foreach ($member['social'] as $platform => $link)
                                        <a href="{{ $link }}"
                                            class="text-gray-400 hover:text-blue-600 transition duration-300">
                                            <i class="fab fa-{{ $platform }}"></i>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- CTA Section -->
            <div
                class="mt-12 text-center bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-8 text-white animate__animated animate__fadeInUp">
                <h2 class="text-2xl font-bold mb-4">Bergabunglah Dengan Misi Kami</h2>
                <p class="mb-6 text-blue-100 max-w-2xl mx-auto">
                    Bantu kami meningkatkan pengalaman belanja dengan memberikan masukan atau menjadi mitra dalam pengembangan sistem rekomendasi yang lebih cerdas.
                </p>
                <button
                    class="bg-white text-blue-600 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition duration-300 shadow-md">
                    <i class="fas fa-hand-holding-heart mr-2"></i> Dukung Kami
                </button>
            </div>
        </div>
    </div>
    <style>
        .team-member:hover img {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
    </style>
@endsection
