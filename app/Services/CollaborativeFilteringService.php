<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CollaborativeFilteringService
{
    protected Collection $ratings;
    protected int $kNeighbors;
    protected float $threshold;

    public function __construct(Collection $ratings, int $kNeighbors = 3, float $threshold = 4.0)
    {
        $this->ratings = $ratings;
        $this->kNeighbors = $kNeighbors;
        $this->threshold = $threshold;
    }

    public function getRecommendedProducts(int $userId): array
    {
        $similarities = $this->calculateUserSimilarities($userId);
        $unratedProducts = $this->getUnratedProducts($userId);

        $predictions = [];
        foreach ($unratedProducts as $productId) {
            $predictedRating = $this->predictRating($userId, $productId, $similarities);
            if ($predictedRating >= $this->threshold) {
                $predictions[] = $productId;
            }
        }

        return $predictions;
    }


    private function calculateUserSimilarities($userId)
    {
        // Implementasi Pearson Correlation
        $similarities = [];
        $targetUser = $this->getUserRatings($userId);

        foreach ($this->ratings->groupBy('user_id') as $otherUserId => $ratings) {
            if ($otherUserId == $userId) continue;

            $otherUser = $ratings->keyBy('product_id');
            $dotProduct = 0;
            $magnitudeA = 0;
            $magnitudeB = 0;

            foreach ($targetUser as $productId => $ratingA) {
                if ($otherUser->has($productId)) {
                    $ratingB = $otherUser[$productId]->rating;
                    $dotProduct += $ratingA * $ratingB;
                    $magnitudeA += pow($ratingA, 2);
                    $magnitudeB += pow($ratingB, 2);
                }
            }

            if ($magnitudeA && $magnitudeB) {
                $similarities[$otherUserId] = $dotProduct / (sqrt($magnitudeA) * sqrt($magnitudeB));
            }
        }

        arsort($similarities);
        return array_slice($similarities, 0, $this->kNeighbors, true);
    }

    private function predictRating($userId, $productId, $similarities)
    {
        // Weighted average dari neighbor ratings
        $weightedSum = 0;
        $similaritySum = 0;

        foreach ($similarities as $neighborId => $similarity) {
            $neighborRating = $this->ratings
                ->where('user_id', $neighborId)
                ->where('product_id', $productId)
                ->first();

            if ($neighborRating) {
                $weightedSum += $similarity * $neighborRating->rating;
                $similaritySum += abs($similarity);
            }
        }

        return $similaritySum > 0 ? $weightedSum / $similaritySum : 0;
    }

    private function getUnratedProducts($userId)
    {
        $ratedProducts = $this->ratings
            ->where('user_id', $userId)
            ->pluck('product_id')
            ->toArray();

        return Product::whereNotIn('id', $ratedProducts) // Menggunakan kelas Product
            ->pluck('id')
            ->toArray();
    }

    private function getUserRatings($userId)
    {
        return $this->ratings
            ->where('user_id', $userId)
            ->keyBy('product_id')
            ->map(function ($item) {
                return $item->rating;
            });
    }
}
