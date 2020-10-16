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
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
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
                    <iframe style="display:block; width: 100%; height: 60vh;" src="https://talikuat-bima-jabar.com/temanjabar/mob/dinas/progress.php" frameborder="0"></iframe>
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
                <table class="table table-responsive">
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
                        @foreach ($laporan as $data)
                        <tr>
                            <td>
                                <b>{{$data->nama}}</b> <br>
                                {{$data->nik}} <br>
                                {{$data->telp}} <br>
                                {{$data->email}} <br>
                            </td>
                            <td>{{$data->uptd_id}}</td>
                            <td>{{$data->jenis}}</td>
                            <td>
                                {{$data->lat}} <br>
                                {{$data->long}}
                            </td>
                            <td>
                                <img src="{!! $data->gambar !!}" class="img-fluid rounded" alt="" style="max-width: 224px;">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
