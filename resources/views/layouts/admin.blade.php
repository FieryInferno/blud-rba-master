<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard &mdash; {{ config('app.name') }}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-4.3.1.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/iziToast.min.css') }}">
  @yield('css')
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ asset('img/logo.png') }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hai, {{ Auth::user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="{{ route('admin.users.profile') }}" class="dropdown-item has-icon">
                <i class="fa fa-user"></i> Profil Saya
              </a>

              @if (Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.page') }}" class="dropdown-item has-icon">
                  <i class="fa fa-cog"></i> Pengaturan Umum
                </a>
              @endif

              @if (Auth::user()->hasRole('admin'))
              <a href="{{ route('admin.users.index') }}" class="dropdown-item has-icon">
                  <i class="fa fa-users"></i> Pengguna
                </a>
              @endif
              <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Keluar Aplikasi
              </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ route('admin.index') }}">{{ config('app.name') }}</a>
            <small><strong>{{ auth()->user()->statusAnggaran->status_anggaran }}</strong></small>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.index') }}">BLUD</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li class="nav-item dropdown{{ Request::routeIs('admin.index') == 1 ? ' active' : '' }}">
              <a href="{{ route('admin.index') }}" class="nav-link"><i class="fas fa-home"></i><span>Beranda</span></a>
              </li>
              <li class="menu-header">Menu</li>
              <li class="nav-item dropdown {{ Request::is('blud/organisasi/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                  <i class="fas fa-th"></i> <span>BLUD</span>
                </a>
                <ul class="dropdown-menu" style="display:{{ Request::is('blud/organisasi/*') ? 'block' : 'none' }}">
                  <li class="{{ Request::routeIs('admin.fungsi.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.fungsi.index') }}">Fungsi</a></li>
                  <li class="{{ Request::routeIs('admin.urusan.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.urusan.index') }}">Urusan</a></li>
                  <li class="{{ Request::routeIs('admin.bidang.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.bidang.index') }}">Bidang</a></li>
                  <li class="{{ Request::routeIs('admin.opd.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.opd.index') }}">OPD</a></li>
                  <li class="{{ Request::routeIs('admin.unit_kerja.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.unit_kerja.index') }}">Unit Kerja</a></li>
                  <li class="{{ Request::routeIs('admin.pejabat_unit.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.pejabat_unit.index') }}">Pejabat Unit</a></li>
                  <li class="{{ Request::routeIs('admin.program.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.program.index') }}">Program</a></li>
                  <li class="{{ Request::routeIs('admin.kegiatan.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.kegiatan.index') }}">Kegiatan</a></li>
                  <li class="{{ Request::routeIs('admin.subKegiatan.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.subKegiatan.index') }}">Sub Kegiatan</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown {{ Request::is('blud/data-dasar/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                  <i class="fas fa-database"></i> <span>Master RBA</span>
                </a>
                <ul class="dropdown-menu" style="display:{{ Request::is('blud/data-dasar/*') ? 'block' : 'none' }}">
                  <li class="{{ Request::routeIs('admin.pejabat.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.pejabat.index') }}">Pejabat Daerah</a></li>
                  <li class="{{ Request::routeIs('admin.kategoriakun.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.kategoriakun.index') }}">Kategori Akun</a></li>
                  <li class="{{ Request::routeIs('admin.akun.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.akun.index') }}">Akun</a></li>
                  <li class="{{ Request::routeIs('admin.map_akun.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.map_akun.index') }}">Pemetaan Akun</a></li>
                  <li class="{{ Request::routeIs('admin.map_kegiatan.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.map_kegiatan.index') }}">Pemetaan Kegiatan</a></li>
                  <li class="{{ Request::routeIs('admin.sumber_dana.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.sumber_dana.index') }}">Sumber Dana</a></li>
                  <li class="{{ Request::routeIs('admin.ssh.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.ssh.index') }}">Standard Barang</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown {{ Request::is('blud/rba/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-money-bill"></i> <span>RBA</span></a>
                <ul class="dropdown-menu" style="display:{{ Request::is('blud/rba/*') ? 'block' : 'none' }}">
                  <li class="{{ Request::routeIs('admin.rba1.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.rba1.index') }}">RBA 1</a></li>
                  <li class="{{ Request::routeIs('admin.rba2.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.rba2.index') }}">RBA 2.2.1</a></li>
                  <li class="{{ Request::routeIs('admin.rba31.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.rba31.index') }}">RBA 3.1</a></li>
                  {{-- <li class="{{ Request::routeIs('admin.rba32.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.rba32.index') }}">RBA 3.2</a></li> --}}
                  <li class="{{ Request::routeIs('admin.rba.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.rba.index') }}">RBA</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown {{ Request::is('blud/rka/*') ? 'active' : '' }}">
                  <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-receipt"></i> <span>RKA OPD</span></a>
                  <ul class="dropdown-menu">
                    <li class="{{ Request::routeIs('admin.rka.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.rka.index') }}">RKA OPD</a></li>
                    <li class="{{ Request::routeIs('admin.rka1.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.rka1.index') }}">RKA OPD 1</a></li>
                    <li class="{{ Request::routeIs('admin.rka21.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.rka21.index') }}">RKA OPD 2.1</a></li>
                    <li class="{{ Request::routeIs('admin.rka221.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.rka221.index') }}">RKA OPD 2.2.1</a></li>
                  </ul>
                </li>
                @if (auth()->user()->statusAnggaran->is_copyable == true)
                  @if (auth()->user()->hasRole('Admin'))
                  <li class="nav-item dropdown {{ Request::is('blud/utilitas/*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-copy"></i> <span>Konfigurasi</span></a>
                    <ul class="dropdown-menu">
                      <li class="{{ Request::routeIs('admin.salinanggaran.rba') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.salinanggaran.rba') }}">Salin Anggaran RBA</a></li>
                      <li class="{{ Request::routeIs('admin.salinanggaran.rka') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.salinanggaran.rka') }}">Salin Anggaran RKA</a></li>
                    </ul>
                  </li>
                  @endif
                @endif
                <li class="nav-item dropdown {{ Request::is('blud/report') ? 'active' : '' }}">
                  <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-file-alt"></i> <span>Laporan</span>
                  </a>
                  <ul class="dropdown-menu">
                    <li class="{{ Request::routeIs('admin.report.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.report.index') }}">Laporan RBA</a></li>
                  </ul>
                </li>

                @if (auth()->user()->hasRole('Admin'))
                  <li class="nav-item">
                    <a href="{{ route('admin.hak_akses.index') }}" class="nav-link">
                      <i class="fas fa-users"></i> <span>Hak Akses</span>
                    </a>
                  </li>
                @endif
            </ul>

            {{-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
              </a>
            </div> --}}
        </aside>
      </div>

      <!-- Main Content -->
      @yield('content')

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; {{ date('Y') }} <div class="bullet"></div> {{ config('app.name') }}
        </div>
        <div class="footer-right">
          {{ config('app.version') }}
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('dashboard/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/popper-1.14.7.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/bootstrap-4.3.1.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/jquery.ninescroll-3.7.6.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/moment-2.24.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/stisla.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('dashboard/js/iziToast.min.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('dashboard/js/scripts.js') }}"></script>
  <script src="{{ asset('dashboard/js/custom.js') }}"></script>
  <script src="{{ asset('dashboard/js/jquery.maskMoney.min.js') }}"></script>

  <!-- Page Specific JS File -->
  <script>
    function formatCurrency(amount, decimalSeparator, thousandsSeparator, nDecimalDigits){  
      let num = parseFloat( amount ); //convert to float  
      //default values  
      decimalSeparator = decimalSeparator || ',';  
      thousandsSeparator = thousandsSeparator || '.';  
      nDecimalDigits = nDecimalDigits == null? 2 : nDecimalDigits;  
    
      let fixed = num.toFixed(nDecimalDigits); //limit or add decimal digits  
      //separate begin [$1], middle [$2] and decimal digits [$4]  
      let parts = new RegExp('^(-?\\d{1,3})((?:\\d{3})+)(\\.(\\d{' + nDecimalDigits + '}))?$').exec(fixed);   
    
      if(parts){ //num >= 1000 || num < = -1000  
          return parts[1] + parts[2].replace(/\d{3}/g, thousandsSeparator + '$&') + (parts[4] ? decimalSeparator + parts[4] : '');  
      }else{  
          return fixed.replace('.', decimalSeparator);  
      }  
    }
  </script>
  @yield('js')
</body>
</html>
