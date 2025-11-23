<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Lautan Karir'))</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --navy:#103783; --navy-sec:#0a265e; --navy-acc:#4b6cb7; }
        body { background-color:#f8f9fa; font-family:'Nunito',sans-serif; }
        .navbar-public { background-color:#fff!important; border-bottom:1px solid rgba(0,0,0,0.05); }
        .navbar-brand { color:var(--navy)!important; letter-spacing:-0.5px; transition:transform 0.2s; }
        .navbar-brand:hover { transform:scale(1.02); }
        .nav-link { color:#6c757d; font-weight:600; transition:all 0.2s ease-in-out; padding-bottom:2px; }
        .nav-link:hover, .nav-link.active { color:var(--navy)!important; transform:translateY(-1px); }
        .nav-link:active, .btn:active { transform:scale(0.95)!important; }
        .btn-navy { background-color:var(--navy); border-color:var(--navy); color:#fff; transition:all 0.2s ease; }
        .btn-navy:hover, .btn-navy-active { background-color:var(--navy-sec); border-color:var(--navy-sec); color:#fff; box-shadow:0 4px 12px rgba(16,55,131,0.2); transform:translateY(-2px); }
        .btn-navy-active { box-shadow:inset 0 3px 5px rgba(0,0,0,0.125); transform:none; }
        .btn-outline-navy { color:var(--navy); border-color:var(--navy); background:0 0; transition:all 0.2s ease; }
        .btn-outline-navy:hover { background-color:var(--navy); color:#fff; transform:translateY(-2px); }
        .footer { background-color:var(--navy-sec); color:rgba(255,255,255,0.7); padding:40px 0; margin-top:auto; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <div id="app" class="d-flex flex-column flex-grow-1">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top navbar-public">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo_lautanteduhinterniaga.jpeg') }}" alt="Logo" height="40" class="me-2"> LAUTAN KARIR
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent"><span class="navbar-toggler-icon"></span></button>

                <div class="collapse navbar-collapse" id="navContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item"><a class="nav-link {{ Route::is('home') || Route::is('lowongan.*') ? 'active' : '' }}" href="{{ route('home') }}">Lowongan</a></li>
                        
                        @if (Auth::guard('pelamar')->check())
                            <li class="nav-item dropdown ms-3">
                                <a id="navDrop" class="nav-link dropdown-toggle btn px-4 rounded-pill" href="#" role="button" data-bs-toggle="dropdown">
                                    Halo, {{ Auth::guard('pelamar')->user()->nama }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                                    @foreach([
                                        ['route' => 'pelamar.dashboard', 'icon' => 'fas fa-columns', 'label' => 'Dashboard'],
                                        ['route' => 'pelamar.profile.edit', 'icon' => 'fas fa-user', 'label' => 'Profil Saya']
                                    ] as $menu)
                                        <a class="dropdown-item py-2" href="{{ route($menu['route']) }}"><i class="{{ $menu['icon'] }} me-2 text-muted"></i> {{ $menu['label'] }}</a>
                                    @endforeach
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item py-2 text-danger" href="{{ route('pelamar.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('pelamar.logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </li>
                        @else
                            @php
                                $links = [
                                    ['route' => 'pelamar.login', 'label' => 'Masuk', 'class' => 'nav-link fw-bold', 'active_cls' => 'active'],
                                    ['route' => 'pelamar.register', 'label' => 'Daftar', 'class' => 'btn btn-navy rounded-pill px-4 shadow-sm', 'active_cls' => 'btn-navy-active']
                                ];
                            @endphp
                            @foreach($links as $link)
                                <li class="nav-item ms-2">
                                    <a class="{{ $link['class'] }} {{ Route::is($link['route']) ? $link['active_cls'] : '' }}" href="{{ route($link['route']) }}">{{ $link['label'] }}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="flex-grow-1">@yield('content')</main>

        <footer class="footer">
            <div class="container text-center">
                <p class="mb-2 text-white">&copy; {{ date('Y') }} PT Lautan Teduh Interniaga. All rights reserved.</p>
                <small class="opacity-75">Portal Rekrutmen & Seleksi Pegawai</small>
            </div>
        </footer>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>