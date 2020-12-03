@extends('admin.t_index')

@section('title') Admin Dashboard @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Data Rawan Bencana</h4>
                <span>Seluruh Data Rawan Bencana di naungan DBMPR Jabar</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('getDataBencana') }}">Data Rawan Bencana</a> </li>
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
                <h5>Edit Data Rawan Bencana</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">

                <form action="{{ route('updateDataBencana',$rawan->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- <input type="hidden" name="uptd_id" value="{{$rawan->uptd_id}}"> -->
                    <input type="hidden" name="id" value="{{$rawan->id}}">

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">No Ruas</label>
                        <div class="col-md-10">
                            <input name="no_ruas" type="number" class="form-control" required value="{{$rawan->no_ruas}}">
                        </div>
                    </div>

                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Ruas Jalan</label>
                        <div class="col-md-10">
                            <select name="ruas_jalan" class="form-control" required value="{{$rawan->ruas_jalan}}">
                                @foreach ($ruas as $data)
                                <option value="{{$data->id}}">{{$data->nama_ruas_jalan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Lokasi</label>
                        <div class="col-md-10">
                            <input name="lokasi" type="text" class="form-control" required value="{{$rawan->lokasi}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Daerah</label>
                        <div class="col-md-10">
                            <input name="daerah" type="text" class="form-control" required value="{{$rawan->daerah}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Status</label>
                       <div class="col-md-10">
                            <select class="form-control" name="status">
                                <option value="P">P</option>
                                <option value="N">N</option>
                            </select>
                        </div>
                    </div>

                    @if (Auth::user()->internalRole->uptd)
                        <input type="hidden" name="uptd_id" value="{{$rawan->uptd_id}}">
                    @else
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Uptd</label>
                       <div class="col-md-10">
                            <select class="form-control" name="uptd_id">
                                @foreach ($uptd as $data)
                                <option value="{{$data->id}}">{{$data->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Keterangan</label>
                       <div class="col-md-10">
                            <textarea name="keterangan" rows="3" cols="3" class="form-control" placeholder="Masukkan Keterangan" required>{{$rawan->keterangan}}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-mat btn-success">Simpan Perubahan</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
