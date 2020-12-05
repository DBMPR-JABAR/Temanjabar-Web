@extends('admin.t_index')

@section('title') Admin Dashboard @endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Monitoring Target & Realisasi Anggaran DBMPR Provinsi Jawa Barat</h4>

            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Target & Realisasi Anggaran</a> </li>
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
                <h5>Infografis Target Dan Realisasi Keuangan</h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                        <li><i class="feather icon-trash-2 close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div style="height:600px"  id="chartdivInfo1"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Infografis Target Dan Realisasi Fisik</h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                        <li><i class="feather icon-trash-2 close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div style="height:600px"  id="chartdivInfo1"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Infografis Deviasi</h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                        <li><i class="feather icon-trash-2 close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div style="height:600px"  id="chartdivInfo1"></div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script>
    am4core.ready(function() {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create("chartdivInfo1", am4charts.XYChart3D);
        chart.data = [{
            "country": "UPTD I",
            "visits": 80
            }, {
            "country": "UPTD II",
            "visits": 72
            }, {
            "country": "UPTD III",
            "visits": 80.5
            }, {
            "country": "UPTD IV",
            "visits": 82.3
            }, {
            "country": "UPTD V",
            "visits": 69.5
            }, {
            "country": "UPTD LAB",
            "visits": 56.3
            }, {
            "country": "SEKRETARIAT",
            "visits": 70
            }, {
            "country": "BIADANG JASA KONSTRUKSI",
            "visits": 72.5
            }, {
            "country": "BIDANG TEKNIK JALAN",
            "visits": 81.5
            }, {
            "country": "BIDANG PEMELIRAHAAN DAN PEMBANGUNAN JALAN",
            "visits": 82.3
            }, {
            "country": "BIDANG PENATAAN RUANG",
            "visits": 71.8
            }  ];

        // Create axes
        let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "country";
        categoryAxis.renderer.labels.template.rotation = 270;
        categoryAxis.renderer.labels.template.hideOversized = false;
        categoryAxis.renderer.minGridDistance = 20;
        categoryAxis.renderer.labels.template.horizontalCenter = "right";
        categoryAxis.renderer.labels.template.verticalCenter = "middle";
        categoryAxis.tooltip.label.rotation = 270;
        categoryAxis.tooltip.label.horizontalCenter = "right";
        categoryAxis.tooltip.label.verticalCenter = "middle";

        let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Penyerapan (%)";
        valueAxis.title.fontWeight = "bold";

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries3D());
        series.dataFields.valueY = "visits";
        series.dataFields.categoryX = "country";
        series.name = "Visits";
        series.columns.template.fillOpacity = .8;

        var columnTemplate = series.columns.template;
        columnTemplate.strokeWidth = 2;
        columnTemplate.strokeOpacity = 1;
        columnTemplate.stroke = am4core.color("#FFFFFF");

        columnTemplate.adapter.add("fill", function(fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
        })

        columnTemplate.adapter.add("stroke", function(stroke, target) {
        return chart.colors.getIndex(target.dataItem.index);
        })

        chart.cursor = new am4charts.XYCursor();
        chart.cursor.lineX.strokeOpacity = 0;
        chart.cursor.lineY.strokeOpacity = 0;

    }); // end am4core.ready()
</script>

@endsection
