<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Lautan Karir'))</title>
    
    <link rel="preload" href="{{ asset('img/logo.png') }}" as="image">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root { 
            --navy:#103783; 
            --navy-sec:#0a265e; 
            --navy-acc:#4b6cb7; 
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            background-color:#f8f9fa; 
            font-family:'Nunito',sans-serif; 
            overflow-x: hidden;
        }
        
        /* Navbar Styles */
        .navbar-public { 
            background-color:#fff!important; 
            border-bottom:1px solid rgba(0,0,0,0.05);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: var(--transition);
        }
        
        .navbar-brand { 
            color:var(--navy)!important; 
            letter-spacing:-0.5px; 
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .nav-link { 
            color:#6c757d; 
            font-weight:600; 
            transition: var(--transition);
            padding-bottom:2px; 
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 80%;
            height: 2px;
            background: var(--navy);
            transition: var(--transition);
        }
        
        .nav-link:hover::after, 
        .nav-link.active::after { 
            transform: translateX(-50%) scaleX(1);
        }
        
        .nav-link:hover, 
        .nav-link.active { 
            color:var(--navy)!important; 
        }
        
        .btn-navy { 
            background-color:var(--navy); 
            border-color:var(--navy); 
            color:#fff; 
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(16,55,131,0.2);
        }
        
        .btn-navy:hover { 
            background-color:var(--navy-sec); 
            border-color:var(--navy-sec); 
            color:#fff; 
            box-shadow:0 4px 12px rgba(16,55,131,0.3);
            transform:translateY(-2px); 
        }
        
        /* Smooth Page Transitions */
        .page-transition {
            animation: fadeInUp 0.5s ease-out;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Footer Style Fix */
        .main-footer {
            background-color: #fff;
            border-top: 1px solid #e5e7eb;
            margin-top: auto; /* Pushing footer to bottom */
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <div id="app" class="d-flex flex-column flex-grow-1">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top navbar-public">
            <div class="container">
                <div class="navbar-brand d-flex align-items-center" style="cursor: default; pointer-events: none;">
                    <img src="{{ asset('img/logo.png') }}" 
                    alt="Lautan Karir"
                    class="img-fluid" 
                    style="height: 75px; width: auto; margin-right: 10px;">
                    <span class="fw-bold text-navy" style="font-size: 20px;">LAUTAN KARIR</span> 
                </div>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home') || Route::is('lowongan.*') ? 'active' : '' }}" 
                        href="{{ route('home') }}">Lowongan</a>
                    </li>
                    
                    @if (Auth::guard('pelamar')->check())
                        
                        <li class="nav-item ms-3 position-relative">
                            <a class="nav-link {{ Route::is('pelamar.dashboard') ? 'active' : '' }}" 
                            href="{{ route('pelamar.dashboard') }}">
                                Dashboard
                            </a>

                            @if(isset($unreadNotificationCount) && $unreadNotificationCount > 0)
                                <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"
                                    style="width: 10px; height: 10px; padding:0;">
                                </span>
                            @endif
                        </li>


                        <li class="nav-item dropdown ms-3">
                            <a id="navDrop" class="nav-link dropdown-toggle btn px-4 rounded-pill" 
                            href="#" role="button" data-bs-toggle="dropdown">
                                Halo, {{ Auth::guard('pelamar')->user()->nama }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                                
                                <a class="dropdown-item py-2" href="{{ route('pelamar.profile.edit') }}">
                                    <i class="fas fa-user me-2 text-muted"></i> Profil Saya
                                </a>
                                <hr class="dropdown-divider">
                                <a class="dropdown-item py-2 text-danger" href="{{ route('pelamar.logout') }}" 
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('pelamar.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    @else
                        <li class="nav-item ms-2">
                            <a class="nav-link fw-bold {{ Route::is('pelamar.login') ? 'active' : '' }}" 
                            href="{{ route('pelamar.login') }}">Masuk</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-navy rounded-pill px-4 shadow-sm {{ Route::is('pelamar.register') ? 'btn-navy-active' : '' }}" 
                            href="{{ route('pelamar.register') }}">Daftar</a>
                        </li>
                    @endif
                </ul>
                </div>
            </div>
        </nav>

        <main class="flex-grow-1 page-transition">
            @yield('content')
        </main>

        <footer class="main-footer pt-5 pb-4 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <h5 class="fw-bold text-navy mb-3">LAUTAN KARIR</h5>
                        <p class="text-muted small" style="line-height: 1.6;">
                            Platform rekrutmen resmi <strong>PT. Lautan Teduh Interniaga</strong>. 
                            Bergabunglah bersama kami untuk mewujudkan potensi terbaik Anda dalam industri otomotif.
                        </p>
                    </div>

                    <div class="col-lg-4 mb-4">
                        <h6 class="fw-bold text-dark mb-3">Kantor Pusat</h6>
                        <ul class="list-unstyled text-muted small">
                            <li class="mb-2 d-flex">
                                <i class="fas fa-map-marker-alt mt-1 me-3 text-navy"></i>
                                <span>
                                    Jl. Ikan Tenggiri No. 24,<br>
                                    Teluk Betung, Bandar Lampung,<br>
                                    Lampung 35223
                                </span>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-4 mb-4">
                        <h6 class="fw-bold text-dark mb-3">Hubungi Kami</h6>
                        <ul class="list-unstyled text-muted small">
                            <li class="mb-2">
                                <a href="mailto:recruitment@lautanteduh.co.id" class="text-decoration-none text-muted">
                                    <i class="fas fa-envelope me-2 text-navy"></i> 
                                    recruitment@lautanteduh.co.id
                                </a>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-phone me-2 text-navy"></i> 
                                (0721) 481777
                            </li>
                            <li class="mt-4">
                                <a href="#" class="btn btn-sm btn-outline-navy rounded-circle me-2" style="width: 32px; height: 32px; padding: 0; line-height: 30px;"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-navy rounded-circle me-2" style="width: 32px; height: 32px; padding: 0; line-height: 30px;"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-navy rounded-circle" style="width: 32px; height: 32px; padding: 0; line-height: 30px;"><i class="fab fa-facebook-f"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-top pt-3 mt-3">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center text-md-start">
                            <small class="text-muted">
                                &copy; {{ date('Y') }} <strong>PT. Lautan Teduh Interniaga</strong>. All rights reserved.
                            </small>
                        </div>
                        <div class="col-md-6 text-center text-md-end d-none d-md-block">
                            <small class="text-muted opacity-75">
                                Portal Rekrutmen & Seleksi Pegawai
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>