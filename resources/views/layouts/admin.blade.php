<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- AdminLTE CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
        .nav-sidebar .nav-link.active {
            background-color: #007bff !important;
            color: white !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    {{-- NAVBAR --}}
    @include('admin.partials.navbar')

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <!-- CONTENT -->
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
