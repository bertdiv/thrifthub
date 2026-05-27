<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - ThriftHub</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            overflow-x: hidden;
        }

        .admin-navbar {
            background: #111827;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }

        .navbar-brand {
            font-weight: 600;
            color: #fff;
            font-size: 18px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13px;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .content {
            padding: 24px;
        }

        @media (max-width: 768px) {
            .content { padding: 14px; }
            .navbar-brand { font-size: 16px; }
            .logout-btn { font-size: 12px; padding: 5px 10px; }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="admin-navbar">

    <span class="navbar-brand">ThriftHub Admin</span>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="logout-btn">
            Logout
        </button>
    </form>

</nav>

<!-- CONTENT -->
<div class="container-fluid container-md content">
    @yield('content')
</div>

<!-- ✅ IMPORTANT: Bootstrap JS (THIS FIXES MODAL) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>