<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - ThriftHub</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .dashboard-title {
            font-weight: 700;
        }

        .stat-card {
            border: none;
            border-radius: 14px;
            transition: 0.3s;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        }

        .stat-number {
            font-size: 26px;
            font-weight: bold;
        }

        .navbar-brand {
            font-weight: 600;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 15px;
        }

        .admin-link-card {
            cursor: pointer;
            transition: 0.3s;
        }

        .admin-link-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .chart-card {
            border: none;
            border-radius: 14px;
        }

        @media (max-width: 768px) {

            .dashboard-title {
                font-size: 20px;
                text-align: center;
            }

            .stat-number {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand">ThriftHub Admin Panel</span>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger btn-sm">
            Logout
        </button>
    </form>
</nav>

<div class="container py-5">

    <!-- TITLE -->
    <h3 class="mb-4 dashboard-title">
        Welcome Admin 👋
    </h3>

    <!-- ================= STATS ================= -->
    <div class="row g-3">

        <!-- TOTAL SELLERS -->
        <div class="col-6 col-md-3">
            <div class="card stat-card shadow-sm p-3 text-center">

                <h6>Total Sellers</h6>

                <div class="stat-number text-primary">
                    {{ $totalSellers }}
                </div>

            </div>
        </div>

        <!-- TOTAL PRODUCTS -->
        <div class="col-6 col-md-3">
            <div class="card stat-card shadow-sm p-3 text-center">

                <h6>Total Products</h6>

                <div class="stat-number text-dark">
                    {{ $totalProducts }}
                </div>

            </div>
        </div>

        <!-- PENDING -->
        <div class="col-6 col-md-3">
            <div class="card stat-card shadow-sm p-3 text-center">

                <h6>Pending</h6>

                <div class="stat-number text-warning">
                    {{ $totalPending }}
                </div>

            </div>
        </div>

        <!-- APPROVED -->
        <div class="col-6 col-md-3">
            <div class="card stat-card shadow-sm p-3 text-center">

                <h6>Approved</h6>

                <div class="stat-number text-success">
                    {{ $totalApproved }}
                </div>

            </div>
        </div>

        <!-- SOLD -->
        <div class="col-6 col-md-6">
            <div class="card stat-card shadow-sm p-3 text-center">

                <h6>Total Sold Products</h6>

                <div class="stat-number text-info">
                    {{ $totalSold }}
                </div>

            </div>
        </div>

        <!-- REJECTED -->
        <div class="col-6 col-md-6">
            <div class="card stat-card shadow-sm p-3 text-center">

                <h6>Rejected Products</h6>

                <div class="stat-number text-danger">
                    {{ $totalRejected }}
                </div>

            </div>
        </div>

    </div>

    <!-- ================= MANAGEMENT ================= -->
    <div class="mt-5">

        <h5 class="section-title">
            Admin Management Panel
        </h5>

        <div class="row g-3 justify-content-center">

            <!-- MANAGE PRODUCTS -->
            <div class="col-12 col-md-5 col-lg-4">

                <a href="{{ route('admin.products.index') }}"
                   class="text-decoration-none">

                    <div class="card stat-card p-4 text-center admin-link-card h-100">

                        <h6>Manage Products</h6>

                        <p class="text-muted mb-0">
                            Approve, reject, view listings
                        </p>

                    </div>

                </a>

            </div>

            <!-- MANAGE SELLERS -->
            <div class="col-12 col-md-5 col-lg-4">

                <a href="{{ route('admin.sellers.index') }}"
                   class="text-decoration-none">

                    <div class="card stat-card p-4 text-center admin-link-card h-100">

                        <h6>Manage Sellers</h6>

                        <p class="text-muted mb-0">
                            View seller accounts
                        </p>

                    </div>

                </a>

            </div>

        </div>

    </div>

    <!-- ================= ANALYTICS ================= -->
    <div class="mt-5">

        <h5 class="section-title">
            Analytics Dashboard
        </h5>

        <div class="row g-3">

            <!-- PRODUCT STATUS ANALYTICS -->
            <div class="col-12 col-lg-6">

                <div class="card chart-card shadow-sm p-4">

                    <h6 class="mb-3">
                        Product Status Analytics
                    </h6>

                    <canvas id="productChart"></canvas>

                </div>

            </div>

            <!-- SYSTEM OVERVIEW -->
            <div class="col-12 col-lg-6">

                <div class="card chart-card shadow-sm p-4">

                    <h6 class="mb-3">
                        System Growth Overview
                    </h6>

                    <canvas id="systemChart"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    // ================= PRODUCT STATUS CHART =================
    new Chart(document.getElementById('productChart'), {

        type: 'bar',

        data: {

            labels: ['Pending', 'Approved', 'Sold', 'Rejected'],

            datasets: [{

                label: 'Products',

                data: [
                    {{ $totalPending ?? 0 }},
                    {{ $totalApproved ?? 0 }},
                    {{ $totalSold ?? 0 }},
                    {{ $totalRejected ?? 0 }}
                ],

                backgroundColor: [
                    '#ffc107',
                    '#28a745',
                    '#0dcaf0',
                    '#dc3545'
                ]

            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: true
        }

    });

    // ================= SYSTEM OVERVIEW =================
    new Chart(document.getElementById('systemChart'), {

        type: 'bar',

        data: {

            labels: ['Total Sellers', 'Total Products', 'Sold Products'],

            datasets: [{

                label: 'System Data',

                data: [
                    {{ $totalSellers ?? 0 }},
                    {{ $totalProducts ?? 0 }},
                    {{ $totalSold ?? 0 }}
                ],

                backgroundColor: [
                    '#0d6efd',
                    '#20c997',
                    '#0dcaf0'
                ]

            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: true
        }

    });


</script>

</body>
</html>