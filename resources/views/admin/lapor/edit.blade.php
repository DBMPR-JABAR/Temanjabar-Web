@extends('admin.t_index')

@section('title') Data Laporan @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Data Laporan</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('getLapor') }}">Laporan</a> </li>
                <li class="breadcrumb-item"><a href="#">Edit</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Data Laporan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <form action="{{ route('updateLapor') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{$aduan->id}}">

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama Lengkap</label>
                        <div class="col-md-10">
                            <input name="nama" type="text" class="form-control" required value="{{$aduan->nama}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Tanggal</label>
                        <div class="col-md-10">
                            <input name="tanggal" type="date" class="form-control" required value="{{$aduan->tanggal}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">No. KTP</label>
                        <div class="col-md-10">
                            <input name="nik" type="text" class="form-control" required value="{{$aduan->nik}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Alamat</label>
                        <div class="col-md-10">
                            <input name="alamat" type="text" class="form-control" required value="{{$aduan->alamat}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Telp</label>
                        <div class="col-md-10">
                            <input name="telp" type="text" class="form-control" required value="{{$aduan->telp}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">E-mail</label>
                        <div class="col-md-10">
                            <input name="email" type="email" class="form-control" required value="{{$aduan->email}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Ruas Jalan</label>
                        <div class="col-md-10">
                            <select name="ruas_jalan" class="form-control" required>
                                <!-- <option>Pilih Ruas Jalan</option> -->
                                @foreach ($ruasJalan as $data)
                                @if($data->nama_ruas_jalan == $aduan->ruas_jalan)
                                <option value="{{$data->nama_ruas_jalan}}" selected>{{$data->nama_ruas_jalan}}</option>
                                @else
                                <option value="{{$data->nama_ruas_jalan}}">{{$data->nama_ruas_jalan}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Koordinat X</label>
                        <div class="col-md-10">
                            <input name="lat" type="text" class="form-control" required value="{{$aduan->lat}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Koordinat Y</label>
                        <div class="col-md-10">
                            <input name="lng" type="text" class="form-control" required value="{{$aduan->lng}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Permasalahan</label>
                        <div class="col-md-10">
                            <input name="permasalahan" type="text" class="form-control" required value="{{$aduan->permasalahan}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Foto</label>
                        <div class="col-md-6">
                            <input name="foto_awal" type="file" class="form-control" value="{{$aduan->foto_awal}}">
                        </div>
                    </div>

                    @if(Auth::user()->internalRole->uptd)
                    <input type="hidden" name="uptd_id" value="{{str_replace('uptd','',Auth::user()->internalRole->uptd)}}">
                    @else
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">UPTD</label>
                        <div class="col-md-10">
                            <select class="form-control" required name="uptd_id">
                                <!-- <option value="">Pilih UPTD</option> -->
                                @foreach ($uptd as $data)
                                @if($data->id == $aduan->uptd_id)
                                <option value="{{$data->id}}" selected>{{$data->nama}}</option>
                                @else
                                <option value="{{$data->id}}">{{$data->nama}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Status</label>
                        <div class="col-md-10">
                            <input name="status" type="text" class="form-control" disabled required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-mat btn-success">Simpan Perubahan</button>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection