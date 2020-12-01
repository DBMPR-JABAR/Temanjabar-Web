<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Dashboard Analysis</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu pcoded-trigger">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-bar-chart"></i></span>
                    <span class="pcoded-mtext">Monitoring</span>
                </a>
                <ul class="pcoded-submenu">
                <li class=" ">
                        <a href="{{ url('admin/map-dashboard') }}">
                            <span class="pcoded-mtext">Executive Dashboard</span>
                        </a>

                    </li>
                 <li class="">
                        <a href="{{ url('admin/monitoring/progress-pekerjaan') }}">
                            <span class="pcoded-mtext">Map Progress Pekerjaan</span>
                        </a>
                    </li> 
                    <li class=" ">
                        <a href="{{ url('admin/monitoring/proyek-kontrak') }}">
                            <span class="pcoded-mtext">Proyek Kontrak</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="{{ url('admin/monitoring/laporan-kerusakan') }}">
                            <span class="pcoded-mtext">Laporan Kerusakan</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="{{ url('admin/monitoring/survey-kondisi-jalan') }}">
                            <span class="pcoded-mtext">Survey Kondisi Jalan</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="{{ url('admin/monitoring/realisasi-keuangan') }}">
                            <span class="pcoded-mtext">Anggaran & Realisasi Keuangan</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="{{ url('admin/monitoring/kemantapan-jalan') }}">
                            <span class="pcoded-mtext">Kemantapan Jalan</span>
                        </a>
                    </li>
                    {{-- <li class="">
                        <a href="{{ url('admin/monitoring/audit-keuangan') }}">
                            <span class="pcoded-mtext">Audit Keuangan (Pending)</span>
                        </a>
                    </li> --}}
                </ul>
            </li>
            {{-- <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-stats-up"></i></span>
                    <span class="pcoded-mtext">Rekomendasi</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="{{ url('admin/rekomendasi/rekomendasi-kontraktor') }}">
                            <span class="pcoded-mtext">Kontraktor Terbaik</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="{{ url('admin/rekomendasi/rekomendasi-konsultan') }}">
                            <span class="pcoded-mtext">Konsultan Terbaik</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="{{ url('admin/rekomendasi/rekomendasi-perbaikan') }}">
                            <span class="pcoded-mtext">Perbaikan Infrastruktur</span>
                        </a>
                    </li>
                </ul>
            </li>  --}}
        </ul>
        {{-- <div class="pcoded-navigatio-lavel">Data Utama</div>
        <ul class="pcoded-item pcoded-left-item pcoded-trigger">
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-package"></i></span>
                    <span class="pcoded-mtext">Data Utama</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="">
                            <span class="pcoded-mtext">Kontraktor</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="">
                            <span class="pcoded-mtext">Konsultan</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="">
                            <span class="pcoded-mtext">PPK</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="">
                            <span class="pcoded-mtext">Jenis Pekerjaan</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="">
                            <span class="pcoded-mtext">Pengguna</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-edit-1"></i></span>
                    <span class="pcoded-mtext">Input Data</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="">
                            <span class="pcoded-mtext">Data Umum</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="">
                            <span class="pcoded-mtext">Jadwal Pekerjaan</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="">
                            <span class="pcoded-mtext">Permintaan</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="">
                            <span class="pcoded-mtext">Laporan Harian</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-download-cloud"></i></span>
                    <span class="pcoded-mtext">Pusat Unduhan</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="">
                            <span class="pcoded-mtext">Data Kontrak</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="pcoded-navigatio-lavel">Cetak Laporan</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-pulse"></i></span>
                    <span class="pcoded-mtext">Progress</span>
                </a>
            </li>
            <li class="">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-blackboard"></i></span>
                    <span class="pcoded-mtext">Laporan Pekerjaan</span>
                </a>
            </li>
        </ul> --}}
        <div class="pcoded-navigatio-lavel">Landing Page</div>
        <ul class="pcoded-item pcoded-left-item pcoded-trigger">
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-home"></i></span>
                    <span class="pcoded-mtext">Landing Page</span>
                </a>
                <ul class="pcoded-submenu">
                    @if (!Auth::user()->internalRole->uptd)
                    <li class=" ">
                        <a href="{{ url('admin/landing-page/profil') }}">
                            <span class="pcoded-mtext">Profil</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="{{ url('admin/landing-page/slideshow') }}">
                            <span class="pcoded-mtext">Slideshow</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="{{ url('admin/landing-page/fitur') }}">
                            <span class="pcoded-mtext">Fitur</span>
                        </a>
                    </li>
                    @endif
                    <li class=" ">
                        <a href="{{ url('admin/landing-page/uptd') }}">
                            <span class="pcoded-mtext">UPTD</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="{{ url('admin/landing-page/pesan') }}">
                    <span class="pcoded-micon"><i class="ti-email"></i></span>
                    <span class="pcoded-mtext">Pesan</span>
                </a>
            </li>
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
