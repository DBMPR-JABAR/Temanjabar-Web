@php
    $jenis_laporan = DB::table('utils_jenis_laporan')->get();
    $lokasi = DB::table('utils_lokasi')->get();
@endphp
@extends('admin.t_index')

@section('title') Admin Dashboard @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Laporan Masyarakat</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('getLandingUPTD') }}">Laporan Masyarakat</a> </li>
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
                <h5>Laporan Masyarakat</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">

                <form action="{{ route('updateLandingLaporanMasyarakat') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$data->id}}">

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama</label>
                            <div class="col-md-10">
                                <input name="nama" type="text" class="form-control" value="{{$data->nama}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">NIK</label>
                            <div class="col-md-10">
                                <input name="nik" type="text" class="form-control" value="{{$data->nik}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Alamat</label>
                            <div class="col-md-10">
                                <input name="alamat" type="text" class="form-control" value="{{$data->alamat}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Telepon</label>
                            <div class="col-md-10">
                                <input name="telp" type="tel" class="form-control" value="{{$data->telp}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input name="email" type="email" class="form-control" value="{{$data->email}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Jenis</label>
                            <div class="col-md-10">
                                <select name="jenis" class="custom-select my-1 mr-sm-2 w-100" id="pilihanKeluhan" required>
                                    <option selected>Pilih...</option>
                                    @foreach ($jenis_laporan as $laporan)
                                    <option value="{{$laporan->id}}" {{($laporan->id == $data->jenis) ? 'selected' : ''}}>{{$laporan->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Gambar</label>
                            <div class="col-md-5">
                                <img src="{{ url('storage/'.$data->gambar) }}" class="img-thumbnail rounded mx-auto d-block" alt="">
                            </div>
                            <div class="col-md-5">
                                <input name="gambar" type="file" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">lokasi</label>
                            <div class="col-md-10">
                                <select name="lokasi" class="custom-select my-1 mr-sm-2 w-100" id="pilihanKeluhan" required>
                                    <option selected>Pilih...</option>
                                    @foreach ($lokasi as $kabkota)
                                    <option value="{{$kabkota->name}}" {{($kabkota->name == $data->lokasi) ? 'selected' : ''}}>{{$kabkota->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Lat</label>
                            <div class="col-md-10">
                                <input name="lat" type="text" class="form-control" value="{{$data->lat}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Long</label>
                            <div class="col-md-10">
                                <input name="long" type="text" class="form-control" value="{{$data->long}}" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Deskripsi</label>
                            <div class="col-md-10">
                                <textarea name="deskripsi" rows="3" cols="3" class="form-control" placeholder="Masukkan Deskripsi" required>{{$data->deskripsi}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                                    <label class="col-md-2 col-form-label">UPTD</label>
                                    <select name="uptd_id" class="custom-select my-1 mr-sm-2" id="pilihanUptd" required>
                                        <option >Pilih...</option>
                                        <option value="1"<?php if($data->uptd_id == 1) echo "selected";?>>UPTD-I</option>
                                        <option value="2" <?php if($data->uptd_id == 2) echo "selected";?>>UPTD-II</option>
                                        <option value="3" <?php if($data->uptd_id == 3) echo "selected";?>>UPTD-III</option>
                                        <option value="4" <?php if($data->uptd_id == 4) echo "selected";?>>UPTD-IV</option>
                                        <option value="5" <?php if($data->uptd_id == 5) echo "selected";?>>UPTD-V</option>
                                        <option value="6" <?php if($data->uptd_id == 6) echo "selected";?>>UPTD-VI</option>
                                    </select>
                        </div>


                    <a href="{{ route('getLapor') }}"><button type="button" class="btn btn-default waves-effect">Kembali</button></a>
                    <button type="submit" class="btn btn-mat btn-success">Simpan Perubahan</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
