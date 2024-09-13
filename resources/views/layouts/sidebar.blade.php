<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item {{ $active == 'beranda' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="ti-home menu-icon"></i>
          <span class="menu-title">Beranda</span>
        </a>
      </li>      
      <li class="nav-item {{ $active == 'jadwal' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('jadwal') }}">
          <i class="ti-calendar menu-icon"></i>
          <span class="menu-title">{{ auth()->user()->level == "admin" ? "Jadwal" : "Riwayat" }} Checkup</span>
        </a>
      </li>      
      <li class="nav-item {{ $active == 'alarm' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('alarm') }}">
          <i class="ti-alarm-clock menu-icon"></i>
          <span class="menu-title">{{ auth()->user()->level == "admin" ? "Jadwal" : "Riwayat" }} Minum Obat</span>
        </a>
      </li>   
      @if (auth()->user()->level == "admin")
      <li class="nav-item {{ $active == 'dokter' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dokter') }}">
          <i class="ti-book menu-icon"></i>
          <span class="menu-title">Data Dokter</span>
        </a>
      </li>      
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <i class="ti-user menu-icon"></i>
          <span class="menu-title">Manage Users</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('user', 'pasien') }}">Manage Pasien</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{ $active == 'obat' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('obat') }}">
          <i class="ti-plus menu-icon"></i>
          <span class="menu-title">Manage Obat</span>
        </a>
      </li>      
          
      @endif   
    </ul>
  </nav>