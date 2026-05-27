<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Products - ThriftHub</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }

        .product-card {
            border: none;
            border-radius: 15px;
            transition: 0.3s;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .product-img {
            height: 200px;
            object-fit: cover;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
            color: #0d6efd;
        }

        .badge-custom {
            background: #198754;
            color: white;
            font-size: 12px;
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark px-4">
    <a href="/" class="navbar-brand fw-bold">ThriftHub</a>

    <div>
        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
    </div>
</nav>

<!-- Header -->
<div class="container py-5">

    <div class="text-center mb-5">
        <h2 class="fw-bold">Browse Products</h2>
        <p class="text-muted">Find affordable pre-loved items from sellers</p>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <input type="text" class="form-control form-control-lg" placeholder="Search products...">
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4">

        @forelse($products as $product)

        <div class="col-md-4 col-lg-3">

            <div class="card product-card shadow-sm">

                <!-- IMAGE -->
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x300' }}"
                     class="card-img-top product-img">

                <div class="card-body">

                    <!-- TITLE -->
                    <h5 class="card-title">
                        {{ $product->title }}
                    </h5>

                    <!-- CATEGORY + CONDITION -->
                    <p class="text-muted mb-1">
                        {{ $product->category }} • {{ $product->condition }}
                    </p>

                    <!-- DESCRIPTION -->
                    <p class="text-muted small">
                        {{ \Illuminate\Support\Str::limit($product->description, 70) }}
                    </p>

                    <!-- PRICE -->
                    <div class="price mb-2">
                        ₱ {{ number_format($product->price, 2) }}
                    </div>

                    <!-- SELLER -->
                    <small class="text-muted">
                        Seller: {{ $product->user->name ?? 'Unknown' }}
                    </small>

                    <br>

                    <!-- STATUS -->
                    <span class="badge badge-custom mt-2 mb-2">
                        Available
                    </span>

                    <!-- CONTACT -->
                    <div class="d-grid mt-3">

                        @if($product->messenger_link)
                            <a href="{{ $product->messenger_link }}" target="_blank" class="btn btn-primary btn-sm">
                                Contact Seller
                            </a>

                        @elseif($product->contact_number)
                            <a href="tel:{{ $product->contact_number }}" class="btn btn-outline-primary btn-sm">
                                Call Seller
                            </a>

                        @else
                            <button class="btn btn-secondary btn-sm" disabled>
                                No Contact Info
                            </button>
                        @endif

                    </div>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12 text-center">
            <div class="alert alert-info">
                No products available yet.
            </div>
        </div>

        @endforelse

    </div>

</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    © 2026 ThriftHub by John Robert Badugas.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>