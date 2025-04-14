<?php

// App\Observers\RatingObserver.php

namespace App\Observers;

use App\Models\Rating;

class RatingObserver
{
    public function created(Rating $rating)
    {
        $this->updateProductRating($rating->product);
    }

    public function updated(Rating $rating)
    {
        $this->updateProductRating($rating->product);
    }

    public function deleted(Rating $rating)
    {
        $this->updateProductRating($rating->product);
    }

    protected function updateProductRating($product)
    {
        // Hitung ulang rata-rata rating
        $averageRating = $product->ratings()->avg('rating');

        // Perbarui nilai di tabel products
        $product->update([
            'rating' => $averageRating,
        ]);
    }
}
