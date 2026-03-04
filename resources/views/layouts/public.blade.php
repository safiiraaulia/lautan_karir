<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Lautan Karir'))</title>
    
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root { 
            --navy:#103783; 
            --navy-sec:#0a265e; 
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        body { background-color:#f8f9fa; font-family:'Nunito',sans-serif; min-height: 100vh; display: flex; flex-direction: column; }
        
        /* Navbar Styles */
        .navbar-public { background-color:#fff!important; border-bottom:1px solid rgba(0,0,0,0.05); box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        
        .nav-link { 
            color:#6c757d; 
            font-weight:600; 
            transition: var(--transition); 
            position: relative; 
            padding-bottom: 4px;
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

        .nav-link:hover, .nav-link.active { color:var(--navy)!important; }
        
        .notif-dot {
            position: absolute;
            top: -2px; 
            right: -8px; 
            height: 8px;
            width: 8px;
            background-color: #ff0000;
            border-radius: 50%;
            display: inline-block;
            border: 1px solid #fff;
            z-index: 5;
        }

        .btn-navy { background-color:var(--navy); color:#fff; border-radius: 50px; padding: 8px 25px; transition: var(--transition); }
        .btn-navy:hover { background-color:var(--navy-sec); color:#fff; transform:translateY(-2px); }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <div id="app" class="flex-grow-1">
        <nav class="navbar navbar-expand-md navbar-light bg-white sticky-top navbar-public">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" style="height: 65px; width: auto; margin-right: 12px;">
                    <span class="fw-bold text-navy" style="font-size: 20px;">LAUTAN KARIR</span> 
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('home') || Route::is('lowongan.*') ? 'active' : '' }}" href="{{ route('home') }}">Lowongan</a>
                        </li>
                        
                        @if (Auth::guard('pelamar')->check())
                            <li class="nav-item ms-md-3">
                                <a class="nav-link {{ Route::is('pelamar.dashboard') ? 'active' : '' }}" href="{{ route('pelamar.dashboard') }}">
                                    Dashboard
                                    @php
                                        $hasUpdate = \App\Models\Lamaran::where('pelamar_id', Auth::guard('pelamar')->id())
                                            ->where('is_read', false)
                                            ->whereIn('status', ['Lolos Seleksi', 'Gagal Seleksi'])
                                            ->exists();
                                    @endphp
                                    @if($hasUpdate)
                                        <span class="notif-dot"></span>
                                    @endif
                                </a>
                            </li>

                            <li class="nav-item dropdown ms-md-3">
                                <a class="nav-link dropdown-toggle btn px-4 rounded-pill" href="#" role="button" data-bs-toggle="dropdown">
                                    Halo, {{ Auth::guard('pelamar')->user()->nama }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <a class="dropdown-item py-2" href="{{ route('pelamar.profile.edit') }}"><i class="fas fa-user me-2 text-muted"></i> Profil Saya</a>
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item py-2 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('pelamar.logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </li>
                        @else
                            <li class="nav-item ms-md-2"><a class="nav-link fw-bold" href="{{ route('login') }}">Masuk</a></li>
                            <li class="nav-item ms-md-2"><a class="btn btn-navy" href="{{ route('register') }}">Daftar</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    <footer class="bg-white border-top pt-5 pb-4 mt-auto">
        <div class="container text-center text-md-start">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold text-navy mb-3">LAUTAN KARIR</h5>
                    <p class="text-muted small">Platform rekrutmen resmi <strong>PT. Lautan Teduh Interniaga</strong>.</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h6 class="fw-bold text-dark mb-3">Alamat</h6>
                    <small class="text-muted">Jl. Ikan Tenggiri, Pesawahan, Kec. Telukbetung Selatan, Bandar Lampung, Lampung 35111</small>
                </div>
                <div class="col-lg-4 mb-4 text-md-end">
                    <h6 class="fw-bold text-dark mb-3">Kontak</h6>
                    <small class="text-muted">Telepon: 0821-7931-9141</small>
                </div>
            </div>
            <div class="border-top pt-3 mt-3 text-center">
                <small class="text-muted">&copy; {{ date('Y') }} PT. Lautan Teduh Interniaga. All rights reserved.</small>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')

    @if(Route::is('pelamar.dashboard'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route("pelamar.markRead") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(response => {
                if(response.ok) {
                    const dot = document.querySelector('.notif-dot');
                    if(dot) dot.style.display = 'none';
                }
            });
        });
    </script>
    @endif
</body>
</html>