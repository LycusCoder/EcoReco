<?php

namespace App\Services;

class AprioriService
{
    private $transactions;
    private $minSupport;
    private $minConfidence;
    private $maxOrderSize;

    public function __construct($transactions, $minSupport = 0.1, $minConfidence = 0.5, $maxOrderSize = 5)
    {
        $this->transactions = $transactions;
        $this->minSupport = $minSupport;
        $this->minConfidence = $minConfidence;
        $this->maxOrderSize = $maxOrderSize;
    }

    public function run()
    {
        $frequentItemsets = $this->generateFrequentItemsets();
        $rules = $this->generateRules($frequentItemsets);
        return $rules;
    }

    private function generateFrequentItemsets()
    {
        $frequentItemsets = [];
        $k = 1;
        $currentL = $this->getFrequent1Itemsets();

        while (!empty($currentL) && $k < $this->maxOrderSize) {
            $frequentItemsets[$k] = $currentL;
            $k++;
            $candidates = $this->generateCandidates($currentL, $k);
            $currentL = $this->pruneCandidates($candidates);
        }

        return $frequentItemsets;
    }

    private function getFrequent1Itemsets()
    {
        $items = $this->getUniqueItems();
        $frequent = [];

        foreach ($items as $item) {
            $support = $this->calculateSupport([$item]);
            if ($support >= $this->minSupport) {
                $frequent[] = [$item];
            }
        }

        return $frequent;
    }

    private function generateCandidates($prevItemsets, $k)
    {
        $candidates = [];
        $n = count($prevItemsets);

        for ($i = 0; $i < $n; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                $merged = array_unique(array_merge($prevItemsets[$i], $prevItemsets[$j]));
                if (count($merged) === $k) {
                    sort($merged);
                    if (!in_array($merged, $candidates)) {
                        $candidates[] = $merged;
                    }
                }
            }
        }

        return $candidates;
    }

    private function pruneCandidates($candidates)
    {
        $pruned = [];
        foreach ($candidates as $candidate) {
            $support = $this->calculateSupport($candidate);
            if ($support >= $this->minSupport) {
                $pruned[] = $candidate;
            }
        }
        return $pruned;
    }

    private function generateRules($frequentItemsets)
    {
        $rules = [];

        foreach ($frequentItemsets as $k => $itemsets) {
            if ($k < 2) continue;

            foreach ($itemsets as $itemset) {
                $subsets = $this->getNonEmptySubsets($itemset);

                foreach ($subsets as $antecedent) {
                    $consequent = array_values(array_diff($itemset, $antecedent));
                    $confidence = $this->calculateConfidence($antecedent, $itemset);

                    if ($confidence >= $this->minConfidence) {
                        $rules[] = [
                            'antecedent' => $antecedent,
                            'consequent' => $consequent,
                            'confidence' => $confidence,
                        ];
                    }
                }
            }
        }

        return $rules;
    }

    private function getNonEmptySubsets($itemset)
    {
        $subsets = [];
        $n = count($itemset);
        $total = pow(2, $n);

        for ($i = 1; $i < $total - 1; $i++) {
            $subset = [];
            for ($j = 0; $j < $n; $j++) {
                if ($i & (1 << $j)) {
                    $subset[] = $itemset[$j];
                }
            }
            $subsets[] = $subset;
        }

        return $subsets;
    }

    private function calculateConfidence($antecedent, $itemset)
    {
        $supportAntecedent = $this->calculateSupport($antecedent);
        $supportItemset = $this->calculateSupport($itemset);

        return $supportAntecedent > 0 ? $supportItemset / $supportAntecedent : 0;
    }

    private function calculateSupport($itemset)
    {
        $count = 0;
        foreach ($this->transactions as $transaction) {
            if (count(array_intersect($itemset, $transaction)) === count($itemset)) {
                $count++;
            }
        }
        return $count / count($this->transactions);
    }

    private function getUniqueItems()
    {
        $items = [];
        foreach ($this->transactions as $transaction) {
            foreach ($transaction as $item) {
                if (!in_array($item, $items)) {
                    $items[] = $item;
                }
            }
        }
        return $items;
    }
}
