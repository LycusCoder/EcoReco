@extends('layouts.app')

@section('content')
    <div class="container py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Rekomendasi Untuk Anda</h1>

        @if ($recommendedProducts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($recommendedProducts as $product)
                    @include('components.lamandepan.product-card', ['product' => $product])
                @endforeach
            </div>

            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Cara Kami Memberikan Rekomendasi</h2>
                <p class="text-gray-600 mb-4">
                    Sistem rekomendasi kami menganalisis riwayat penelusuran, perilaku pembelian,
                    dan rating Anda untuk menyarankan produk yang mungkin disukai.
                </p>

                @auth
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-medium text-blue-800 mb-2">Tips Personalisasi</h3>
                        <ul class="list-disc pl-5 text-blue-700 space-y-1">
                            <li>Beri rating produk yang telah dibeli untuk tingkatkan rekomendasi</li>
                            <li>Jelajahi kategori berbeda untuk perluas preferensi</li>
                            <li>Perbarui profil dengan minat untuk saran yang lebih baik</li>
                        </ul>
                    </div>
                @else
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h3 class="font-medium text-yellow-800 mb-2">Dapatkan Rekomendasi Lebih Baik</h3>
                        <p class="text-yellow-700 mb-3">
                            Buat akun atau masuk untuk mendapatkan rekomendasi personal berdasarkan preferensi Anda.
                        </p>
                        <a href="{{ route('login') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                            Masuk / Daftar
                        </a>
                    </div>
                @endauth
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <i class="fas fa-lightbulb text-4xl text-yellow-400 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-700">Belum Ada Rekomendasi</h2>
                <p class="text-gray-500 mt-2">
                    @auth
                        Mulai jelajahi produk kami untuk mendapatkan rekomendasi personal.
                    @else
                        Masuk untuk mendapatkan rekomendasi berdasarkan preferensi Anda.
                    @endauth
                </p>
                <a href="{{ route('home') }}"
                    class="mt-4 inline-block bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                    Jelajahi Produk
                </a>
            </div>
        @endif
    </div>
@endsection
