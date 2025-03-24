<nav
    class="navbar navbar-expand-lg  blur border-radius-xl top-0 z-index-fixed shadow position-absolute my-3 p-2 start-0 end-0 mx-4">
    <div class="container-fluid px-0">
        <a class="navbar-brand font-weight-bolder ms-sm-3 text-sm"
            href="https://demos.creative-tim.com/material-kit/index" rel="tooltip"
            title="Designed and Coded by Huda Dirgantara" data-placement="bottom" target="_blank">
            E-UKM POLINEMA KEDIRI
        </a>
        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
            data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse pt-3 pb-2 py-lg-0 w-100" id="navigation">
            <ul class="navbar-nav navbar-nav-hover ms-auto">
                <li class="nav-item dropdown dropdown-hover mx-2">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center font-weight-semibold"
                        href="{{ route('home') }}">
                        <i class="material-symbols-rounded opacity-6 me-2 text-md">dashboard</i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item dropdown dropdown-hover mx-2">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center font-weight-semibold"
                        id="dropdownMenuUkm" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="material-symbols-rounded opacity-6 me-2 text-md">view_day</i>
                        UKM
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-animation dropdown-md dropdown-md-responsive p-3 border-radius-lg mt-0 mt-lg-3"
                        aria-labelledby="dropdownMenuUkm">
                        <div class="d-none d-lg-block">
                            <li class="nav-item">
                                <h6
                                    class="dropdown-header text-dark font-weight-bolder d-flex justify-content-center align-items-center p-0">
                                    Daftar UKM
                                </h6>
                            </li>
                            @php
                                $ukmList = App\Models\Profil::all();
                            @endphp

                            @foreach ($ukmList as $ukm)
                                <li class="nav-item">
                                    <a class="dropdown-item py-2 ps-3 border-radius-md"
                                        href="{{ route('home.profil-ukm', $ukm->user_id) }}">
                                        <div class="w-100 d-flex align-items-center justify-content-between">
                                            <div>
                                                <span class="text-sm">{{ $ukm->nama }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </div>

                        <!-- For mobile view -->
                        <div class="row d-lg-none">
                            <div class="col-md-12">
                                <h6
                                    class="dropdown-header text-dark font-weight-bolder d-flex justify-content-center align-items-center p-0">
                                    Daftar UKM
                                </h6>
                                <div class="d-flex flex-column">
                                    @foreach ($ukmList as $ukm)
                                        <a class="dropdown-item py-2 ps-3 border-radius-md"
                                            href="{{ route('home.profil-ukm', $ukm->user_id) }}">
                                            <span class="text-sm">{{ $ukm->nama }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </ul>
                </li>
                <li class="nav-item dropdown dropdown-hover mx-2">
                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center font-weight-semibold"
                        href="{{ route('home.jadwal') }}">
                        <i class="material-symbols-rounded opacity-6 me-2 text-md">article</i>
                        Jadwal Kegiatan
                    </a>
                </li>
                @if (Auth::check())
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item my-auto ms-3 ms-lg-0">
                            <a href="{{ route('admin.dashboard.index') }}"
                                class="btn bg-gradient-dark mb-0 mt-2 mt-md-0">Dashboard</a>
                        </li>
                    @elseif (Auth::user()->role == 'user')
                        <li class="nav-item my-auto ms-3 ms-lg-0">
                            <a href="{{ route('user.dashboard.index') }}"
                                class="btn bg-gradient-dark mb-0 mt-2 mt-md-0">Dashboard</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item my-auto ms-3 ms-lg-0">
                        <a href="{{ route('login') }}" class="btn bg-gradient-dark mb-0 mt-2 mt-md-0">Login</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
