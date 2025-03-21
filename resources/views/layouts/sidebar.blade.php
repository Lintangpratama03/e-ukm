<div class="leftside-menu leftside-menu-detached">
    <div class="leftbar-user">
        <a href="javascript: void(0);">
            <img src="{{ asset('storage/' . (Auth::user()->profil->logo ?? 'assets/images/default-avatar.png')) }}"
                alt="user-image" height="60" class="rounded-circle shadow-sm">
            <h5 class="leftbar-user-name mt-2">{{ Auth::user()->profil->nama ?? 'User' }}</h5>
        </a>
    </div>

    @if (Auth::user()->role == 'admin')
        <ul class="side-nav">
            <li class="side-nav-title side-nav-item">Dashboard</li>
            <li class="side-nav-item">
                <a href="{{ route('admin.dashboard.index') }}" class="side-nav-link">
                    <i class="uil-dashboard"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('home') }}" class="side-nav-link">
                    <i class="uil-dashboard"></i>
                    <span> Landing Page </span>
                </a>
            </li>

            <li class="side-nav-title side-nav-item">Profil</li>
            <li class="side-nav-item">
                <a href="{{ route('profile.edit') }}" class="side-nav-link">
                    <i class="uil-user-circle"></i>
                    <span> Kelola Profil </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('anggota.index') }}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Kelola Anggota </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('admin.bem.paraf.index') }}" class="side-nav-link">
                    <i class="uil-pen"></i>
                    <span> Paraf Ketua BEM </span>
                </a>
            </li>

            <li class="side-nav-title side-nav-item">Layanan</li>
            <li class="side-nav-item">
                <a href="{{ route('admin.tempat.index') }}" class="side-nav-link">
                    <i class="uil-map-marker"></i>
                    <span> Kelola Tempat </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('admin.jadwal.index') }}" class="side-nav-link">
                    <i class="uil-schedule"></i>
                    <span> Kelola Jadwal </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('dokumentasi.index') }}" class="side-nav-link">
                    <i class="uil-file-alt"></i>
                    <span> Kelola Dokumentasi </span>
                </a>
            </li>

            <li class="side-nav-title side-nav-item">Akun</li>
            <li class="side-nav-item">
                <a href="{{ route('admin.user.index') }}" class="side-nav-link">
                    <i class="uil-user"></i>
                    <span> Kelola Akun UKM </span>
                </a>
            </li>

            <li class="side-nav-title side-nav-item">Logout</li>
            <li class="side-nav-item">
                <a href="{{ route('logout') }}" class="side-nav-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="dripicons-arrow-thin-left"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    @elseif (Auth::user()->role == 'user')
        <ul class="side-nav">
            <li class="side-nav-title side-nav-item">Dashboard</li>
            <li class="side-nav-item">
                <a href="{{ route('user.dashboard.index') }}" class="side-nav-link">
                    <i class="uil-dashboard"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('home') }}" class="side-nav-link">
                    <i class="uil-dashboard"></i>
                    <span> Landing Page </span>
                </a>
            </li>
            <li class="side-nav-title side-nav-item">Profil</li>
            <li class="side-nav-item">
                <a href="{{ route('profile.edit') }}" class="side-nav-link">
                    <i class="uil-user-circle"></i>
                    <span> Kelola Profil </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('anggota.index') }}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Kelola Anggota </span>
                </a>
            </li>

            <li class="side-nav-title side-nav-item">Layanan</li>
            <li class="side-nav-item">
                <a href="{{ route('user.jadwal.index') }}" class="side-nav-link">
                    <i class="uil-schedule"></i>
                    <span> Ajukan Jadwal </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('dokumentasi.index') }}" class="side-nav-link">
                    <i class="uil-file-alt"></i>
                    <span> Kelola Dokumentasi </span>
                </a>
            </li>

            <li class="side-nav-title side-nav-item">Logout</li>
            <li class="side-nav-item">
                <a href="{{ route('logout') }}" class="side-nav-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="dripicons-arrow-thin-left"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    @endif
</div>
