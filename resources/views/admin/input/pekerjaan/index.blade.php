@extends('admin.layout.index')

@section('title') Pekerjaan @endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">

<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">
<link rel="stylesheet" href="https://js.arcgis.com/4.18/esri/themes/light/main.css">

<style>
    table.table-bordered tbody td {
        word-break: break-word;
        vertical-align: top;
    }
</style>
@endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Pekerjaan
                    @if(Auth::user()->internalRole->role != null && str_contains(Auth::user()->internalRole->role,'Mandor'))
                    {{ Str::title(Auth::user()->name) }}
                    @endif

                </h4>
                <span>Data Pekerjaan</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class=" breadcrumb breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Pekerjaan</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
<div class="row">
    {{-- <div class="col-lg-12">
        <div class="card">
            <div class="card-block accordion-block">
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="accordion-panel">
                        <div class="accordion-heading" role="tab" id="headingOne">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Filter
                                </a>
                            </h3>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne">
                            <div class="accordion-content accordion-desc">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-sm-12 col-xl-3 m-b-30">
                                            <h4 class="sub-title">Dari Tahun</h4>
                                            <select id="yearFrom" name="tahun" class="form-control form-control-primary">
                                                <option value="2019" selected>2019</option>
                                                @for ($i = 2020; $i <= date("Y"); $i++)
                                                <option value="{{$i}}" {{($i == date("Y")) ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-sm-12 col-xl-3 m-b-30">
                                            <h4 class="sub-title">Ke Tahun</h4>
                                            <select id="yearTo" name="tahun" class="form-control form-control-primary">
                                                <option value="2019">2019</option>
                                                @for ($i = 2020; $i <= date("Y"); $i++)
                                                <option value="{{$i}}" {{($i == date("Y")) ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Rekap Pekerjaan Mandor</h4>
                {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        {{-- {{-- <li><i class="feather icon-maximize full-card"></i></li> --}}
                        <li><i class="feather icon-minus minimize-card"></i></li> --}}
                    </ul>
                </div>
            </div>
            <div class="card-block">

                <div class="card-deck col-md-12">
                    <div class="card w-100">
                        {{-- <a href="{{ url('admin/lapor') }}"> --}}
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-warning f-w-600">
                                        {{ $sum_report['not_complete'] }}
                                    </h4>
                                    {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-arrow-down f-28"></i>
                                </div>
                            </div>
                        </div>
                        {{-- </a> --}}
                        <div class="card-footer bg-warning">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">Not Completed</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card w-100">
                        {{-- <a href="{{ url('admin/lapor') }}"> --}}
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-success f-w-600">
                                        {{ $sum_report['submit'] }}
                                    </h4>
                                    {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-arrow-down f-28"></i>
                                </div>
                            </div>
                        </div>
                        {{-- </a> --}}
                        <div class="card-footer bg-success">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">Submitted</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card w-100">
                        {{-- <a href="{{ url('admin/lapor') }}"> --}}
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-primary f-w-600">
                                        {{ $sum_report['approve'] }}
                                    </h4>
                                    {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-arrow-up f-28"></i>
                                </div>
                            </div>
                        </div>
                        {{-- </a> --}}
                        <div class="card-footer bg-primary">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">Approved</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card w-100">
                        {{-- <a href="{{ url('admin/lapor') }}"> --}}
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-danger f-w-600">
                                        {{ $sum_report['reject'] }}

                                    </h4>
                                    {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-clock f-28"></i>
                                </div>
                            </div>
                        </div>
                        {{-- </a> --}}
                        <div class="card-footer bg-danger">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">Rejected</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-deck col-md-12 mt-3">
                    <div class="card w-100">
                        {{-- <a href="{{ url('admin/lapor') }}"> --}}
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class=" f-w-600">
                                        {{ array_sum($sum_report) }}
                                    </h4>
                                    {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                                </div>
                                <div class="col-4 text-right">
                                    {{-- <i class="feather-archive"></i> --}}
                                    <i class="feather icon-clipboard f-28"></i>
                                </div>
                            </div>
                        </div>
                        {{-- </a> --}}
                        <div class="card-footer bg-default">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class=" m-b-0" style="color: black">Total Laporan</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 id="tbltitle">Tabel Pekerjaan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        {{-- <li><i class="feather icon-maximize full-card"></i></li> --}}
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                @if (hasAccess(Auth::user()->internal_role_id, "Pekerjaan", "Create"))
                <a data-toggle="modal" href="#addModal" class="btn btn-mat btn-primary mb-3">Tambah</a>
                @endif
                @if (!str_contains(Auth::user()->internalRole->role,'Mandor'))
                    <a href="{{ route('LaporanPekerjaan') }}" class="btn btn-mat btn-success mb-3">Cetak Laporan</a>
                @endif
                <div class="dt-responsive table-responsive">
                    <table  class="table table-striped table-bordered able-responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Laporan</th>
                                <th>Nama Mandor</th>
                                <th>SUP</th>
                                <th>Ruas Jalan</th>
                                <th>Jenis Pekerjaan</th>
                                <th>Lokasi</th>
                                <th>Panjang (meter)</th>
                                <th>Perkiraan Kuantitas</th>
                                {{-- <th>Foto (0%)</th>
                                <th>Foto (50%)</th>
                                <th>Foto (100%)</th>
                                <th>Video</th> --}}
                                <th>Tanggal</th>
                                <th>Status</th>

                                <th style="min-width: 190px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyJembatan">
                            @php
                                $nomber =0;
                            @endphp
                            @foreach ($pekerjaan as $no => $data)
                                @if(Auth::user() && Auth::user()->internalRole->uptd && Auth::user()->sup_id && count(Auth::user()->ruas)>0)
                                    @if(in_array($data->ruas_jalan_id,array_column( Auth::user()->ruas->toArray(), 'id_ruas_jalan')))
                                    @include('admin.input.pekerjaan.alldata')
                                    @php
                                    ++$nomber;
                                    @endphp
                                    @endif
                                @else
                                    @include('admin.input.pekerjaan.alldata')
                                    @php
                                    ++$nomber;
                                    @endphp
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-only">
    <div class="modal fade searchableModalContainer" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <form action="{{route('createDataPekerjaan')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Pekerjaan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- <input name="uptd_id" type="hidden" class="form-control" required value="{{Auth::user()->internalRole->uptd}}"> -->
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Sub Kegiatan</label>
                            <div class="col-md-10">
                                <input name="sub_kegiatan" type="text" value="" placeholder="Entry Sub Kegiatan" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Mandor </label>
                            @if(Auth::user()->internalRole->role != null && str_contains(Auth::user()->internalRole->role,'Mandor'))
                                <div class="col-md-10">
                                <input  type="text" class="form-control" value="{{ Auth::user()->name}}" readonly>
                                </div>
                            @else
                                <div class="col-md-10">
                                    <select class=" searchableModalField" name="nama_mandor" required>
                                        @foreach ($mandor as $data)
                                            @if(str_contains(Auth::user()->internalRole->role,'Admin') && Auth::user()->internalRole->uptd)
                                                @if( Auth::user()->internalRole->uptd == $data->internalRole->uptd)
                                                <option value="{{$data->name}},{{$data->id}}">{{$data->name}}</option>
                                                @endif
                                            @else
                                                <option value="{{$data->name}},{{$data->id}}">{{$data->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Jenis Pekerjaan</label>
                            <div class="col-md-10">
                                <select class="searchableModalField" name="jenis_pekerjaan" required>
                                    @foreach ($jenis_laporan_pekerjaan as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach


                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tanggal</label>
                            <div class="col-md-10">
                                <input name="tanggal" type="date" value="{{ date('Y-m-d') }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Jenis Kegiatan</label>
                            <div class="col-md-10">
                                <select class=" searchableModalField" id="paket" name="paket">
                                    @foreach ($nama_kegiatan_pekerjaan as $data)
                                    <option value="{{$data->name}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if (Auth::user()->internalRole->uptd)
                        <input type="hidden" id="uptd" name="uptd_id" value="{{Auth::user()->internalRole->uptd}}">
                        @else
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Uptd</label>
                            <div class="col-md-10">
                                <select class=" searchableModalField" id="uptd" name="uptd_id" onchange="ubahOption()" required>
                                    <option>Pilih UPTD</option>
                                    @foreach ($input_uptd_lists as $data)
                                    <option value="{{$data->id}}">{{$data->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">SUP</label>
                            <div class="col-md-10">
                                <select class=" searchableModalField" id="sup" name="sup" onchange="ubahOption1()" required >
                                    @if (Auth::user()->internalRole->uptd)
                                    @foreach ($sup as $data)
                                    <option value="{{$data->kd_sup}}" @if(Auth::user()->sup_id != null && Auth::user()->sup_id == $data->id) selected @endif>{{$data->name}}</option>
                                    @endforeach
                                    @else
                                    <option>-</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Ruas Jalan</label>
                            <div class="col-md-10">
                                <select class=" searchableModalField" id="ruas_jalan" name="ruas_jalan" required>
                                    @if (Auth::user()->internalRole->uptd)
                                        @foreach ($input_ruas_jalan as $data)
                                            <option value="{{$data->id_ruas_jalan}}">{{$data->nama_ruas_jalan}}</option>
                                        @endforeach
                                    @else
                                        <option>-</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Lokasi</label>
                            <div class="col-md-10">
                                <input name="lokasi" type="text" class="form-control" required placeholder="KM Bdg 100+0 s.d 120+900">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Koordinat X</label>
                            <div class="col-md-10">
                                <input id="lat" name="lat" type="text" class="form-control formatLatLong" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Koordinat Y</label>
                            <div class="col-md-10">
                                <input id="long" name="lng" type="text" class="form-control formatLatLong" required>
                            </div>
                        </div>


                        <div id="mapLatLong" class="full-map mb-2" style="height: 300px; width: 100%"></div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Panjang (meter)</label>
                            <div class="col-md-10">
                                <input name="panjang" type="number" class="form-control formatRibuan" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Perkiraan Kuantitas</label>
                            <div class="col-md-10">
                                <input name="perkiraan_kuantitas" type="number" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Foto Dokumentasi (Sebelum)</label>
                            <div class="col-md-6">
                                <input name="foto_awal" type="file" class="form-control" accept="image/*" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Foto Dokumentasi (Sedang)</label>
                            <div class="col-md-6">
                                <input name="foto_sedang" type="file" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Foto Dokumentasi (Setelah)</label>
                            <div class="col-md-6">
                                <input name="foto_akhir" type="file" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Foto Dokumentasi (Pegawai)</label>
                            <div class="col-md-6">
                                <input name="foto_pegawai" type="file" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Video Dokumentasi</label>
                            <div class="col-md-6">
                                <input name="video" type="file" class="form-control" accept="video/mp4">
                                <label for="video">Maksimum ukuran file 1024 Mb</label>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal-only">

    <div class="modal fade" id="delModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Hapus Data Pekerjaan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data ini?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
                    <a id="delHref" href="" class="btn btn-danger waves-effect waves-light ">Hapus</a>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="modal-only">
    <div class="modal fade" id="submitModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Submit Data Material</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Apakah anda yakin melakukan submit data ini?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
                    <a id="submitHref" href="" class="btn btn-danger waves-effect waves-light ">Submit</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <!-- <script src="{{ asset('assets/vendor/jquery/js/jquery-3.4.1.min.js') }}" ></script> -->
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery/js/jquery.mask.js') }}"></script>
    <script src="https://js.arcgis.com/4.18/"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

   <script>
        $(document).ready(function() {
            // Format mata uang.
            $('.formatRibuan').mask('000.000.000.000.000', {
                reverse: true
            });

            // Format untuk lat long.
            $('.formatLatLong').keypress(function(evt) {
                return (/^\-?[0-9]*\.?[0-9]*$/).test($(this).val() + evt.key);
            });

            $("#dttable").DataTable();
            $('#delModal').on('show.bs.modal', function(event) {
                const link = $(event.relatedTarget);
                const id = link.data('id');
                console.log(id);
                const url = `{{ url('admin/input-data/pekerjaan/delete') }}/` + id;
                console.log(url);
                const modal = $(this);
                modal.find('.modal-footer #delHref').attr('href', url);
            });
            $('#submitModal').on('show.bs.modal', function(event) {
                const link = $(event.relatedTarget);
                const id = link.data('id');
                console.log(id);
                const url = `{{ url('admin/input-data/pekerjaan/submit') }}/` + id;
                console.log(url);
                const modal = $(this);
                modal.find('.modal-footer #submitHref').attr('href', url);
            });
            // $('select').attr('value').trigger('change');

            function getYearFilter() {
                return {
                    yearFrom : $("#yearFrom").val(),
                    yearTo : $("#yearTo").val()
                };
            }


            $('#yearFrom, #yearTo').change(function () {
                // $("#tbltitle").html(`Data Pekerjaan dari Tahun ${getYearFilter().yearFrom} hingga Tahun ${getYearFilter().yearTo}`);
                $('#dttable').DataTable().ajax.reload(null, false);
            })


            $('#mapLatLong').ready(() => {
            require([
            "esri/Map",
            "esri/views/MapView",
            "esri/Graphic"
            ], function(Map, MapView, Graphic) {

                const map = new Map({
                    basemap: "osm"
                });

                const view = new MapView({
                    container: "mapLatLong",
                    map: map,
                    center: [107.6191, -6.9175],
                    zoom: 8,
                });

                let tempGraphic;
                view.on("click", function(event){
                    if($("#lat").val() != '' && $("#long").val() != ''){
                        view.graphics.remove(tempGraphic);
                    }
                    var graphic = new Graphic({
                        geometry: event.mapPoint,
                        symbol: {
                            type: "picture-marker", // autocasts as new SimpleMarkerSymbol()
                            url: "http://esri.github.io/quickstart-map-js/images/blue-pin.png",
                            width: "14px",
                            height: "24px"
                        }
                    });
                    tempGraphic = graphic;
                    $("#lat").val(event.mapPoint.latitude);
                    $("#long").val(event.mapPoint.longitude);

                    view.graphics.add(graphic);
                });
                $("#lat, #long").keyup(function () {
                    if($("#lat").val() != '' && $("#long").val() != ''){
                        view.graphics.remove(tempGraphic);
                    }
                    var graphic = new Graphic({
                        geometry: {
                            type: "point",
                            longitude: $("#long").val(),
                            latitude: $("#lat").val()
                        },
                        symbol: {
                            type: "picture-marker", // autocasts as new SimpleMarkerSymbol()
                            url: "http://esri.github.io/quickstart-map-js/images/blue-pin.png",
                            width: "14px",
                            height: "24px"
                        }
                    });
                    tempGraphic = graphic;

                    view.graphics.add(graphic);
                });
            });
        });
        });

    // });

        // });

        function ubahOption() {

            //untuk select SUP
            id = document.getElementById("uptd").value
            url = "{{ url('admin/master-data/ruas-jalan/getSUP') }}"
            id_select = '#sup'
            text = 'Pilih SUP'
            option = 'name'
            id_supp = 'kd_sup'

            setDataSelect(id, url, id_select, text, id_supp, option)

            //untuk select Ruas
            url = "{{ url('admin/input-data/kondisi-jalan/getRuasJalan') }}"
            id_select = '#ruas_jalan'
            text = 'Pilih Ruas Jalan'
            option = 'nama_ruas_jalan'
            id_ruass = 'id_ruas_jalan'

            setDataSelect(id, url, id_select, text, id_ruass, option)
        }
        function ubahOption1() {

            //untuk select SUP
            id = document.getElementById("sup").value

            //untuk select Ruas
            url = "{{ url('admin/input-data/kondisi-jalan/getRuasJalanBySup') }}"
            id_select = '#ruas_jalan'
            text = 'Pilih Ruas Jalan'
            option = 'nama_ruas_jalan'
            id_ruass = 'id_ruas_jalan'

            setDataSelect(id, url, id_select, text, id_ruass, option)
        }
    </script>
@endsection
