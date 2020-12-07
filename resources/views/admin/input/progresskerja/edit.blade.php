@extends('admin.t_index')

@section('title') Edit Progress Pekerjaan @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Edit Progress Pekerjaan</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('getDataProgress') }}">Progress Pekerjaan</a> </li>
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
                <h5>Edit Data Progress Pekerjaan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">

                <form action="{{ route('updateDataProgress',$progress->id) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{$progress->id}}">
                     <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kegiatan</label>
                        <div class="col-md-10">
                            <select class="form-control" name="kegiatan" required value="{{$progress->kegiatan}}">
                                @foreach ($jenis as $data)
                                <option value="{{$data->name}}" {{ ( $data->name == $progress->kegiatan) ? 'selected' : ''}}>{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Tanggal</label>
                        <div class="col-md-10">
                            <input name="tanggal" type="date" class="form-control" required value="{{$progress->tanggal}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama Paket</label>
                        <div class="col-md-10">
                            <select class="form-control" name="nama_paket" required value="{{$progress->nama_paket}}">
                                @foreach ($paket as $data)
                                <option value="{{$data}}" {{ ( $data == $progress->nama_paket) ? 'selected' : ''}}>{{$data}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Penyedia Jasa</label>
                       <div class="col-md-10">
                            <select class="form-control" name="penyedia_jasa" required value="{{$progress->penyedia_jasa}}">
                                @foreach ($penyedia as $data)
                                <option value="{{$data}}" {{ ( $data == $progress->penyedia_jasa) ? 'selected' : ''}}>{{$data}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Satuan Pelayanan Pengelolaan</label>
                       <div class="col-md-10">
                            <select class="form-control" name="sup" required value="{{$progress->sup}}">
                                @foreach ($sup as $data)
                                <option value="{{$data->name}}" {{ ( $data->name == $progress->sup) ? 'selected' : ''}}>{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="col-md-2 col-form-label">Ruas Jalan</label>
                       <div class="col-md-10">
                            <select class="form-control" name="ruas_jalan" required value="{{$progress->ruas_jalan}}">
                                @foreach ($ruas_jalan as $data)
                                <option value="{{$data->nama_ruas_jalan}}" {{ ( $data->nama_ruas_jalan == $progress->ruas_jalan) ? 'selected' : ''}}>{{$data->nama_ruas_jalan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Jenis Pekerjaan</label>
                        <div class="col-md-10">
                            <input name="jenis_pekerjaan" type="text" class="form-control" required value="{{$progress->jenis_pekerjaan}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Lokasi</label>
                        <div class="col-md-8">
                            <input name="lokasi" type="text" class="form-control" required value="{{$progress->lokasi}}">
                        </div>
                        <div class="col-md-2"> KM BDG</div>
                    </div>
                     <div class="form-group row">
                        <label class="col-md-2 col-form-label">Koordinat X</label>
                        <div class="col-md-10">
                            <input name="lat" type="text" class="form-control" required value="{{$progress->lat}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Koordinat Y</label>
                        <div class="col-md-10">
                            <input name="lng" type="text" class="form-control" required value="{{$progress->lng}}">
                        </div>
                    </div>

                    <hr>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Rencana</label>
                        <div class="col-md-6">
                            <input type="text" name="rencana" class="form-control" value="{{$progress->rencana}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Realisasi</label>
                        <div class="col-md-6">
                            <input type="text" name="realisasi" class="form-control" value="{{$progress->realisasi}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Waktu Kontrak</label>
                        <div class="col-md-6">
                            <input type="text" name="waktu_kontrak" class="form-control" value="{{$progress->waktu_kontrak}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Terpakai</label>
                        <div class="col-md-6">
                            <input type="text" name="terpakai" class="form-control" value="{{$progress->terpakai}}">
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="col-md-4 col-form-label">Nilai Kontrak</label>
                        <div class="col-md-6">
                            <input type="text" name="nilai_kontrak" class="form-control" value="{{$progress->nilai_kontrak}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Keuangan</label>
                        <div class="col-md-6">
                            <input type="text" name="bayar" class="form-control" value="{{$progress->bayar}}">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Foto Dokumentasi</label>
                        <div class="col-md-6">
                            <input name="foto" type="file" class="form-control" value="{{$progress->foto}}" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Video Dokumentasi</label>
                        <div class="col-md-6">
                            <input name="video" type="file" class="form-control"  value="{{$progress->video}}" accept="video/*">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-mat btn-success">Simpan Perubahan</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
