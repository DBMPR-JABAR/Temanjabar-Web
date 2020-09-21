@extends('admin.t_index')

@section('title') Laporan Kerusakan @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Laporan Kerusakan</h4>
                <span>Dashboard Pemetaan Kerusakan Infrastruktur Berdasarkan Laporan Masyarakat</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index.html"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Laporan Kerusakan</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Pemetaan Kerusakan Infrastruktur</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div class="mapping">
                    <iframe style="display:block; width: 100%; height: 60vh;" src="http://talikuat-bima-jabar.com/temanjabar/mob/dinas/progress.php" frameborder="0"></iframe>
                </div>

            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Tabel Laporan Masyarakat</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pelapor</th>
                            <th>UPTD</th>
                            <th>Kategori Laporan</th>
                            <th>Lokasi</th>
                            <th>Foto Kondisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <b>Tatan Vincent</b> <br>
                                3273002009001122 <br>
                                +6282210103030 <br>
                                vincent@mail.com <br>
                            </td>
                            <td>UPTD-I</td>
                            <td>Jalan Berlubang</td>
                            <td>
                                -6.002123210 <br>
                                95.002123210
                            </td>
                            <td>
                                <img src="https://images.hukumonline.com/frontend/lt5a954764bab1a/lt5a954d70cd9dd.jpg" class="img-fluid rounded" alt="" style="max-width: 224px;">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>John Lucas</b> <br>
                                3273002009001122 <br>
                                +6282210103030 <br>
                                john@mail.com <br>
                            </td>
                            <td>UPTD-II</td>
                            <td>Kepuasan Masyarakat</td>
                            <td>
                                -7.002123210 <br>
                                92.002123210
                            </td>
                            <td>
                                <img src="https://www.niaga.asia/wp-content/uploads/2019/10/jalan.jpg" class="img-fluid rounded" alt="" style="max-width: 224px;">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Sumanto</b> <br>
                                3273002009001122 <br>
                                +6282210103030 <br>
                                mantosu@mail.com <br>
                            </td>
                            <td>UPTD-VI</td>
                            <td>Jembatan Rusak</td>
                            <td>
                                -11.002123210 <br>
                                141.002123210
                            </td>
                            <td>
                                <img src="https://cdn-radar.jawapos.com/thumbs/l/radarmadura/news/2019/02/13/setahun-lebih-jembatan-rusak-di-pamekasan-tidak-diperbaiki_m_119293.jpg" class="img-fluid rounded" alt="" style="max-width: 224px;">
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
