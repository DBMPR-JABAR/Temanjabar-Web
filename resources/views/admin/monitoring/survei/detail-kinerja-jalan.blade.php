@extends('admin.layout.index')

@section('title') Detail Kinerja Jalan @endsection
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/datatables.net/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/datatables.net/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">


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
                    <h4>Kinerja Jalan</h4>
                    <span>Detail Kinerja Jalan</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class=" breadcrumb breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Detail Kinerja Jalan</a> </li>
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
                    <h5>Detail Data Kinerja Jalan</h5>
                    <h6>Ruas Jalan : {{ $namaJalan }}</h6>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-minus minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div id="chartdiv" style="width:100%;height:500px;padding: 0;margin: 0;"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Kerusakan Jalan</h5>
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
                                    <th>Nomor Sampel</th>
                                    <th>Jenis Kerusakan</th>
                                    <th>Tingkat Keparahan</th>
                                    <th>Dimensi</th>
                                    <th>Satuan</th>
                                    <th>Kerapatan (%)</th>
                                    <th>Lat</th>
                                    <th>Long</th>
                                    <th>Foto Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kerusakan as $data)
                                <tr>
                                    <td>{{$data->nomor_sampel}}</td>
                                    <td>{{$data->jenis_kerusakan}}</td>
                                    <td>{{$data->tingkat_keparahan}}</td>
                                    <td>{{$data->dimensi}}</td>
                                    <td>{{$data->satuan}}</td>
                                    <td>{{$data->kerapatan}}</td>
                                    <td>{{$data->lat}}</td>
                                    <td>{{$data->long}}</td>
                                    <td><img src="{{url('storage/survei/kerusakan/'.$data->gambar)}}" width="100" alt="Tidak Ada Foto"></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">Tidak Ada Data</td>
                                </tr>
                                @endforelse
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

    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

    <script src="https://js.arcgis.com/4.18/"></script>
    <script>
        $(document).ready(function() {
            var kondisi = <?php echo json_encode($kondisi); ?> ;


            am4core.ready(function() {

                am4core.useTheme(am4themes_animated);
                var chart = am4core.create("chartdiv", am4charts.PieChart3D);
                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
                chart.legend = new am4charts.Legend();
                chart.data = [];

                $.each(kondisi, function(key, value) {
                    chart.data.push({
                        category: key,
                        value: value
                    })
                });


                var series = chart.series.push(new am4charts.PieSeries3D());
                series.dataFields.value = "value";
                series.dataFields.category = "category";

            });

        });

    </script>
@endsection
