<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">

        @if (hasAccess(Auth::user()->internal_role_id, "Executive Dashboard", "View"))
        <div class="pcoded-navigatio-lavel">Dashboard Analysis</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu {{(Request::segment(2) == 'monitoring') ? 'pcoded-trigger active' : ''}}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-bar-chart"></i></span>
                    <span class="pcoded-mtext">Monitoring</span>
                </a>
                <ul class="pcoded-submenu">
                    @if (hasAccess(Auth::user()->internal_role_id, "Executive Dashboard", "View"))
                    <li class="{{(Request::segment(3) == 'map-dashboard') ? 'active' : ''}}">
                        <a href="{{ url('admin/map-dashboard') }}">
                            <span class="pcoded-mtext">Executive Dashboard</span>
                        </a>
                    </li>
                    @endif
                    @if (hasAccess(Auth::user()->internal_role_id, "Proyek Kontrak", "View"))
                    <li class="{{(Request::segment(3) == 'proyek-kontrak') ? 'active' : ''}}">
                        <a href="{{ url('admin/monitoring/proyek-kontrak') }}">
                            <span class="pcoded-mtext">Proyek Kontrak</span>
                        </a>
                    </li>
                    @endif
                    @if (hasAccess(Auth::user()->internal_role_id, "Kemantapan Jalan", "View"))
                    <li class="{{(Request::segment(3) == 'kemantapan-jalan') ? 'active' : ''}}">
                        <a href="{{ url('admin/monitoring/kemantapan-jalan') }}">
                            <span class="pcoded-mtext">Kemantapan Jalan</span>
                        </a>
                    </li>
                    @endif
                    @if (hasAccess(Auth::user()->internal_role_id, "Laporan Kerusakan", "View"))
                    <li class="{{(Request::segment(3) == 'laporan-kerusakan') ? 'active' : ''}}">
                        <a href="{{ url('admin/monitoring/laporan-kerusakan') }}">
                            <span class="pcoded-mtext">Laporan Kerusakan</span>
                        </a>
                    </li>
                    @endif
                    @if (hasAccess(Auth::user()->internal_role_id, "Anggaran & Realisasi Keuangan", "View"))
                    <li class="{{(Request::segment(3) == 'realisasi-keuangan') ? 'active' : ''}}">
                        <a href="{{ url('admin/monitoring/realisasi-keuangan') }}">
                            <span class="pcoded-mtext">Anggaran & Realisasi Keuangan</span>
                        </a>
                    </li>
                    @endif
                    @if (hasAccess(Auth::user()->internal_role_id, "Survey Kondisi Jalan", "View"))
                    <li class="{{(Request::segment(3) == 'survey-kondisi-jalan') ? 'active' : ''}}">
                        <a href="{{ url('admin/monitoring/survey-kondisi-jalan') }}">
                            <span class="pcoded-mtext">Survey Kondisi Jalan</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
        </ul>
        @endif
        @if (hasAccess(Auth::user()->internal_role_id, "Disposisi", "View"))
        <div class="pcoded-navigatio-lavel">Disposisi</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu {{(Request::segment(2) == 'landing-page') ? 'pcoded-trigger active' : ''}}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-home"></i></span>
                    <span class="pcoded-mtext">Disposisi</span>
                </a>
                <ul class="pcoded-submenu">
                    @if (hasAccess(Auth::user()->internal_role_id, "Kirim Disposisi", "View"))
                    <li class="{{(Request::segment(3) == 'kirim') ? 'active' : ''}}">
                        <a href="{{ url('admin/disposisi') }}">
                            <span class="pcoded-mtext">Kirim Disposisi </span>
                        </a>
                    </li>
                    @endif
                    @if (hasAccess(Auth::user()->internal_role_id, "Disposisi Masuk", "View"))
                    <li class="{{(Request::segment(3) == 'masuk') ? 'active' : ''}}">
                        <a href="{{ url('admin/disposisi/masuk') }}"> <span class="pcoded-mtext">  Disposisi Masuk</span> </a>
                    </li>
                    @endif
                    @if (hasAccess(Auth::user()->internal_role_id, "Disposisi Tindak Lanjut", "View"))
                    <li class="{{(Request::segment(3) == 'tindaklanjut') ? 'active' : ''}}">
                        <a href="{{ url('admin/disposisi/tindaklanjut') }}"> <span class="pcoded-mtext">  Disposisi Tindak Lanjut</span> </a>
                    </li>
                    @endif
                    @if (hasAccess(Auth::user()->internal_role_id, "Disposisi Instruksit", "View"))
                    <li class="{{(Request::segment(3) == 'instruksi') ? 'active' : ''}}">
                        <a href="{{ url('admin/disposisi/instruksi') }}"> <span class="pcoded-mtext">  Disposisi Instruksi</span> </a>
                    </li>
                    @endif
                </ul>
            </li>
        </ul>
        @endif

        @if (hasAccess(Auth::user()->internal_role_id, "Manage", "View"))
        <div class="pcoded-navigatio-lavel">Manage</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu {{(Request::segment(2) == 'master-data') ? 'pcoded-trigger active' : ''}}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-home"></i></span>
                    <span class="pcoded-mtext">Manage</span>
                </a>
                <ul class="pcoded-submenu">
                    @if (hasAccess(Auth::user()->internal_role_id, "User", "View"))
                    <li class="pcoded-hasmenu {{(Request::segment(3) == 'user') ? 'pcoded-trigger active' : ''}}">
                        <!-- <a href="{{ url('admin/master-data/user') }}"> -->
                        <a href="javascript:void(0)">
                            <span class="pcoded-mtext">User</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{(Request::segment(4) == 'user_role') ? 'active' : ''}}">
                                <a href="{{ route('getDataUserRole') }}">
                                    <span class="pcoded-mtext">User Role</span>
                                </a>
                            </li>
                            <li class="{{(Request::segment(4) == 'role_akses') ? 'active' : ''}}">
                                <a href="{{ route('getRoleAkses') }}">
                                    <span class="pcoded-mtext">Role Akses</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if (hasAccess(Auth::user()->internal_role_id, "Ruas Jalan", "View"))
                    <li class="{{(Request::segment(3) == 'ruas_Jalan') ? 'active' : ''}}">
                        <a href="{{ url('admin/master-data/ruas-jalan') }}">
                            <span class="pcoded-mtext">Ruas Jalan</span>
                        </a>
                    </li>
                    @endif
                    @if (hasAccess(Auth::user()->internal_role_id, "Jembatan", "View"))
                    <li class="{{(Request::segment(3) == 'jembatan') ? 'active' : ''}}">
                        <a href="{{ url('admin/master-data/jembatan') }}">
                            <span class="pcoded-mtext">Jembatan</span>
                        </a>
                    </li>
                    @endif
                    @if (hasAccess(Auth::user()->internal_role_id, "Rawan Bencana", "View"))
                    <li class="{{(Request::segment(3) == 'rawanbencana') ? 'active' : ''}}">
                        <a href="{{ url('admin/master-data/rawanbencana') }}">
                            <span class="pcoded-mtext">Rawan Bencana</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
        </ul>
        @endif

        <div class="pcoded-navigatio-lavel">Landing Page</div>
        <ul class="pcoded-item pcoded-left-item">
            @if (hasAccess(Auth::user()->internal_role_id, "Landing Page", "View"))
            <li class="pcoded-hasmenu {{(Request::segment(2) == 'landing-page') ? 'pcoded-trigger active' : ''}}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-home"></i></span>
                    <span class="pcoded-mtext">Landing Page</span>
                </a>
                <ul class="pcoded-submenu">
                    @if (!Auth::user()->internalRole->uptd)
                        @if (hasAccess(Auth::user()->internal_role_id, "Profil", "View"))
                        <li class="{{(Request::segment(3) == 'profil') ? 'active' : ''}}">
                            <a href="{{ url('admin/landing-page/profil') }}">
                                <span class="pcoded-mtext">Profil</span>
                            </a>
                        </li>
                        @endif
                        @if (hasAccess(Auth::user()->internal_role_id, "Slideshow", "View"))
                        <li class="{{(Request::segment(3) == 'slideshow') ? 'active' : ''}}">
                            <a href="{{ url('admin/landing-page/slideshow') }}">
                                <span class="pcoded-mtext">Slideshow</span>
                            </a>
                        </li>
                        @endif
                        @if (hasAccess(Auth::user()->internal_role_id, "Fitur", "View"))
                        <li class="{{(Request::segment(3) == 'fitur') ? 'active' : ''}}">
                            <a href="{{ url('admin/landing-page/fitur') }}">
                                <span class="pcoded-mtext">Fitur</span>
                            </a>
                        </li>
                        @endif
                    @endif
                    @if (hasAccess(Auth::user()->internal_role_id, "UPTD", "View"))
                    <li class="{{(Request::segment(3) == 'uptd') ? 'active' : ''}}">
                        <a href="{{ url('admin/landing-page/uptd') }}">
                            <span class="pcoded-mtext">UPTD</span>
                        </a>
                    </li>
                    @endif
                    <li class="{{(Request::segment(3) == 'laporan-masyarakat') ? 'active' : ''}}">
                        <a href="{{ url('admin/landing-page/laporan-masyarakat') }}">
                            <span class="pcoded-mtext">Laporan Masyarakat</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @if (hasAccess(Auth::user()->internal_role_id, "Pesan", "View"))
            <li class="{{(Request::segment(2) == 'pesan') ? 'active' : ''}}">
                <a href="{{ url('admin/pesan') }}">
                    <span class="pcoded-micon"><i class="ti-email"></i></span>
                    <span class="pcoded-mtext">Pesan</span>
                </a>
            </li>
            @endif
            @if (hasAccess(Auth::user()->internal_role_id, "Log", "View"))
            <li class="{{(Request::segment(2) == 'log') ? 'active' : ''}}">
                <a href="{{ url('admin/log') }}">
                    <span class="pcoded-micon"><i class="ti-email"></i></span>
                    <span class="pcoded-mtext">Log</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</nav>

<script>
    const uls = document.querySelectorAll('.pcoded-item');

    uls.forEach(function(ul) {
        ul.addEventListener('click', function() {
            this.classList.remove('pcoded-trigger');
        });
    });
</script>
