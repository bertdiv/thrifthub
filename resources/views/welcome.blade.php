
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThriftHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
        overflow-x: hidden;
    }

    .navbar-brand {
        font-size: 28px;
    }

    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: linear-gradient(to right, #111827, #1f2937);
        color: white;
        padding: 80px 0;
    }

    .hero h1 {
        font-size: 60px;
        font-weight: bold;
        line-height: 1.2;
    }

    .hero p {
        font-size: 20px;
        color: #d1d5db;
    }

    .btn-main {
        background-color: #0d6efd;
        color: white;
        padding: 12px 30px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: bold;
        display: inline-block;
    }

    .btn-main:hover {
        background-color: #0b5ed7;
        color: white;
    }

    .feature-card {
        border: none;
        border-radius: 15px;
        transition: 0.3s;
    }

    .feature-card:hover {
        transform: translateY(-5px);
    }

    .category-box {
        background: white;
        padding: 25px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: 0.3s;
    }

    .category-box:hover {
        transform: scale(1.05);
    }

    .hero img {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
    }

    footer {
        background: #111827;
        color: white;
        padding: 20px 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Mobile Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 991px) {

        .hero {
            text-align: center;
            padding: 60px 20px;
        }

        .hero h1 {
            font-size: 42px;
        }

        .hero p {
            font-size: 18px;
        }

        .hero .d-flex {
            flex-direction: column;
            gap: 15px !important;
        }

        .btn-main,
        .hero .btn {
            width: 100%;
        }

        .navbar-nav {
            text-align: center;
            padding-top: 20px;
        }

        .navbar-nav .nav-item {
            margin-bottom: 15px;
        }

        .hero img {
            margin-top: 30px;
        }
    }

    @media (max-width: 576px) {

        .hero h1 {
            font-size: 34px;
        }

        .hero p {
            font-size: 16px;
        }

        .navbar-brand {
            font-size: 24px;
        }

        .category-box {
            padding: 18px;
        }

        .feature-card {
            padding: 20px !important;
        }

        .btn-main,
        .hero .btn {
            font-size: 16px;
            padding: 12px;
        }
    }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
    <div class="container">

        <a class="navbar-brand fw-bold fs-3" href="#">
            ThriftHub
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                <a class="nav-link" href="{{ route('products.index') }}">
    Browse Products
</a>

                @guest
                    <li class="nav-item me-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-light">
                            Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Register
                        </a>
                    </li>
                @endguest

                @auth
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">
            Dashboard
        </a>
    </li>
@endauth

            </ul>
        </div>

    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">

                <h1>
                    Find Affordable
                    <div></div>
                    <span class="text-primary">Pre-Loved Treasures</span>
                </h1>

                <p class="mt-4 mb-4">
                    Buy and sell second-hand items easily with ThriftHub.
                    Discover quality products, connect with sellers,
                    and give items a second home.
                </p>

            <div class="d-flex flex-column flex-md-row gap-3">

                    <a href="{{ route('products.index') }}" class="btn-main">
    Browse Products
</a>

                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        Start Selling
                    </a>

                </div>

            </div>

            <div class="col-lg-6 text-center mt-5 mt-lg-0">
                <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=1200&auto=format&fit=crop"
                     class="img-fluid rounded-4 shadow-lg"
                     alt="Thrift Shopping">
            </div>

        </div>
    </div>
</section>

<!-- Features -->
<section class="py-5 bg-white">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="fw-bold">Why Choose ThriftHub?</h2>
            <p class="text-muted">
                A simple and secure marketplace for second-hand items.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card feature-card shadow-sm p-4 text-center h-100">
                    <h4 class="mb-3">Easy Product Posting</h4>
                    <p>
                        Upload products quickly with images,
                        descriptions, and pricing.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card shadow-sm p-4 text-center h-100">
                    <h4 class="mb-3">Direct Seller Contact</h4>
                    <p>
                        Connect with sellers directly through
                        Messenger, phone, or email.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card shadow-sm p-4 text-center h-100">
                    <h4 class="mb-3">Affordable Deals</h4>
                    <p>
                        Find budget-friendly and quality
                        pre-loved products.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- Categories -->
<section class="py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="fw-bold">Popular Categories</h2>
        </div>

        <div class="row g-4">

            <div class="col-md-3 col-6">
                <div class="category-box">
                    <h5>Clothing</h5>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="category-box">
                    <h5>Shoes</h5>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="category-box">
                    <h5>Gadgets</h5>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="category-box">
                    <h5>Books</h5>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container">

        <h2 class="fw-bold mb-3">
            Start Buying and Selling Today
        </h2>

        <p class="mb-4">
            Join ThriftHub and discover amazing second-hand deals.
        </p>

        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
            Create an Account
        </a>

    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container text-center">
        <p class="mb-0">
            © 2026 ThriftHub by John Robert Badugas.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>