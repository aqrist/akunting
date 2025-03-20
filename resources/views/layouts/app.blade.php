<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Akunting')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
        }

        .sidebar .nav-link:hover {
            color: #fff;
        }

        .sidebar .nav-link.active {
            color: #fff;
            font-weight: bold;
        }

        .main-content {
            padding: 20px;
        }

        .dashboard-card {
            transition: all 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
    @yield('styles')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 p-0 sidebar">
                <div class="d-flex flex-column p-3 text-white">
                    <a href="{{ route('dashboard') }}"
                        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-4">Akunting App</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="fa fa-dashboard me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('projects.index') }}"
                                class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                                <i class="fa fa-briefcase me-2"></i>
                                Project
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('transaksi.index') }}"
                                class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                                <i class="fa fa-money-bill me-2"></i>
                                Transaksi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('karyawan.index') }}"
                                class="nav-link {{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
                                <i class="fa fa-users me-2"></i>
                                Karyawan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('biaya.index') }}"
                                class="nav-link {{ request()->routeIs('biaya.*') ? 'active' : '' }}">
                                <i class="fa fa-receipt me-2"></i>
                                Biaya Operasional
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="collapse"
                                data-bs-target="#laporan-collapse">
                                <i class="fa fa-chart-bar me-2"></i>
                                Laporan
                            </a>
                            <div class="collapse {{ request()->routeIs('laporan.*') ? 'show' : '' }}"
                                id="laporan-collapse">
                                <ul class="nav nav-pills flex-column ms-3">
                                    <li>
                                        <a href="{{ route('laporan.arus-kas') }}"
                                            class="nav-link {{ request()->routeIs('laporan.arus-kas') ? 'active' : '' }}">
                                            <i class="fa fa-stream me-2"></i>
                                            Arus Kas
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('laporan.pendapatan') }}"
                                            class="nav-link {{ request()->routeIs('laporan.pendapatan') ? 'active' : '' }}">
                                            <i class="fa fa-arrow-up me-2"></i>
                                            Pendapatan
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('laporan.biaya') }}"
                                            class="nav-link {{ request()->routeIs('laporan.biaya') ? 'active' : '' }}">
                                            <i class="fa fa-arrow-down me-2"></i>
                                            Biaya
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('laporan.laba-rugi') }}"
                                            class="nav-link {{ request()->routeIs('laporan.laba-rugi') ? 'active' : '' }}">
                                            <i class="fa fa-balance-scale me-2"></i>
                                            Laba Rugi
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown">
                        <a href="#"
                            class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Avatar::create(Auth::user()->name)->toBase64(); }}" alt="User" width="32" height="32"
                                class="rounded-circle me-2">
                            <strong>{{ Auth::user()->name }}</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top Navbar -->
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        @yield('page-actions')
                    </div>
                </div>

                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Main Content Area -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    @yield('scripts')
</body>

</html>
