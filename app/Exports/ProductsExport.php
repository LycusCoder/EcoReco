<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return Product::query()->with('category');
    }

    public function headings(): array
    {
        return [
            'ID Produk',
            'Nama Produk',
            'Kategori',
            'Harga',
            'Stok',
            'Status Aktif',
            'Tanggal Dibuat',
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->category->name ?? 'N/A',
            $product->price,
            $product->stock,
            $product->is_active ? 'Ya' : 'Tidak',
            $product->created_at->format('d M Y H:i'),
        ];
    }
}