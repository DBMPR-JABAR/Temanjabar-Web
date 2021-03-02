@extends('admin.t_index')

@section('title') Pekerjaan @endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">

<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">

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
            <ul class="breadcrumb-title">
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
                <h5 id="tbltitle">Tabel Pekerjaan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                @if (hasAccess(Auth::user()->internal_role_id, "Pekerjaan", "Create"))
                <a data-toggle="modal" href="#addModal" class="btn btn-mat btn-primary mb-3">Tambah</a>
                @endif
                <div class="dt-responsive table-responsive">
                    <table id="dttable"  class="table table-striped table-bordered table-responsive">
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
                                <th>Peralatan</th>
                                <th>Jumlah Pekerja</th>
                                <th>Foto (0%)</th>
                                <th>Foto (50%)</th>
                                <th>Foto (100%)</th>
                                <th>Video</th>
                                <th>Tanggal</th>
                                <th>Status</th>

                                <th style="min-width: 190px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyJembatan">
                            @foreach ($pekerjaan as $data)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$data->id_pek}}</td>
                                <td>{{$data->nama_mandor}}</td>
                                <td>{{$data->sup}}</td>
                                <td>{{$data->ruas_jalan}}</td>
                                <td>{{$data->jenis_pekerjaan}}</td>
                                <td>{{$data->lokasi}}</td>
                                <td>{{$data->panjang}}</td>
                                <td>{{$data->peralatan}}</td>
                                <td>{{$data->jumlah_pekerja}}</td>
                                <td><img class="img-fluid" style="max-width: 100px" src="{!! url('storage/pekerjaan/'.$data->foto_awal) !!}" alt="" srcset=""></td>
                                <td><img class="img-fluid" style="max-width: 100px" src="{!! url('storage/pekerjaan/'.$data->foto_sedang) !!}" alt="" srcset=""></td>
                                <td><img class="img-fluid" style="max-width: 100px" src="{!! url('storage/pekerjaan/'.$data->foto_akhir) !!}" alt="" srcset=""></td>
                                <td><video width='150' height='100' controls>
                                        <source src="{!! url('storage/pekerjaan/'.$data->video) !!}" type='video/*' Sorry, your browser doesn't support the video element.></video></td>
                                <td>{{$data->tanggal}}</td>
                                <td>@if($data->status)
                                        @if(str_contains($data->status->status,'Approved') || str_contains($data->status->status,'Rejected')|| str_contains($data->status->status,'Edited') )
                                            @if(str_contains($data->status->status,'Approved') )
                                                <button type="button" class="btn btn-mini btn-primary " disabled> {{$data->status->status}}</button>
                                            @elseif(str_contains($data->status->status,'Rejected') )
                                                <button type="button" class="btn btn-mini btn-danger " disabled> {{$data->status->status}}</button>
                                            @else
                                                <button type="button" class="btn btn-mini btn-warning " disabled> {{$data->status->status}}</button>
                                            @endif
                                            <br>{{$data->status->jabatan}}<br>
                                            <a href="{{ route('detailStatusPekerjaan',$data->id_pek) }}"><button type="button" class="btn btn-sm waves-effect waves-light " ><i class="icofont icofont-search"></i> Detail</button>
                                        @else 
                                            @if($data->input_material)
                                                <button type="button" class="btn btn-mini btn-success waves-effect " >Submited</button>
                                            @endif
                                        @endif
                                    @else
                                        <a href="@if(str_contains(Auth::user()->internalRole->role,'Mandor')) {{ route('materialDataPekerjaan',$data->id_pek) }} @else # @endif">
                                            <button type="button" class="btn btn-mini btn-warning waves-effect " @if(!!str_contains(Auth::user()->internalRole->role,'Mandor')) disabled @endif>Not Completed</button>
                                        </a>
                                        <br>
                                        <i style="color :red; font-size: 10px;">Lengkapi material</i>
                                    @endif

                                </td>

                                <td style="min-width: 170px;">
                              
                                    <div class="btn-group" role="group" data-placement="top" title="" data-original-title=".btn-xlg">
                                        @if(Auth::user()->internalRole->role != null && str_contains(Auth::user()->internalRole->role,'Mandor')||str_contains(Auth::user()->internalRole->role,'Admin')||(str_contains(Auth::user()->internalRole->role,'Pengamat')&& $data->status != null && (str_contains($data->status->status,'Rejected')|| str_contains($data->status->status,'Edited'))) && !str_contains(Auth::user()->internalRole->role,'Kepala Satuan Unit Pemeliharaan'))
                                            @if(!$data->keterangan_status_lap || str_contains($data->status->status,'Rejected')|| (str_contains($data->status->status,'Edited')&&Auth::user()->id == $data->status->adjustment_user_id)||str_contains(Auth::user()->internalRole->role,'Admin'))
                                                @if (hasAccess(Auth::user()->internal_role_id, "Pekerjaan", "Update"))
                                                <a href="{{ route('editDataPekerjaan',$data->id_pek) }}"><button class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="tooltip" title="Edit"><i class="icofont icofont-pencil"></i></button></a>
                                                <a href="{{ route('materialDataPekerjaan',$data->id_pek) }}"><button class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="tooltip" title="Material"><i class="icofont icofont-list"></i></button></a>
                                                @endif
                                                @if(!$data->keterangan_status_lap ||str_contains(Auth::user()->internalRole->role,'Admin'))
                                                    @if (hasAccess(Auth::user()->internal_role_id, "Pekerjaan", "Delete"))
                                                    <a href="#delModal" data-id="{{$data->id_pek}}" data-toggle="modal"><button class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="tooltip" title="Hapus"><i class="icofont icofont-trash"></i></button></a>
                                                    @endif
                                                @endif
                                                {{-- @if (hasAccess(Auth::user()->internal_role_id, "Pekerjaan", "Update"))
                                                <a href="#submitModal" data-id="{{$data->id_pek}}" data-toggle="modal"><button class="btn btn-success btn-sm waves-effect waves-light" data-toggle="tooltip" title="Submit"><i class="icofont icofont-check-circled"></i></button></a>
                                                @endif --}}
                                            @endif
                                        @else
                                            @if($data->status)
                                                @if(Auth::user()->internal_role_id!=null && Auth::user()->internal_role_id ==$data->status->parent )
                                                    @if(str_contains(Auth::user()->internalRole->role,'Pengamat') || (str_contains(Auth::user()->internalRole->role,'Kepala Satuan Unit Pemeliharaan') && $data->status->status == "Approved" || $data->status->status =="Edited") && Auth::user()->sup_id==$data->status->sup_id)
                                                        <a href="{{ route('jugmentDataPekerjaan',$data->id_pek) }}"><button class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="tooltip" title="Edit"><i class="icofont icofont-pencil"></i>Jugment</button></a>
                                                    @elseif(!!str_contains(Auth::user()->internalRole->role,'Pengamat') || !!str_contains(Auth::user()->internalRole->role,'Kepala Satuan Unit Pemeliharaan') && $data->status->status == "Approved")
                                                        <a href="{{ route('jugmentDataPekerjaan',$data->id_pek) }}"><button class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="tooltip" title="Edit"><i class="icofont icofont-pencil"></i>Jugment</button></a>
                                                    @endif
                                                @endif
                                                @if(@$data->status->adjustment_user_id==Auth::user()->id)
                                                    <a href="{{ route('jugmentDataPekerjaan',$data->id_pek) }}"><button class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="tooltip" title="Edit"><i class="icofont icofont-pencil"></i>Edit Jugment</button></a>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
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
                            <label class="col-md-2 col-form-label">Mandor</label>
                            @if(Auth::user()->internalRole->role != null && str_contains(Auth::user()->internalRole->role,'Mandor'))
                                <div class="col-md-10">
                                <input  type="text" class="form-control" value="{{ Auth::user()->name}}" readonly>
                                </div>
                            @else
                                <div class="col-md-10">
                                    <select class="form-control searchableModalField" name="nama_mandor" required>
                                        @foreach ($mandor as $data)
                                        <option value="{{$data->name}},{{$data->id}}">{{$data->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Jenis Pekerjaan</label>
                            <div class="col-md-10">
                                <select class="form-control searchableModalField" name="jenis_pekerjaan" required>
                                    @foreach ($jenis as $data)
                                    <option value="{{$data->nama_item}}">{{$data->nama_item}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tanggal</label>
                            <div class="col-md-10">
                                <input name="tanggal" type="date" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Paket</label>
                            <div class="col-md-10">
                                <input name="paket" type="text" class="form-control">
                            </div>
                        </div>
                        @if (Auth::user()->internalRole->uptd)
                        <input type="hidden" id="uptd" name="uptd_id" value="{{Auth::user()->internalRole->uptd}}">
                        @else
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Uptd</label>
                            <div class="col-md-10">
                                <select class="form-control searchableModalField" id="uptd" name="uptd_id" onchange="ubahOption()">
                                    <option>Pilih UPTD</option>
                                    @foreach ($uptd as $data)
                                    <option value="{{$data->id}}">{{$data->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">SUP</label>
                            <div class="col-md-10">
                                <select class="form-control searchableModalField" id="sup" name="sup" required >
                                    @if (Auth::user()->internalRole->uptd)
                                    @foreach ($sup as $data)
                                    <option value="{{$data->name}},{{$data->id}}" @if(Auth::user()->sup_id != null && Auth::user()->sup_id == $data->id) selected @endif>{{$data->name}}</option>
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
                                <select class="form-control searchableModalField" id="ruas_jalan" name="ruas_jalan" required>
                                    @if (Auth::user()->internalRole->uptd)
                                    @foreach ($ruas_jalan as $data)
                                    <option value="{{$data->nama_ruas_jalan}},{{$data->id_ruas_jalan}}">{{$data->nama_ruas_jalan}}</option>
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
                                <input name="lokasi" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Koordinat X</label>
                            <div class="col-md-10">
                                <input name="lat" type="text" class="form-control formatLatLong" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Koordinat Y</label>
                            <div class="col-md-10">
                                <input name="lng" type="text" class="form-control formatLatLong" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Panjang (meter)</label>
                            <div class="col-md-10">
                                <input name="panjang" type="text" class="form-control formatRibuan" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Jumlah Pekerja</label>
                            <div class="col-md-10">
                                <input name="jumlah_pekerja" type="text" class="form-control formatRibuan" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Alat yang Digunakan</label>
                            <div class="col-md-10">
                                <input name="peralatan" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Foto Dokumentasi (0%)</label>
                            <div class="col-md-6">
                                <input name="foto_awal" type="file" class="form-control" accept="image/*" required>
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
                                <input name="video" type="file" class="form-control" accept="video/mp4">
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

            // $('#dttable').DataTable({
            //     processing: true,
            //     serverSide: true,
            //     ajax: {
            //         url: "{{ url('admin/input-data/pekerjaan/json') }}",
            //         data: function(d){
            //             d.year_from = getYearFilter().yearFrom;
            //             d.year_to = getYearFilter().yearTo;
            //         }
            //     },
                
            //     columns: [{
            //             'mRender': function(data, type, full, meta) {
            //                 console.log(full['intro']);
            //                 return +meta.row + meta.settings._iDisplayStart + 1;
            //             }
            //         },
            //         {
            //             data: 'nama_mandor',
            //             name: 'nama_mandor'
            //         },
            //         {
            //             data: 'sup',
            //             name: 'sup'
            //         },
            //         {
            //             data: 'ruas_jalan',
            //             name: 'ruas_jalan'
            //         },
            //         {
            //             data: 'jenis_pekerjaan',
            //             name: 'jenis_pekerjaan'
            //         },
            //         {
            //             data: 'lokasi',
            //             name: 'lokasi'
            //         },
            //         {
            //             data: 'panjang',
            //             name: 'panjang'
            //         },
            //         {
            //             data: 'peralatan',
            //             name: 'peralatan'
            //         },
            //         {
            //             data: 'jumlah_pekerja',
            //             name: 'jumlah_pekerja'
            //         },
            //         {
            //             'mRender': function(data, type, full) {
            //                 return '<img class="img-fluid" style="max-width: 100px" src="'+`{!! url('storage/pekerjaan/') !!}`+'/'+ full['foto_awal'] + '" alt="" srcset="">';
            //             }
            //         },
            //         {
            //             'mRender': function(data, type, full) {
            //                 return '<img class="img-fluid" style="max-width: 100px" src="'+`{!! url('storage/pekerjaan/') !!}`+'/'+ full['foto_sedang'] + '" alt="" srcset="">';
            //             }
            //         },
            //         {
            //             'mRender': function(data, type, full) {
            //                 return '<img class="img-fluid" style="max-width: 100px" src="'+`{!! url('storage/pekerjaan/') !!}`+'/'+ full['foto_akhir'] + '" alt="" srcset="">';
            //             }
            //         },
            //         {
            //             'mRender': function(data, type, full) {
            //                 return `<video width='150' height='100' controls><source src="{!! url('storage/pekerjaan/') !!}`+'/' + full['video'] + `" type="video/mp4" /></video>`
            //             }
            //         },
            //         {
            //             data: 'tanggal',
            //             name: 'tanggal'
            //         },
            //         {
            //             data: 'action',
            //             name: 'action',
            //             orderable: false,
            //             searchable: false
            //         },
            //     ]
            // });
            // $("#tbltitle").html(`Data Pekerjaan dari Tahun ${getYearFilter().yearFrom} hingga Tahun ${getYearFilter().yearTo}`);


            $('#yearFrom, #yearTo').change(function () {
                // $("#tbltitle").html(`Data Pekerjaan dari Tahun ${getYearFilter().yearFrom} hingga Tahun ${getYearFilter().yearTo}`);
                $('#dttable').DataTable().ajax.reload(null, false);
            })

        });

        function ubahOption() {

            //untuk select SUP
            id = document.getElementById("uptd").value
            url = "{{ url('admin/master-data/ruas-jalan/getSUP') }}"
            id_select = '#sup'
            text = 'Pilih SUP'
            option = 'name'

            setDataSelect(id, url, id_select, text, option, option)

            //untuk select Ruas
            url = "{{ url('admin/input-data/kondisi-jalan/getRuasJalan') }}"
            id_select = '#ruas_jalan'
            text = 'Pilih Ruas Jalan'
            option = 'nama_ruas_jalan'

            setDataSelect(id, url, id_select, text, option, option)
        }
    </script>
    @endsection
