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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main { flex: 1; }

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

        .modal-img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .modal-img { max-height: 250px; }
            .modal-body { font-size: 14px; padding: 12px; }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-3">
    <a href="/" class="navbar-brand fw-bold">ThriftHub</a>

    <div class="d-flex gap-2">
        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
    </div>
</nav>

<main>
<div class="container py-5">

    <div class="text-center mb-3">
        <h2 class="fw-bold">Browse Products</h2>
    </div>

    <!-- FILTERS -->
    <div class="row mb-4 g-2">

        <!-- SEARCH -->
        <div class="col-12 col-md-8">
            <input type="text"
                   id="searchInput"
                   class="form-control"
                   placeholder="Search products, category, seller...">
        </div>

        <!-- CATEGORY -->
        <div class="col-12 col-md-4">
            <select id="categoryFilter" class="form-select">
                <option value="">All Categories</option>
                @foreach($products->pluck('category')->unique() as $category)
                    <option value="{{ strtolower($category) }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>

    </div>

    <!-- PRODUCTS -->
    <div class="row g-4">

        @forelse($products as $product)
        @php $seller = $product->user; @endphp

        <div class="col-6 col-md-4 col-lg-3 product-item"
             data-title="{{ strtolower($product->title) }}"
             data-category="{{ strtolower($product->category) }}"
             data-seller="{{ strtolower($seller->name ?? '') }}">

            <div class="card product-card shadow-sm">

                <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/400x300' }}"
                     class="card-img-top product-img">

                <div class="card-body p-2">

                    <h6 class="mb-1">{{ $product->title }}</h6>

                    <small class="text-muted d-block">
                        {{ $product->category }} • {{ $product->condition }}
                    </small>

                    <div class="price mt-1 mb-2">
                        ₱ {{ number_format($product->price, 2) }}
                    </div>

                    <button class="btn btn-dark btn-sm w-100"
                            data-bs-toggle="modal"
                            data-bs-target="#productModal{{ $product->id }}">
                        View Details
                    </button>

                </div>
            </div>
        </div>

        <!-- MODAL -->
        <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1">

            <div class="modal-dialog modal-dialog-centered modal-lg">

                <div class="modal-content">

                    <div class="modal-header py-2">
                        <h6 class="modal-title">{{ $product->title }}</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row g-3">

                            <div class="col-12 col-md-5">
                                <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/400x300' }}"
                                     class="modal-img">
                            </div>

                            <div class="col-12 col-md-7">

                                <h5 class="text-primary">
                                    ₱ {{ number_format($product->price, 2) }}
                                </h5>

                                <p class="text-muted">
                                    {{ $product->category }} • {{ $product->condition }}
                                </p>

                                <p>{{ $product->description }}</p>

                                <hr>

                                <h6>Seller Info</h6>

                                <p><strong>Name:</strong> {{ $seller->name ?? 'Unknown' }}</p>

                                <p><strong>Contact:</strong> {{ $seller->contact_number ?? 'N/A' }}</p>

                                @if($seller && $seller->facebook_link)
                                <a href="{{ $seller->facebook_link}}"
                                   target="_blank"
                                   class="btn btn-primary btn-sm w-100">
                                    View Facebook Profile
                                </a>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        @empty
        <div class="col-12 text-center">
            <div class="alert alert-info">No products available yet.</div>
        </div>
        @endforelse

    </div>

</div>
</main>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    © 2026 ThriftHub by John Robert Badugas
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- LIVE SEARCH SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById("searchInput");
    const categoryFilter = document.getElementById("categoryFilter");
    const products = document.querySelectorAll(".product-item");

    function filterProducts() {

        const searchValue = searchInput.value.toLowerCase().trim();
        const categoryValue = categoryFilter.value.toLowerCase();

        products.forEach(item => {

            const title = item.dataset.title;
            const category = item.dataset.category;
            const seller = item.dataset.seller;

            const matchSearch =
                title.includes(searchValue) ||
                category.includes(searchValue) ||
                seller.includes(searchValue);

            const matchCategory =
                categoryValue === "" || category === categoryValue;

            item.style.display = (matchSearch && matchCategory) ? "block" : "none";
        });
    }

    searchInput.addEventListener("input", filterProducts);
    categoryFilter.addEventListener("change", filterProducts);

});
</script>

</body>
</html>