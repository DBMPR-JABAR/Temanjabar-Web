@extends('admin.t_index')

@section('title') Edit Pekerjaan @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Edit Pekerjaan</h4>
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
                <h5>Edit Data Pekerjaan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">

                <form action="{{ route('updateDataPekerjaan',$pekerjaan->id_pek) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_pek" value="{{$pekerjaan->id_pek}}">



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
                                <option value="{{$data->name}}" {{ ( $data->name == $pekerjaan->nama_mandor) ? 'selected' : ''}}>{{$data->name}}</option>
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

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama Paket</label>
                        <div class="col-md-10">
                            <input name="paket" type="text" class="form-control" value="{{$pekerjaan->paket}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">SUP</label>
                        <div class="col-md-10">
                            <select class="form-control" name="sup" required value="{{$pekerjaan->sup}}">
                                @foreach ($sup as $data)
                                <option value="{{$data->name}}" {{ ( $data->name == $pekerjaan->sup) ? 'selected' : ''}}>{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Ruas Jalan</label>
                        <div class="col-md-10">
                            <select class="form-control" name="ruas_jalan" required value="{{$pekerjaan->ruas_jalan}}">
                                @foreach ($ruas_jalan as $data)
                                <option value="{{$data->nama_ruas_jalan}}" {{ ( $data->nama_ruas_jalan == $pekerjaan->ruas_jalan) ? 'selected' : ''}}>{{$data->nama_ruas_jalan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Lokasi</label>
                        <div class="col-md-10">
                            <input name="lokasi" type="text" class="form-control" required value="{{$pekerjaan->lokasi}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Koordinat X</label>
                        <div class="col-md-10">
                            <input name="lat" type="text" class="form-control formatLatLong" required value="{{$pekerjaan->lat}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Koordinat Y</label>
                        <div class="col-md-10">
                            <input name="lng" type="text" class="form-control formatLatLong" value="{{$pekerjaan->lng}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Panjang (meter)</label>
                        <div class="col-md-10">
                            <input name="panjang" type="text" class="form-control formatRibuan" required value="{{$pekerjaan->panjang}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Jumlah Pekerja</label>
                        <div class="col-md-10">
                            <input name="jumlah_pekerja" type="text" class="form-control formatRibuan" required value="{{$pekerjaan->jumlah_pekerja}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Alat yang Digunakan</label>
                        <div class="col-md-10">
                            <input name="peralatan" type="text" class="form-control" required value="{{$pekerjaan->peralatan}}">
                        </div>
                    </div>
                    @if (Auth::user()->internalRole->uptd)
                    <input type="hidden" name="uptd_id" value="{{Auth::user()->internalRole->uptd}}" value="{{$pekerjaan->uptd_id}}">
                    @else
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Uptd</label>
                        <div class="col-md-10">
                            <select class="form-control" name="uptd_id" value="{{$pekerjaan->uptd_id}}">
                                @foreach ($uptd as $data)
                                <option value="{{$data->id}}" {{ ( $data->id == $pekerjaan->uptd_id) ? 'selected' : ''}}>{{$data->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Foto Dokumentasi (0%)</label>
                        <div class="col-md-6">
                            <input name="foto_awal" type="file" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Foto Dokumentasi (50%)</label>
                        <div class="col-md-6">
                            <input name="foto_sedang" type="file" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Foto Dokumentasi (100%)</label>
                        <div class="col-md-6">
                            <input name="foto_akhir" type="file" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Video Dokumentasi</label>
                        <div class="col-md-6">
                            <input name="video" type="file" class="form-control" accept="video/*">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-mat btn-success">Simpan Perubahan</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function() {
        // Format mata uang.
        $('.formatRibuan').mask('000.000.000.000.000', {
            reverse: true
        });

        // Format untuk lat long.
        $('.formatLatLong').mask('00000.00000000', {
            reverse: true
        });
    });
</script>
@endsection