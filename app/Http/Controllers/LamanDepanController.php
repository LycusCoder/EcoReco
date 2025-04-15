<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AprioriService;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Recommendation;
use App\Models\Testimonial;
use App\Models\Category;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class LamanDepanController extends Controller
{
    /**
     * Menampilkan halaman depan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua kategori (untuk modal)
        $allCategories = \App\Models\Category::all();

        // Mengambil kategori untuk tampilan awal (8 untuk mobile, 16 untuk desktop)
        $displayCategories = \App\Models\Category::take(16)->get();

        // Mengambil semua produk dengan jumlah ulasan (ratings_count)
        $products = \App\Models\Product::withCount('ratings')->get();

        // Mengambil semua testimonial
        $testimonials = \App\Models\Testimonial::all();

        // Menambah gambar dinamis ke setiap testimonial
        foreach ($testimonials as $testimonial) {
            $testimonial->image = "https://i.pravatar.cc/150?img=" . ($testimonial->user_id ?? random_int(1, 999));
        }

        // Cek apakah pengguna sudah login
        if (Auth::check()) {
            // Pengguna sudah login, gunakan rekomendasi berdasarkan algoritma
            $recommendedProducts = $this->getRecommendedProductsForLoggedInUser();
        } else {
            // Pengguna belum login, gunakan produk paling banyak dibeli
            $recommendedProducts = $this->getMostBoughtProducts();
        }

        // Kirim data ke view
        return view('lamandepan.index', [
            'allCategories' => $allCategories,
            'displayCategories' => $displayCategories,
            'products' => $products,
            'recommendedProducts' => $recommendedProducts,
            'testimonials' => $testimonials,
        ]);
    }

        /**
     * Menampilkan halaman about
     */
    public function about()
    {
        return view('lamandepan.about', [
            'categories' => Category::take(16)->get(),
            'allCategories' => Category::all(),
            'recommendedProducts' => $this->getRecommendedProducts(),
            'teamMembers' => [
                // Ketua Tim
                [
                    'name' => 'Muhammad Affif',
                    'role' => 'Project Leader & Backend Developer',
                    'image' => 'https://i.imgur.com/gCcfVGK.jpeg', // foto profil Muhammad Affif
                    'bio' => 'Pemimpin proyek yang memiliki visi jelas dan dedikasi tinggi dalam pengembangan backend. Spesialis Laravel yang selalu siap memberikan solusi teknis terbaik.'
                ],
                // Anggota Tim
                [
                    'name' => 'Yesa Anggit Prayugo',
                    'role' => 'Frontend Developer',
                    'image' => 'https://i.pravatar.cc/150?img=3', // foto profil Yesa
                    'bio' => 'Desainer UI/UX yang membuat antarmuka pengguna menjadi hidup. Berdedikasi tinggi dalam menciptakan pengalaman pengguna yang luar biasa dan responsif.'
                ],
                [
                    'name' => 'Siti Novia Desi Nurkhikmah',
                    'role' => 'Data Analyst',
                    'image' => 'https://i.pravatar.cc/150?img=5', // foto profil Siti Novia
                    'bio' => 'Ahli analisis data yang mampu menjelajahi pola pembelian pengguna dengan Collaborative Filtering dan Apriori Algorithm. Memastikan rekomendasi produk tetap relevan dan akurat.'
                ],
                [
                    'name' => 'Naufal Miftahul Arsyi',
                    'role' => 'DevOps Engineer',
                    'image' => 'https://i.pravatar.cc/150?img=4', // foto profil Naufal
                    'bio' => 'Pengembang DevOps yang menjaga sistem berjalan lancar 24/7. Spesialis dalam automasi deployment dan monitoring aplikasi.'
                ],
                [
                    'name' => 'Imzy Zulijar Setiawan',
                    'role' => 'Quality Assurance (QA) Tester',
                    'image' => 'https://i.pravatar.cc/150?img=6', // foto profil Imzy
                    'bio' => 'Tester yang tidak pernah puas sampai semua bug tertangani. Berdedikasi untuk memberikan pengalaman pengguna tanpa cela.'
                ]
            ],
        ]);
    }

    /**
     * Menampilkan halaman contact
     */
    public function contact()
    {
        return view('lamandepan.contact', [
            'categories' => Category::take(16)->get(),
            'allCategories' => Category::all(),
            'recommendedProducts' => $this->getRecommendedProducts(),
        ]);
    }

    /**
     * Menampilkan halaman rekomendasi
     */
    public function recommendations()
    {
        $recommendedProducts = $this->getRecommendedProducts();

        return view('lamandepan.recommendations', [
            'recommendedProducts' => $recommendedProducts,
            'categories' => Category::take(16)->get(),
            'allCategories' => Category::all(),
        ]);
    }


        /**
     * Menampilkan halaman testimonial
     */
    public function testimonials()
    {
        $testimonials = Testimonial::with('user')->latest()->get();

        // Tambahkan gambar jika tidak ada
        foreach ($testimonials as $testimonial) {
            if (!$testimonial->image) {
                $testimonial->image = "https://i.pravatar.cc/150?img=" . ($testimonial->user_id ?? random_int(1, 999));
            }
        }

        return view('lamandepan.testimonials', [
            'testimonials' => $testimonials,
            'categories' => Category::take(16)->get(),
            'allCategories' => Category::all(),
            'recommendedProducts' => $this->getRecommendedProducts(),
        ]);
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Di sini Anda bisa:
        // 1. Mengirim email
        // 2. Menyimpan ke database
        // 3. Atau mengirim notifikasi

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }


    /**
     * Mendapatkan produk paling banyak dibeli.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getMostBoughtProducts()
    {
        // Menghitung total pembelian setiap produk
        $mostBoughtProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(3)
            ->pluck('product_id');

        // Mengambil detail produk berdasarkan ID
        return Product::whereIn('id', $mostBoughtProducts)->get();
    }

    /**
     * Mendapatkan produk rekomendasi
     */
    private function getRecommendedProducts()
    {
        if (Auth::check()) {
            return $this->getRecommendedProductsForLoggedInUser();
        }
        return $this->getMostBoughtProducts();
    }

    /**
     * Mendapatkan rekomendasi produk untuk pengguna yang sudah login.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getRecommendedProductsForLoggedInUser()
    {
        $user = Auth::user();
        $userId = $user->id;

        // Get user's purchased products
        $userProductIds = Order::where('user_id', $userId)
            ->with('orderItems')
            ->get()
            ->flatMap(function ($order) {
                return $order->orderItems->pluck('product_id');
            })
            ->unique()
            ->values()
            ->toArray();

        if (empty($userProductIds)) {
            return $this->getMostBoughtProducts();
        }

        // Get all transactions
        $transactions = Order::with(['orderItems' => function($query) {
                $query->select('order_id', 'product_id');
            }])
            ->get()
            ->map(function ($order) {
                return $order->orderItems->pluck('product_id')->unique()->toArray();
            })
            ->toArray();

        // Run Apriori algorithm
        $apriori = new AprioriService(
            $transactions,
            0.1, // Minimum support (adjust as needed)
            0.5  // Minimum confidence (adjust as needed)
        );

        $rules = $apriori->run();

        // Generate recommendations
        $recommendations = [];
        foreach ($rules as $rule) {
            $antecedent = $rule['antecedent'];
            $consequent = $rule['consequent'];
            $confidence = $rule['confidence'];

            if ($this->isSubset($antecedent, $userProductIds)) {
                foreach ($consequent as $productId) {
                    if (!in_array($productId, $userProductIds)) {
                        $recommendations[$productId] = ($recommendations[$productId] ?? 0) + $confidence;
                    }
                }
            }
        }

        if (empty($recommendations)) {
            return $this->getMostBoughtProducts();
        }

        arsort($recommendations);
        $recommendedProductIds = array_slice(array_keys($recommendations), 0, 3);

        return Product::whereIn('id', $recommendedProductIds)->get();
    }

    private function isSubset($needle, $haystack)
    {
        return count(array_intersect($needle, $haystack)) === count($needle);
    }

}
