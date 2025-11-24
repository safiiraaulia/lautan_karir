<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- AdminLTE 3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <!-- Google Font (Modern Look) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Sidebar active link modern */
        .nav-sidebar .nav-link.active {
            background: #0d6efd !important;
            color: #fff !important;
            font-weight: 600;
            border-radius: 6px;
        }

        /* Modern card look */
        .card {
            border-radius: 14px !important;
            border: none !important;
            box-shadow: 0 4px 16px rgba(0,0,0,0.05);
        }

        /* Modern small-box */
        .small-box {
            border-radius: 14px;
            padding-bottom: 10px;
        }
        .small-box > .inner h3 {
            font-weight: 700;
        }

        /* Table modern */
        table.table {
            font-size: 14px;
        }
        table.table thead {
            background: #f8f9fa;
            font-weight: 600;
        }
        table.table tbody tr:hover {
            background-color: #f1f5ff !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    {{-- Navbar --}}
    @include('admin.partials.navbar')

    {{-- Sidebar --}}
    @include('admin.partials.sidebar')

    {{-- Main Content --}}
    <div class="content-wrapper">
        <section class="content p-3">
            @yield('content')
        </section>
    </div>

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@yield('js')
</body>
</html>
