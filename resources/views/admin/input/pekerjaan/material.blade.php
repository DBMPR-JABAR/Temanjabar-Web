@extends('admin.t_index')

@section('title') Bahan Material @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Bahan Material</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('getDataPekerjaan') }}">Data Pekerjaan</a> </li>
                <li class="breadcrumb-item"><a href="#">Material</a> </li>
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
                <h5>Bahan Material</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">

                 @if ($material!='')
                <form action="{{ route('updateDataMaterialPekerjaan',$pekerjaan->id_pek) }}" method="post" enctype="multipart/form-data">
                @else
                <form action="{{ route('createDataMaterialPekerjaan',$pekerjaan->id_pek) }}" method="post" enctype="multipart/form-data">
                @endif
                    @csrf
                     <input type="hidden" name="id_pek" value="{{$pekerjaan->id_pek}}">

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">No Pekerjaan</label>
                        <div class="col-md-10">
                            <input name="id_pek" type="text" class="form-control" value="{{$pekerjaan->id_pek}}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Tanggal</label>
                        <div class="col-md-10">
                            <input name="tanggal" type="date" class="form-control" required value="{{$pekerjaan->tanggal}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Mandor</label>
                        <div class="col-md-10">
                            <select class="form-control" name="nama_mandor" required>
                                @foreach ($mandor as $data)
                                <option value="{{$data->name}}" {{ ( $data->name == $pekerjaan->nama_mandor) ? 'selected' : ''}} >{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Jenis Pekerjaan</label>
                        <div class="col-md-10">
                           <select class="form-control" name="jenis_pekerjaan" required value="{{$pekerjaan->jenis_pekerjaan}}">
                                @foreach ($jenis as $data)
                                <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $pekerjaan->jenis_pekerjaan) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if (Auth::user()->internalRole->uptd)
                        <input type="hidden" name="uptd_id" value="{{Auth::user()->internalRole->uptd}}">
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
                        <label class="col-md-2 col-form-label">Bahan Material 1</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan1" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan1) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan1" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan1 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan1" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan1) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 2</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan2" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan2) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan2" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan2 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan2" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan2) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 3</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan3" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan3) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan3" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan3 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan3" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan3) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 4</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan4" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan4) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan4" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan4 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan4" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan4) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 5</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan5" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan5) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan5" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan5 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan5" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan5) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 6</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan6" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan6) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan6" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan6 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan6" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan6) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 7</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan7" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan7) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan7" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan7 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan7" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan7) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 8</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan8" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan8) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan8" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan8 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan8" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan8) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 9</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan9" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan9) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan9" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan9 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan9" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan9) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 10</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan10" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan10) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan10" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan10 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan10" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan10) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 11</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan11" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan11) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan11" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan11 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan11" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan11) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 12</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan12" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan12) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan12" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan12 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan12" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan12) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 13</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan13" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan13) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan13" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan13 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan13" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan13) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 14</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan14" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan14) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan14" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan14 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan14" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan14) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Bahan Material 15</label>
                        <div class="col-md-3">
                            <select class="form-control" name="nama_bahan15" required>
                                @if ($material!='')
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}" {{ ( $data->nama_item == $material->nama_bahan15) ? 'selected' : ''}}>{{$data->nama_item}}</option>
                                    @endforeach
                                 @else
                                    @foreach ($bahan as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">Jumlah</label>
                        <div class="col-md-2">
                           
                            <input name="jum_bahan15" type="text" class="form-control" value="{{ ( $material!='') ? $material->jum_bahan15 : ''}}">
                        </div>
                        <label class="col-md-1 col-form-label">Satuan</label>
                        <div class="col-md-3">
                           <select class="form-control" name="satuan15" required>
                            @if ($material!='')
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}" {{ ( $data->satuan == $material->satuan15) ? 'selected' : ''}}>{{$data->satuan}}</option>
                                @endforeach
                            @else
                                @foreach ($satuan as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-mat btn-success">Simpan Perubahan</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection