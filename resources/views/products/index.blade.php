
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <title>Browse Products - ThriftHub</title>

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body {
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        /* PRODUCT CARD */

        .product-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #fff;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        /* IMAGE CONTAINER */

        .product-image-wrapper {
            width: 100%;
            height: 260px;
            background: #f1f1f1;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* PRODUCT IMAGE */

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.3s ease;
        }

        .product-card:hover .product-img {
            transform: scale(1.05);
        }

        /* PRICE */

        .price {
            font-size: 20px;
            font-weight: bold;
            color: #0d6efd;
        }

        /* MODAL IMAGE */

        .modal-img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            border-radius: 12px;
            background: #f1f1f1;
        }

        /* RESPONSIVE */

        @media (max-width: 768px) {

            .product-image-wrapper {
                height: 220px;
            }

            .modal-img {
                height: 240px;
            }

            .modal-body {
                font-size: 14px;
                padding: 14px;
            }
        }

    </style>

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-dark bg-dark px-3">

    <a href="/" class="navbar-brand fw-bold">
        ThriftHub
    </a>

    <div class="d-flex gap-2">

        <a href="{{ route('login') }}"
           class="btn btn-outline-light btn-sm">
            Login
        </a>

        <a href="{{ route('register') }}"
           class="btn btn-primary btn-sm">
            Register
        </a>

    </div>

</nav>

<main>

<div class="container py-5">

    <!-- TITLE -->

    <div class="text-center mb-4">

        <h2 class="fw-bold">
            Browse Products
        </h2>

    </div>

    <!-- FILTERS -->

    <div class="row mb-4 g-2">

        <!-- SEARCH -->

        <div class="col-12 col-md-8">

            <input
                type="text"
                id="searchInput"
                class="form-control"
                placeholder="Search products, category, seller..."
            >

        </div>

        <!-- CATEGORY -->

        <div class="col-12 col-md-4">

            <select id="categoryFilter"
                    class="form-select">

                <option value="">
                    All Categories
                </option>

                @foreach($products->pluck('category')->unique() as $category)

                    <option value="{{ strtolower($category) }}">
                        {{ $category }}
                    </option>

                @endforeach

            </select>

        </div>

    </div>

    <!-- PRODUCTS GRID -->

    <div class="row g-4">

        @forelse($products as $product)

        @php
            $seller = $product->user;
        @endphp

        <div
            class="col-6 col-md-4 col-lg-3 product-item"

            data-title="{{ strtolower($product->title) }}"

            data-category="{{ strtolower($product->category) }}"

            data-seller="{{ strtolower($seller->name ?? '') }}"
        >

            <!-- CARD -->

            <div class="card product-card shadow-sm">

                <!-- IMAGE -->

                <div class="product-image-wrapper">

                    <img

                        src="{{ $product->image
                            ? asset('storage/' . $product->image)
                            : 'https://via.placeholder.com/400x300?text=No+Image' }}"

                        alt="{{ $product->title }}"

                        class="product-img"

                        loading="lazy"

                        onerror="this.onerror=null;this.src='https://via.placeholder.com/400x300?text=No+Image';"

                    >

                </div>

                <!-- BODY -->

                <div class="card-body">

                    <h6 class="fw-bold mb-1">

                        {{ $product->title }}

                    </h6>

                    <small class="text-muted d-block mb-2">

                        {{ $product->category }}

                        •

                        {{ $product->condition }}

                    </small>

                    <div class="price mb-3">

                        ₱ {{ number_format($product->price, 2) }}

                    </div>

                    <button

                        class="btn btn-dark btn-sm w-100"

                        data-bs-toggle="modal"

                        data-bs-target="#productModal{{ $product->id }}"

                    >

                        View Details

                    </button>

                </div>

            </div>

        </div>

        <!-- MODAL -->

        <div class="modal fade"
             id="productModal{{ $product->id }}"
             tabindex="-1">

            <div class="modal-dialog modal-dialog-centered modal-lg">

                <div class="modal-content">

                    <!-- HEADER -->

                    <div class="modal-header">

                        <h5 class="modal-title">

                            {{ $product->title }}

                        </h5>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                        </button>

                    </div>

                    <!-- BODY -->

                    <div class="modal-body">

                        <div class="row g-4">

                            <!-- IMAGE -->

                            <div class="col-12 col-md-5">

                                <img

                                    src="{{ $product->image
                                        ? asset('storage/' . $product->image)
                                        : 'https://via.placeholder.com/400x300?text=No+Image' }}"

                                    alt="{{ $product->title }}"

                                    class="modal-img"

                                    onerror="this.onerror=null;this.src='https://via.placeholder.com/400x300?text=No+Image';"

                                >

                            </div>

                            <!-- DETAILS -->

                            <div class="col-12 col-md-7">

                                <h4 class="text-primary fw-bold">

                                    ₱ {{ number_format($product->price, 2) }}

                                </h4>

                                <p class="text-muted">

                                    {{ $product->category }}

                                    •

                                    {{ $product->condition }}

                                </p>

                                <p>

                                    {{ $product->description }}

                                </p>

                                <hr>

                                <h6 class="fw-bold">

                                    Seller Information

                                </h6>

                                <p>

                                    <strong>Name:</strong>

                                    {{ $seller->name ?? 'Unknown' }}

                                </p>

                                <p>

                                    <strong>Contact:</strong>

                                    {{ $seller->contact_number ?? 'N/A' }}

                                </p>

                                @if($seller && $seller->facebook_link)

                                <a

                                    href="{{ $seller->facebook_link }}"

                                    target="_blank"

                                    class="btn btn-primary w-100"

                                >

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

        <!-- EMPTY STATE -->

        <div class="col-12">

            <div class="alert alert-info text-center">

                No products available yet.

            </div>

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

<!-- LIVE SEARCH -->

<script>

document.addEventListener("DOMContentLoaded", function () {

    const searchInput =
        document.getElementById("searchInput");

    const categoryFilter =
        document.getElementById("categoryFilter");

    const products =
        document.querySelectorAll(".product-item");

    function filterProducts() {

        const searchValue =
            searchInput.value.toLowerCase().trim();

        const categoryValue =
            categoryFilter.value.toLowerCase();

        products.forEach(item => {

            const title =
                item.dataset.title;

            const category =
                item.dataset.category;

            const seller =
                item.dataset.seller;

            const matchSearch =

                title.includes(searchValue)

                ||

                category.includes(searchValue)

                ||

                seller.includes(searchValue);

            const matchCategory =

                categoryValue === ""

                ||

                category === categoryValue;

            item.style.display =

                (matchSearch && matchCategory)

                ?

                "block"

                :

                "none";
        });
    }

    searchInput.addEventListener(
        "input",
        filterProducts
    );

    categoryFilter.addEventListener(
        "change",
        filterProducts
    );

});

</script>

</body>
</html>