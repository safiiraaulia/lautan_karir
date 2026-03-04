<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Lautan Karir')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root { --navy: #103783; }
        .nav-sidebar .nav-link.active {
            background-color: var(--navy) !important;
            color: white !important;
        }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
            background-color: var(--navy) !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- NAVBAR --}}
    @include('admin.partials.navbar')

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <div class="content-wrapper">
        <section class="content p-3">
            {{-- Alert HTML standar dihapus karena sudah diganti SweetAlert2 di bawah --}}
            @yield('content')
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const Toast = Swal.mixin({
        confirmButtonColor: '#103783',
        cancelButtonColor: '#d33',
    });

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            html: "{!! session('success') !!}",
            confirmButtonColor: '#103783'
        });
    @endif

    {{-- Notifikasi Error/Validasi --}}
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Mohon periksa kembali inputan Anda.",
            confirmButtonColor: '#103783'
        });
    @endif
</script>

@stack('scripts')
@yield('js')
</body>
</html>