@extends('admin.layout.index')

@section('title') Laporan Kerusakan @endsection
@section('head')
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/vendor/datatables.net/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/vendor/datatables.net/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">

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
                <h4>Laporan Kerusakan</h4>
                <span>Dashboard Pemetaan Kerusakan Infrastruktur Berdasarkan Laporan Masyarakat</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class=" breadcrumb breadcrumb-title">
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
                        {{-- <li><i class="feather icon-maximize full-card"></i></li> --}}
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div id="viewDiv" style="width:100%;height:600px;padding: 0;margin: 0;"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Tabel Laporan Masyarakat</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        {{-- <li><i class="feather icon-maximize full-card"></i></li> --}}
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="dttable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Pelapor</th>
                                <th>UPTD</th>
                                <th>Kategori Laporan</th>
                                <th>Lokasi</th>
                                <th>Foto Kondisi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyLaporan">

                        </tbody>
                    </table>
                </div>
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
<script src="https://js.arcgis.com/4.17/"></script>
<script>
    $(document).ready(function () {
        require([
            "esri/Map",
            "esri/views/MapView",
            "esri/request",
            "esri/geometry/Point",
            "esri/Graphic",
        ], function (Map, MapView, esriRequest, Point, Graphic) {
            const baseUrl = "{{url('')}}";

            const map = new Map({
                basemap: "hybrid"
            });
            const view = new MapView({
                container: "viewDiv",
                map: map,
                center: [107.6191, -6.9175], // longitude, latitude
                zoom: 8
            });

            const symbol = {
                type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                url: "http://esri.github.io/quickstart-map-js/images/blue-pin.png",
                width: "19px",
                height: "36px"
            };
            const popupTemplate = {
                title: "{jenis}",
                content: [
                    {
                    type: "fields",
                    fieldInfos: [
                        {
                            fieldName: "nama",
                            label: "Pelapor"
                        },
                        {
                            fieldName: "email",
                            label: "Email Pelapor"
                        },
                        {
                            fieldName: "deskripsi",
                            label: "Deskripsi"
                        },
                        {
                            fieldName: "status",
                            label: "Status Pelaporan"
                        },
                        {
                            fieldName: "created_at",
                            label: "Tanggal Dilaporkan"
                        },
                        {
                            fieldName: "lat",
                            label: "Latitude"
                        },
                        {
                            fieldName: "long",
                            label: "Longitude"
                        },
                        {
                            fieldName: "uptd_id",
                            label: "UPTD"
                        }
                    ]
                    },
                    {
                            type: "custom",
                            outFields: ["*"],
                            creator: function(feature) {
                                console.log(feature)
                                const media = feature.graphic.attributes.gambar;
                                let html = '';
                            function getExtension(filename) {
                            var parts = filename.split('.');
                            return parts[parts.length - 1];
                            }
                            function isImage(filename) {
                            var ext = getExtension(filename);
                            switch (ext.toLowerCase()) {
                                case 'jpg':
                                case 'gif':
                                case 'bmp':
                                case 'png':
                                return true;
                            }
                            return false;
                            }

                            function isVideo(filename) {
                            var ext = getExtension(filename);
                            switch (ext.toLowerCase()) {
                                case 'm4v':
                                case 'avi':
                                case 'mpg':
                                case 'mp4':
                                case 'mov':
                                return true;
                            }
                            return false;
                            }
                                if (isImage(media)) {
                                    html += `
                                    <div class="esri-feature-media__item">
                                        <img src="${baseUrl}/storage/${media}" alt="Failed to load" />
                                    </div>`;
                                }
                                if (isVideo(media)) {
                                    html += `
                                    <div class="esri-feature-media__item">
                                        <video controls class="esri-feature-media__item">
                                            <source src="${baseUrl}/storage/${media}">
                                        </video>
                                    </div>`;
                                }
                                return html;
                            }
                        },
                ]
            };


            const url = baseUrl + "/map/laporan-masyarakat";
            const requestLaporan = esriRequest(url, {
                responseType: "json",
            }).then(function(response){
                const json = response.data;
                const data = json.data;
                const table = document.getElementById('bodyLaporan');
                let i = 1;
                if(data.length == 0){
                    table.innerHTML =   `<tr>
                                            <td colspan="5">Data Kosong</td>
                                        </tr>`;
                }else{
                    data.forEach(item => {
                        var point = new Point(item.long, item.lat);
                        let graphic = new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        });
                        view.graphics.add(graphic);
                        table.innerHTML +=  `<tr>
                                                <td>
                                                    <b>${item.nama}</b> <br>
                                                    ${item.nik} <br>
                                                    ${item.telp} <br>
                                                    ${item.email} <br>
                                                </td>
                                                <td>UPTD ${item.uptd_id}</td>
                                                <td>${item.jenis}</td>
                                                <td>
                                                    ${item.lat} <br>
                                                    ${item.long}
                                                </td>
                                                <td>
                                                    <img src="https://tj.temanjabar.net/storage/${item.gambar}" class="img-fluid rounded" alt="" style="max-width: 224px;">
                                                </td>
                                            </tr>`;
                    });
                }
                $("#dttable").DataTable();
            }).catch(function (error) {
                console.log(error);
            });


        });
    });
</script>
@endsection
