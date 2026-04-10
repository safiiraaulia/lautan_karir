<aside class="main-sidebar sidebar-light-navy elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link d-flex align-items-center border-bottom">
        <img src="{{ asset('img/logo.PNG') }}" 
             alt="Lautan Karir Logo" 
             class="brand-image img-circle elevation-2" 
             style="opacity: .9; max-height: 33px;">
             
        <span class="brand-text font-weight-bold text-dark ml-2">LAUTAN KARIR</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block font-weight-bold">
                    Halo, {{ Auth::guard('admin')->user()->username }}
                    <!-- <small class="d-block text-muted">({{ Auth::guard('admin')->user()->role }})</small> -->
                </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(in_array(Auth::guard('admin')->user()->role, ['SUPER_ADMIN', 'HRD']))

                    <li class="nav-header font-weight-bold">DATA MASTER</li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.dealer.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.dealer.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-store"></i>
                            <p>Master Dealer</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.posisi.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.posisi.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>Master Posisi</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.kriteria.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.kriteria.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Master Kriteria</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.bank-soal.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.bank-soal.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tasks"></i> 
                            <p>Master Soal</p>
                        </a>
                    </li>

                    <li class="nav-header font-weight-bold">REKRUTMEN</li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.lowongan.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.lowongan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bullhorn"></i>
                            <p>Kelola Lowongan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.seleksi.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.seleksi.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Seleksi & Perangkingan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.hasil_tes.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.hasil_tes.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-check"></i>
                            <p>Rekapitulasi Psikotes</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.laporan.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Rekrutmen</p>
                        </a>
                    </li>

                @endif

                @if(Auth::guard('admin')->user()->role === 'SUPER_ADMIN')
                
                    <li class="nav-header font-weight-bold">PENGGUNA</li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.pelamar.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.pelamar.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Kelola Pelamar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i> 
                            <p>Kelola Admin</p> 
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>