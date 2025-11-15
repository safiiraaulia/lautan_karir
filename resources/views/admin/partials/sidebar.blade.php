<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">
                    {{ Auth::user()->username }}
                    ({{ Auth::user()->role }})
                </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(in_array(Auth::user()->role, ['SUPER_ADMIN', 'HR_PUSAT']))

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

                @endif

                @if(Auth::user()->role === 'SUPER_ADMIN')
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Kelola User</p>
                        </a>
                    </li>
                @endif

            </ul>
        </nav>

    </div>
</aside>
