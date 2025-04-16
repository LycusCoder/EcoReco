@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Staff</h1>
    <div class="row">
        <!-- Total Produk -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Produk</h5>
                    <p class="card-text display-4">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>

        <!-- Total Pesanan -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Pesanan</h5>
                    <p class="card-text display-4">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>

        <!-- Pesanan Selesai -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Pesanan Selesai</h5>
                    <p class="card-text display-4">{{ $completedOrders }}</p>
                </div>
            </div>
        </div>

        <!-- Total Kategori -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Total Kategori</h5>
                    <p class="card-text display-4">{{ $totalCategories }}</p>
                </div>
            </div>
        </div>

        <!-- Total Testimoni -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Total Testimoni</h5>
                    <p class="card-text display-4">{{ $totalTestimonials }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
