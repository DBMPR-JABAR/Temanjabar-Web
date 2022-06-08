@extends('admin.layout.index')

@section('title') Ruas Jalan @endsection
@section('head')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/datatables.net/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/datatables.net/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">

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
                    <h4>Ruas Jalan</h4>
                    <span>Data Seluruh Ruas Jalan</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class=" breadcrumb breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Ruas Jalan</a> </li>
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
                    <h4>Filter</h4>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            {{-- <li><i class="feather icon-maximize full-card"></i></li> --}}
                            <li><i class="feather icon-minus minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="card-block w-100">
                        <form  enctype="multipart/form-data">
                            @csrf
                            <div class="row col-12">
                                @php
                                    $grid = 10;
                                @endphp
                                @if (Auth::user()->internalRole->uptd == null)
                                @php
                                    $grid = 5;
                                @endphp
                                <div class="col-sm-12 col-xl-{{ $grid }} mb-6">
                                    <h4 class="sub-title">UPTD</h4>
                                    <select class="form-control" id="uptd" onchange="ubahOption()" style="width: 100%" name="uptd_filter">
                                        <option value="">Pilih Semua</option>
                                        @foreach ($input_uptd_lists as $item)
                                        @if ( $item->id != 11)
                                            <option value="{{ $item->id }}" @if(@$filter['uptd_filter'] == $item->id ) selected @endif>UPTD {{ $item->id }}</option>  
                                        @endif     
                                        @endforeach    
                                    </select>
                                </div>
                                
                                @endif
                                <div class="col-sm-12 col-xl-{{ $grid }} col-md-{{ $grid }} mb-3">
                                    <h4 class="sub-title">SPPJJ</h4>
                                    
                                    <select class=" form-control" name="sup_filter" id="sup" name="sup" onchange="ubahOption1()"  >
                                        <option value="">Pilih Semua</option>
                                        @foreach ($sup as $item)
                                        <option value="{{ $item->kd_sup }}" @if(@$filter['sup_filter'] == $item->kd_sup ) selected @endif>{{ $item->name }}</option>  
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <input name="filter" value="true" style="display: none" /> --}}
    
                                <div class="mt-3 col-sm-12 col-xl-2 mb-2">
                                    {{-- <button type="submit" class="mt-4 btn btn-primary waves-effect waves-light">Filter</button> --}}
                                    <button class="mt-4 btn btn-primary waves-effect waves-light" type="submit" formmethod="get" formaction="{{ route('getMasterRuasJalan') }}">Filter</button>
                                    {{-- <button class="mt-4 btn btn-mat btn-success " formmethod="post" type="submit" formaction="{{ route('sapu-lobang.rekapitulasi') }}">Cetak Rekap Entry</button> --}}
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Tabel Ruas Jalan</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            {{-- <li><i class="feather icon-maximize full-card"></i></li> --}}
                            <li><i class="feather icon-minus minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    @if (hasAccess(Auth::user()->internal_role_id, 'Ruas Jalan', 'Create'))
                        <a data-toggle="modal" href="#addModal" class="mb-3 btn btn-mat btn-primary">Tambah</a>
                    @endif
                    <div class="dt-responsive table-responsive">
                        <table id="dttable" class="table table-striped table-bordered able-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Ruas Jalan</th>
                                    <th>Nama Ruas Jalan</th>
                                    {{-- <th>Sup</th> --}}
                                    <th>Lokasi</th>
                                    <th>Panjang (meter)</th>
                                    <th>STA Awal</th>
                                    <th>STA Akhir</th>
                                    <th>Lat Awal</th>
                                    <th>Long Awal</th>
                                    <th>Lat Akhir</th>
                                    <th>Long Akhir</th>
                                    <th>Kabupaten Kota</th>
                                    <th>Kode SPPJJ</th>
                                    <th>Nama SPPJJ</th>
                                    <th>Latatitude Titik Tengah (Centroid)</th>
                                    <th>Longitude Titik Tengah (Centroid)</th>
                                    <th>Wilayah UPTD</th>
                                    <th style="min-width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodyJembatan">
                                @foreach ($ruasJalan as $no => $data)
                                <tr>
                                    <td>{{ ++$no }}</td>
                                    <td>{{ $data->id_ruas_jalan }}</td>
                                    <td>{{ $data->nama_ruas_jalan }}</td>
                                    <td>{{ $data->lokasi }}</td>
                                    <td>{{ $data->panjang }}</td>
                                    <td>{{ $data->sta_awal }}</td>
                                    <td>{{ $data->sta_akhir }}</td>
                                    <td>{{ $data->lat_awal }}</td>
                                    <td>{{ $data->long_awal }}</td>
                                    <td>{{ $data->lat_akhir }}</td>
                                    <td>{{ $data->long_akhir }}</td>
                                    <td>{{ @$data->data_kota->name }}</td>
                                    <td>{{ @$data->data_sup->kd_sup }}</td>
                                    <td>{{ @$data->data_sup->name }}</td>
                                    <td>{{ $data->lat_ctr }}</td>
                                    <td>{{ $data->long_ctr }}</td>
                                    <td>{{ $data->uptd_id }}</td>

                                    <td>
                                        @if (hasAccess(Auth::user()->internal_role_id, 'Ruas Jalan', 'Update'))
                                        <a href="{{ route('editMasterRuasJalan', $data->id) }}"><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-sm waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>
                                        @endif
                                        @if (hasAccess(Auth::user()->internal_role_id, 'Ruas Jalan', 'Delete'))
                                        <a href="#delModal" data-id="{{ $data->id }}" data-toggle="modal"><button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-sm waves-effect waves-light"><i class="icofont icofont-trash"></i></button></a>
                                        @endif
                                       
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
        @if (hasAccess(Auth::user()->internal_role_id, 'Ruas Jalan', 'Delete'))
            <div class="modal fade" id="delModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title">Hapus Data Ruas Jalan</h4>
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
        @endif
    </div>

    <div class="modal-only">
        @if (hasAccess(Auth::user()->internal_role_id, 'Ruas Jalan', 'Create'))
            <div class="modal fade searchableModalContainer" id="addModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">

                        <form action="{{ route('createMasterRuasJalan') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Data Ruas Jalan</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="p-5 modal-body">

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Kode Ruas Jalan</label>
                                    <div class="col-md-9">
                                        <input name="id_ruas_jalan" type="text" class="form-control" maxlength="6" placeholder="Contoh :19115K"  required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Nama Ruas Jalan</label>
                                    <div class="col-md-9">
                                        <input name="nama_ruas_jalan" type="text" class="form-control" placeholder="Contoh : Jl. Otista (Garut)" required>
                                    </div>
                                </div>

                                @if (Auth::user()->internalRole->uptd)
                                    <input id="uptd_id" name="uptd_id" type="number" class="form-control"
                                        value="{{ str_replace('uptd', '', Auth::user()->internalRole->uptd) }}" hidden>
                                @else
                                    <div class=" form-group row">
                                        <label class="col-md-3 col-form-label">UPTD</label>
                                        <div class="col-md-9">
                                            <select class="form-control searchableModalField" id="uptd_id" name="uptd_id"
                                                style="width: 100%;;" onchange="ubahDataSUP()" required>
                                                <option>Pilih UPTD</option>
                                                @foreach ($uptd as $uptdData)
                                                    <option value="{{ $uptdData->id }}">{{ $uptdData->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">SUP</label>
                                    <div class="col-md-9">
                                        <select class="form-control searchableModalField" id="sup" name="sup"
                                            style="width:100%;" required>
                                            @if (Auth::user()->internalRole->uptd)
                                                @foreach ($sup as $supData)
                                                    <option
                                                        value="<?php echo $supData->id; ?>">
                                                        <?php echo $supData->name; ?>
                                                    </option>
                                                @endforeach
                                            @else
                                                <option>-</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Lokasi</label>
                                    <div class="col-md-9">
                                        <input name="lokasi" type="text" class="form-control"  placeholder="Contoh : KM.BDG 10+100" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Panjang (meter)</label>
                                    <div class="col-md-9">
                                        <input name="panjang" type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Contoh : 1000" class="form-control"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">STA Awal</label>
                                    <div class="col-md-9">
                                        <input name="sta_awal" placeholder="1000" type="text"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">STA Akhir</label>
                                    <div class="col-md-9">
                                        <input name="sta_akhir" placeholder="2100" type="text"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Latitude Awal</label>
                                    <div class="col-md-9">
                                        <input id="lat0" name="lat_awal" type="text" class="form-control formatLatLong"  placeholder="Contoh : -7.23698000000000000" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Longitude Awal</label>
                                    <div class="col-md-9">
                                        <input id="long0" name="long_awal" type="text" class="form-control formatLatLong" placeholder="Contoh : 107.90745600000000000" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Latitude Titik Tengah (Centroid)</label>
                                    <div class="col-md-9">
                                        <input id="lat1" name="lat_ctr" type="text" class="form-control formatLatLong" placeholder="Contoh : -7.28653600000000000">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Longitude Titik Tengah (Centroid)</label>
                                    <div class="col-md-9">
                                        <input id="long1" name="long_ctr" type="text" class="form-control formatLatLong" placeholder="Contoh : 107.92037600000000000">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Latitude Akhir</label>
                                    <div class="col-md-9">
                                        <input id="lat2" name="lat_akhir" type="text" class="form-control formatLatLong" placeholder="Contoh : -7.33096300000000000" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Longitude Akhir</label>
                                    <div class="col-md-9">
                                        <input id="long2" name="long_akhir" type="text" class="form-control formatLatLong" placeholder="Contoh : 107.94587100000000000" required>
                                    </div>
                                </div>

                                <p>Marker Biru: Titik Awal <br> Marker Hijau: Titik Tengah <br> Marker Merah: Titik Akhir <br> (Dipilih Bergantian) </p>
                                <div id="mapLatLong" class="mb-2 full-map" style="height: 300px; width: 100%"></div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Kabupaten Kota</label>
                                    <div class="col-md-9">
                                        <input name="kab_kota" type="text" class="form-control" placeholder="Contoh : Kabubaten Bandung" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Foto 1</label>
                                    <div class="col-md-5">
                                        <img style="min-height: 40px" class="mx-auto rounded img-thumbnail d-block" id="foto_preview"
                                            src="" alt="">
                                    </div>
                                    <div class="col-md-5">
                                        <input id="foto" name="foto" type="file" accept="image/*" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Foto 2</label>
                                    <div class="col-md-5">
                                        <img style="min-height: 40px" class="mx-auto rounded img-thumbnail d-block" id="foto_preview_1"
                                            src="" alt="">
                                    </div>
                                    <div class="col-md-5">
                                        <input  id="foto_1" name="foto_1" type="file" accept="image/*" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Foto 3</label>
                                    <div class="col-md-5">
                                        <img style="min-height: 40px" class="mx-auto rounded img-thumbnail d-block" id="foto_preview_2"
                                            src="" alt="">
                                    </div>
                                    <div class="col-md-5">
                                        <input id="foto_2" name="foto_2" type="file" accept="image/*" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Video</label>
                                    <div class="col-md-5">
                                        <video class="mx-auto rounded img-thumbnail d-block" id="video_preview"
                                            src="" alt="" controls>
                                    </div>
                                    <div class="col-md-5">
                                        <input id="video" name="video" type="file" accept="video/mp4" class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect "
                                    data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light ">Simpan</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="delModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title">Hapus Data Ruas Jalan</h4>
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
            </li>
        @endif
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery/js/jquery.mask.js') }}"></script>
    <script src="https://js.arcgis.com/4.18/"></script>

    <script>
        $(document).ready(function() {
            $("#dttable").DataTable();

            const filePreviews = [
            {
                input:"foto",
                preview:"foto_preview"
            },{
                input:"foto_1",
                preview:"foto_preview_1"
            },{
                input:"foto_2",
                preview:"foto_preview_2"
            },{
                input:"video",
                preview:"video_preview"
            },
        ]
        filePreviews.forEach(data=>{
            const inputElement = document.getElementById(data.input)
            inputElement.onchange = event => {
            const [file] = inputElement.files
            if(file) document.getElementById(data.preview).src = URL.createObjectURL(file)
        }
        })
            // $("#dttable").DataTable();
            $('#delModal').on('show.bs.modal', function(event) {
                const link = $(event.relatedTarget);
                const id = link.data('id');
                console.log(id);
                const url = `{{ url('admin/master-data/ruas-jalan/delete') }}/` + id;
                console.log(url);
                const modal = $(this);
                modal.find('.modal-footer #delHref').attr('href', url);
            });

            $("#addModal").on('show.bs.modal', function (event) {
                $('#mapLatLong').ready(() => {
                    require([
                    "esri/Map",
                    "esri/views/MapView",
                    "esri/Graphic"
                    ], function(Map, MapView, Graphic) {

                        const map = new Map({
                            basemap: "streets"
                        });

                        const view = new MapView({
                            container: "mapLatLong",
                            map: map,
                            center: [107.6191, -6.9175],
                            zoom: 9,
                        });

                        let tempGraphic = [];

                        if($("#lat0").val() != '' && $("#long0").val() != ''){
                            addTitik(0, $("#lat0").val(), $("#long0").val(), "blue");
                        }
                        if($("#lat1").val() != '' && $("#long1").val() != ''){
                            addTitik(1, $("#lat1").val(), $("#long1").val(), "green");
                        }
                        if($("#lat2").val() != '' && $("#long2").val() != ''){
                            addTitik(2, $("#lat2").val(), $("#long2").val(), "red");
                        }

                        let mouseclick = 0;

                        view.on("click", function(event){
                            const lat = event.mapPoint.latitude;
                            const long = event.mapPoint.longitude;

                            // Genap = Titik Awal
                            if(mouseclick % 3 == 0){
                                addTitik(0, lat, long, "blue");
                                $("#lat0").val(lat);
                                $("#long0").val(long);
                            }else if(mouseclick % 3 == 1){
                                addTitik(1, lat, long, "green");
                                $("#lat1").val(lat);
                                $("#long1").val(long);
                            }else{
                                addTitik(2, lat, long, "red");
                                $("#lat2").val(lat);
                                $("#long2").val(long);
                            }
                            mouseclick++;
                        });

                        $("#lat0, #long0").keyup(function () {
                            const lat = $("#lat0").val();
                            const long = $("#long0").val();
                            addTitik(0, lat, long, "blue");
                        });
                        $("#lat1, #long1").keyup(function () {
                            const lat = $("#lat1").val();
                            const long = $("#long1").val();
                            addTitik(1, lat, long, "green");
                        });
                        $("#lat2, #long2").keyup(function () {
                            const lat = $("#lat2").val();
                            const long = $("#long2").val();
                            addTitik(2, lat, long, "red");
                        });

                        function addTitik(point, lat, long, color){
                            if($("#lat"+point).val() != '' && $("#long"+point).val() != ''){
                                view.graphics.remove(tempGraphic[point]);
                            }
                            var graphic = new Graphic({
                                geometry: {
                                    type: "point",
                                    longitude: long,
                                    latitude: lat
                                },
                                symbol: {
                                    type: "picture-marker",
                                    url: `http://esri.github.io/quickstart-map-js/images/${color}-pin.png`,
                                    width: "14px",
                                    height: "24px"
                                }
                            });
                            tempGraphic[point] = graphic;

                            view.graphics.add(graphic);
                        }
                    });
                });
            });

            // Format mata uang.
            $('.formatRibuan').mask('000.000.000.000.000', {
                reverse: true
            });

            // Format untuk lat long.
            $('.formatLatLong').keypress(function(evt) {
                return (/^\-?[0-9]*\.?[0-9]*$/).test($(this).val() + evt.key);
            });
            var filter = {!! json_encode($filter) !!};
            
            // var table = $('#dttable').DataTable({
            //     processing: true,
            //     serverSide: true,
            //     ajax: "{{ url('admin/master-data/ruas-jalan/json/') }}",
            //     columns: [{
            //             'mRender': function(data, type, full, meta) {
            //                 return +meta.row + meta.settings._iDisplayStart + 1;
            //             }
            //         },
            //         {
            //             data: 'id_ruas_jalan',
            //             name: 'id_ruas_jalan'
            //         },
            //         {
            //             data: 'nama_ruas_jalan',
            //             name: 'nama_ruas_jalan'
            //         },
            //         {
            //             data: 'sup',
            //             name: 'sup'
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
            //             data: 'sta_awal',
            //             name: 'sta_awal'
            //         },
            //         {
            //             data: 'sta_akhir',
            //             name: 'sta_akhir'
            //         },
            //         {
            //             data: 'lat_awal',
            //             name: 'lat_awal'
            //         },
            //         {
            //             data: 'long_awal',
            //             name: 'long_awal'
            //         },
            //         {
            //             data: 'lat_akhir',
            //             name: 'lat_akhir'
            //         },
            //         {
            //             data: 'long_akhir',
            //             name: 'long_akhir'
            //         },
            //         {
            //             data: 'kab_kota',
            //             name: 'kab_kota'
            //         },
            //         {
            //             data: 'kd_sppjj',
            //             name: 'kd_sppjj'
            //         },
            //         {
            //             data: 'nm_sppjj',
            //             name: 'nm_sppjj'
            //         },
            //         {
            //             data: 'lat_ctr',
            //             name: 'lat_ctr'
            //         },
            //         {
            //             data: 'long_ctr',
            //             name: 'long_ctr'
            //         },
            //         {
            //             data: 'wil_uptd',
            //             name: 'wil_uptd'
            //         },
            //         {
            //             data: 'action',
            //             name: 'action',
            //             orderable: false,
            //             searchable: false
            //         },
            //     ]
            // });
        });

        function ubahDataSUP() {

            val = document.getElementById("uptd_id").value

            $.ajax({
                url: "{{ url('admin/master-data/ruas-jalan/getSUP') }}",
                method: 'get',
                dataType: 'JSON',
                data: {
                    id: val
                },
                complete: function(result) {
                    $('#sup').empty(); // remove old options
                    $('#sup').append($("<option></option>").text('Pilih SUP'));

                    result.responseJSON.forEach(function(item) {
                        $('#sup').append($("<option></option>").attr("value", item["name"]).text(item[
                            "name"]));
                    });
                }
            });
        }

        function ubahOption() {

        //untuk select SUP
        id = document.getElementById("uptd").value
        url = "{{ url('admin/master-data/ruas-jalan/getSUP') }}"
        id_select = '#sup'
        text = 'Pilih Semua'
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
