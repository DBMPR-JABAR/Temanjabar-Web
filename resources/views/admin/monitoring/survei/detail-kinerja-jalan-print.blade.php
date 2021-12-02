<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <style>
        table {
            page-break-inside: auto
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto
        }

        @page {
            size: A4;
        }

        #my-table {
            vertical-align: center;
            border: solid 1px #020202;
            border-collapse: collapse;
            font-family: helvetica, serif;
            font-size: 10pt;
            width: 100%;
        }

        #my-table th {
            border: solid 1px #000000;
            background-color: #54f346;
            color: rgb(0, 0, 0);
            text-align: left;
            padding: 5px;
        }

        #my-table td {
            border: solid 1px #000000;
            padding: 2px;
        }


        @print {
            @page :footer {
                display: none
            }

            @page :header {
                display: none
            }
        }

        #chart {
            margin: auto;
            height: 500px;
        }

        @media print {
            #chart {
                height: 200px;
            }
        }
    </style>
</head>

<body>
    <main class="row">
        <div class="col-12 p-2">
            <h5 class="text-center font-weight-light">Laporan Kerusakan Ruas Jalan {{$namaJalan}}</h5>
        </div>
        <div class="col-12">
            <div id="chart"></div>
        </div>
        <div class="col-12">
            <table class="mt-3" id="my-table">
                <thead>
                    <tr>
                        <th>No. Sampel</th>
                        <th>Jenis Kerusakan</th>
                        <th>Tingkat Keparahan</th>
                        <th>Dimensi</th>
                        <th>Satuan</th>
                        <th>Kerapatan(%)</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Foto Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kerusakan as $data)
                    <tr>
                        <td style="text-align:center">{{$data->nomor_sampel}}</td>
                        <td>{{$data->jenis_kerusakan}}</td>
                        <td>{{$data->tingkat_keparahan}}</td>
                        <td>{{$data->dimensi}}</td>
                        <td>{{$data->satuan}}</td>
                        <td>{{number_format($data->kerapatan,2)}}</td>
                        <td>{{$data->lat}}</td>
                        <td>{{$data->long}}</td>
                        <td><img src="{{url('storage/survei/kerusakan/'.$data->gambar)}}" width="100"
                                alt="Tidak Ada Foto">
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">Tidak Ada Data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-12">
            <div class="text-center font-weight-lighter mt-3">
                <table>
                    <tr>
                        <td>Dicetak Oleh</td>
                        <td>:</td>
                        <td>{{Auth::user()->name}}</td>
                    <tr>
                    <tr>
                        <td>Tanggal Cetak</td>
                        <td>:</td>
                        <td>{{date('d-m-Y')}}</td>
                    <tr>
                </table>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const kondisi = @json($kondisi)

            am4core.ready(function() {
                am4core.useTheme(am4themes_animated);
                const chart = am4core.create("chart", am4charts.PieChart3D);
                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
                chart.legend = new am4charts.Legend();
                chart.responsive.enabled = true;
                chart.data = [];
                const keys = Object.keys(kondisi);

                keys.forEach(key => {
                    chart.data.push({
                        category: key,
                        value: kondisi[key]
                    });
                });

                const series = chart.series.push(new am4charts.PieSeries3D());
                series.dataFields.value = "value";
                series.dataFields.category = "category";

                series.colors.list = [
                    am4core.color("#209c05"),
                    am4core.color("#85e62c"),
                    am4core.color("#ebff0a"),
                    am4core.color("#f2ce02"),
                    am4core.color("#f27a02"),
                    am4core.color("#f20202"),
                    am4core.color("#9f5656"),
                ];

                chart.events.on('ready', () => {
                    const chartLogo = document.querySelector('[aria-labelledby="id-66-title"]');
                    chartLogo.style.display = 'none';
                    setTimeout(() => window.print(), 1000);
                });
            });

        });
    </script>
</body>

</html>
