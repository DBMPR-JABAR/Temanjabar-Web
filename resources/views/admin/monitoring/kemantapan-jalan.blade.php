@extends('admin.t_index')

@section('title') Kemantapan Jalan @endsection
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
                <h4>Kemantapan Jalan</h4>
                <span>Dashboard Pemetaan Kemantapan Jalan</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Kemantapan Jalan</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Rekapitulasi Data Kemantapan Jalan</h5>
                <h6>Dengan Total Luas: {{$luas}} m2</h6>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div id="chartdiv"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Pemetaan Kemantapan Jalan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div id="viewDiv" style="width:100%;height:600px;padding: 0;margin: 0;"></div>
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-header">
                <h5>Tabel Kemantapan Jalan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
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
        </div> --}}
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}" ></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}" ></script>

<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script src="https://js.arcgis.com/4.17/"></script>
<script>
    $(document).ready(function () {
        var kondisi = <?php echo json_encode($kondisi) ?>;// don't use quotes


        am4core.ready(function() {

            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("chartdiv", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
            chart.legend = new am4charts.Legend();
            chart.data = [];

            $.each(kondisi, function(key, value) {
                chart.data.push({
                    country: key,
                    litres: value
                })
            });


            var series = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.value = "litres";
            series.dataFields.category = "country";

        });

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
                zoom: 9
            });

            const symbol = {
                type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                url: baseUrl + "/assets/images/marker/kemantapanjalan.png",
                width: "32px",
                height: "32px"
            };
            const popupTemplate = {
                title: "{RUAS_JALAN}",
                content: [
                    {
                        type: "fields",
                        fieldInfos: [
                            {
                                fieldName: "NO_RUAS",
                                label: "Nomor Ruas"
                            },
                            {
                                fieldName: "SUB_RUAS",
                                label: "Sub Ruas"
                            },
                            {
                                fieldName: "SUFFIX",
                                label: "Suffix"
                            },
                            {
                                fieldName: "BULAN",
                                label: "Bulan"
                            },
                            {
                                fieldName: "TAHUN",
                                label: "Tahun"
                            },
                            {
                                fieldName: "KOTA_KAB",
                                label: "Kota/Kabupaten"
                            },
                            {
                                fieldName: "LAT_AWAL",
                                label: "Latitude Awal"
                            },
                            {
                                fieldName: "LONG_AWAL",
                                label: "Longitude Awal"
                            },
                            {
                                fieldName: "LAT_AKHIR",
                                label: "Latitude Akhir"
                            },
                            {
                                fieldName: "LONG_AKHIR",
                                label: "Longitude Akhir"
                            },
                            {
                                fieldName: "KETERANGAN",
                                label: "Keterangan"
                            },
                            {
                                fieldName: "SUP",
                                label: "SPP/ SUP"
                            },
                            {
                                fieldName: "UPTD",
                                label: "UPTD"
                            }
                        ]
                    },
                    {
                        type: "media",
                        mediaInfos: [
                            {
                                title: "<b>Kondisi Jalan</b>",
                                type: "pie-chart",
                                caption: "Dari Luas Jalan {LUAS} m2",
                                value: {
                                    fields: ["SANGAT_BAIK","BAIK","SEDANG","JELEK","PARAH","SANGAT_PARAH"]
                                }
                            }
                        ]
                    }
                ]
            };


            const url = baseUrl + "/map/kemantapan-jalan";
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
                        var point0 = new Point(item.LONG_AWAL, item.LAT_AWAL);
                        view.graphics.add(new Graphic({
                            geometry: point0,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                        var point1 = new Point(item.LONG_AKHIR, item.LAT_AKHIR);
                        view.graphics.add(new Graphic({
                            geometry: point1,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                }
            }).catch(function (error) {
                console.log(error);
            });


        });
    });
</script>
@endsection
