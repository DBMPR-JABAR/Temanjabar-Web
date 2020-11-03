@extends('admin.t_index')

@section('title') Admin Dashboard @endsection
<link rel="stylesheet" type="text/css" href="{{ asset('assets\vendor\datatables.net-bs4\css\dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets\vendor\data-table\css\buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets\vendor\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets\vendor\data-table\extensions\responsive\css\responsive.dataTables.css') }}">
   <style>
     table.table-bordered tbody td {
    word-break: break-word;
    vertical-align: top;
}
     </style>
@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Proyek Kontrak</h4>

            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Proyek Kontrak</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')







<div class="row">
<div class="col-lg-12">
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
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="accordion-content accordion-desc">

                          <div class="card-block">
                             <div class="row">
                                <div class="col-sm-12 col-xl-3 m-b-30">
                                   <h4 class="sub-title">Tahun</h4>
                                   <select name="select" class="form-control form-control-primary">
                                      <option value="opt1">-</option>
                                      <option value="opt2">2019</option>
                                      <option value="opt3">2020</option>
                                    </select>
                                 </div>
                              <div class="col-sm-12 col-xl-3 m-b-30">
                                   <h4 class="sub-title">UPTD</h4>
                                   <select name="select" id="uptd"class="form-control form-control-primary">
                                        <option value="opt1">Semua</option>
                                        <option value="opt2">UPTD 1 Sukabumi</option>
                                         <option value="pembangunan">UPTD 2 ....</option>
                                         <option value="peningkatan">UPTD 3 </option>
                                         <option value="peningkatan">UPTD 4 </option>
                                         <option value="peningkatan">UPTD 5 </option>
                                         <option value="peningkatan">UPTD 6  </option>
                                    </select>
                              </div>
                              <div class="col-sm-12 col-xl-3 m-b-30">
                                   <h4 class="sub-title">Kegiatan</h4>
                                   <select name="select" class="form-control form-control-primary">
                                       <option value="opt1">Semua</option>
                                        <option value="opt2">Pemeliharaan berkala</option>
                                        <option value="pembangunan">Pembangunan</option>
                                        <option value="peningkatan">Peningkatan</option>
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
           </div>



    <!-- task, page, download counter  start -->
    
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8"><a href="{{url('admin/monitoring/proyek-kontrak/status/CRITICAL CONTACT')}}">
                        <h4 class="text-c-yellow f-w-600">{{$countCritical}}</h4></a>
                        <h6 class="text-muted m-b-0">Critical Contract</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-bar-chart f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-c-yellow">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">% pekerjaan</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8"><a href="{{url('admin/monitoring/proyek-kontrak/status/ON PROGRESS')}}">
                        <h4 class="text-c-green f-w-600">50</h4> </a>
                        <h6 class="text-muted m-b-0">On Progress</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-file-text f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-c-green">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">% Pekerjaan</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8"><a href="{{url('admin/monitoring/proyek-kontrak/status/OFF PROGRESS')}}">
                        <h4 class="text-c-pink f-w-600">{{$countOffProgress}}</h4></a>
                        <h6 class="text-muted m-b-0">Off Progress</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-calendar f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-c-pink">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">% pekerjaan</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8"><a href="{{url('admin/monitoring/proyek-kontrak/status/FINISH')}}">
                        <h4 class="text-c-blue f-w-600">100</h4></a>
                        <h6 class="text-muted m-b-0">Finish</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-download f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-c-blue">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">% Pekerjaan</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
 
    <!-- task, page, download counter  end -->
      <div class="col-xl-12 col-md-12">
        <div class="card">
          <div class="card-block">
            <div id="chartdiv2" style="height:250px"></div>
          </div>
        </div>
      </div>  
    <!-- visitor start -->
    <div class="col-xl-12 col-md-12">
        <div class="card">

            <div class="card-header">
                <h5>Daftar Penyelesaian Pekerjaan Kontraktor</h5>

                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                        <li><i class="feather icon-trash-2 close-card"></i></li>
                    </ul>
                </div>
            </div>

            <div class="card-block">

                <ul class="nav nav-tabs md-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home3" role="tab">Finish</a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile3" role="tab">On Progress</a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#messages3" role="tab">Crtitical Contract</a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#settings3" role="tab">Off Progress</a>
                        <div class="slide"></div>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content card-block">
                    <div class="tab-pane active" id="home3" role="tabpanel">
                        <!-- chart -->
                        <div id="chartdiv" style="height:250px"></div>
                        <!--  -->

                    </div>
                    <div class="tab-pane" id="profile3" role="tabpanel">
                        <!-- Chart -->
                        <div id="chartdivontrack" style="height:250px"></div>
                        <!--  -->
                       
                     </div>
                    <div class="tab-pane" id="messages3" role="tabpanel">
                        <div id="chartdivalert" style="height:250px"></div>
                     </div>
                    <div class="tab-pane" id="settings3" role="tabpanel">
                        <div id="chartdivselesai" style="height:250px"></div>
                    </div>
                </div>

                <div class="card" style="box-shadow: none;">

                <div class="card-block">
                            <div class="table-responsive dt-responsive">
                              <table id="proyekContract" style="width:100%;font-size:12px" class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No.</th>
                                        <th>Tanggal</th>
                                        <th style="width:10px">Nama Paket</th>
                                        <th>Penyedia Jasa</th>
                                        <th>Kategori</th>
                                        <th style="width:5%">Jenis Pekerjaan</th>
                                        <th>Ruas Jalan</th>
                                        <th>Lokasi</th>
                                        <th>Rencana</th>
                                        <th>Realisasi</th>
                                        <th>Deviasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $number = 1 ?>
                                @foreach ($listProjectContract as $data)
                                        <tr>
                                        <td>{{$number++}}</td>
                                        <td>{{ $data->TANGGAL }}</td>
                                        <td style="width:10px">{{$data->NAMA_PAKET}} </th>
                                              
                                        <td>{{$data->PENYEDIA_JASA}} </th>
                                            <td><b>{{$data->KEGIATAN}}</b></td>
                                            <td>{{$data->JENIS_PEKERJAAN}}</td>
                                            <td>{{$data->RUAS_JALAN}}</td>
                                            <td>{{$data->LOKASI}}</td>
                                            <td>{{$data->RENCANA}}</td>
                                            <td>{{$data->REALISASI}}</td>
                                            <td>{{$data->DEVIASI}}</td>
                                            <td></td>
                                        </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                            </div>
                          </div>
                      </div>
                 </div>
              </div>
          </div>

     <!-- sale order start -->
      </div>
@endsection

@section('script')
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
   
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive-custom.js') }}"></script>

<script>
    am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    var chart = am4core.create("chartdiv", am4charts.XYChart);

    // Add data
    chart.data = [

      {
        "region": "OnTrack",
        "state": "Lingatama",
        "sales": 16
      },
      {
        "region": "OnTrack",
        "state": "Asakiwari",
        "sales": 10
      },
      {
        "region": "OnTrack",
        "state": "PT.Buana",
        "sales": 9
      },
      {
        "region": "OnTrack",
        "state": "CDS Studio",
        "sales": 22
      },

      {
        "region": "OnTrack",
        "state": "Kuli",
        "sales": 4
      }
    ];

    // Create axes
    var yAxis = chart.yAxes.push(new am4charts.CategoryAxis());
    yAxis.dataFields.category = "state";
    yAxis.renderer.grid.template.location = 0;
    yAxis.renderer.labels.template.fontSize = 10;
    yAxis.renderer.minGridDistance = 10;

    var xAxis = chart.xAxes.push(new am4charts.ValueAxis());

    // Create series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.dataFields.valueX = "sales";
    series.dataFields.categoryY = "state";
    series.columns.template.tooltipText = "{categoryY}: [bold]{valueX}[/]";
    series.columns.template.strokeWidth = 0;
    series.columns.template.adapter.add("fill", function(fill, target) {
      if (target.dataItem) {
        switch(target.dataItem.dataContext.region) {
          case "Selesai":
            return chart.colors.getIndex(0);
            break;
          case "Off Progress":
            return chart.colors.getIndex(1);
            break;
          case "Crtitical Contract":
            return chart.colors.getIndex(2);
            break;
          case "OnTrack":
            return "#2196f3";
            break;
        }
      }
      return fill;
    });

    var axisBreaks = {};
    var legendData = [];

    // Add ranges



    chart.cursor = new am4charts.XYCursor();


    var legend = new am4charts.Legend();
    legend.position = "right";
    legend.scrollable = true;
    legend.valign = "top";
    legend.reverseOrder = true;

    chart.legend = legend;
    legend.data = legendData;

    legend.itemContainers.template.events.on("toggled", function(event){
      var name = event.target.dataItem.dataContext.name;
      var axisBreak = axisBreaks[name];
      if(event.target.isActive){
        axisBreak.animate({property:"breakSize", to:0}, 1000, am4core.ease.cubicOut);
        yAxis.dataItems.each(function(dataItem){
          if(dataItem.dataContext.region == name){
            dataItem.hide(1000, 500);
          }
        })
        series.dataItems.each(function(dataItem){
          if(dataItem.dataContext.region == name){
            dataItem.hide(1000, 0, 0, ["valueX"]);
          }
        })
      }
      else{
        axisBreak.animate({property:"breakSize", to:1}, 1000, am4core.ease.cubicOut);
        yAxis.dataItems.each(function(dataItem){
          if(dataItem.dataContext.region == name){
            dataItem.show(1000);
          }
        })

        series.dataItems.each(function(dataItem){
          if(dataItem.dataContext.region == name){
            dataItem.show(1000, 0, ["valueX"]);
          }
        })
      }
    })

    }); // end am4core.ready()



















    var chart2 = am4core.create("chartdivontrack", am4charts.XYChart);

    // Add data
    chart2.data = [

      {
        "region": "OnTrack",
        "state": "Lingatama",
        "sales": 1
      },
      {
        "region": "OnTrack",
        "state": "Asakiwari",
        "sales": 3
      },
      {
        "region": "OnTrack",
        "state": "PT.Buana",
        "sales": 7
      },
      {
        "region": "OnTrack",
        "state": "CDS Studio",
        "sales": 2
      },

      {
        "region": "OnTrack",
        "state": "Kuli",
        "sales": 4
      }
    ];

    // Create axes
    var yAxis2 = chart2.yAxes.push(new am4charts.CategoryAxis());
    yAxis2.dataFields.category = "state";
    yAxis2.renderer.grid.template.location = 0;
    yAxis2.renderer.labels.template.fontSize = 10;
    yAxis2.renderer.minGridDistance = 10;

    var xAxis = chart2.xAxes.push(new am4charts.ValueAxis());

    // Create series
    var series = chart2.series.push(new am4charts.ColumnSeries());
    series.dataFields.valueX = "sales";
    series.dataFields.categoryY = "state";
    series.columns.template.tooltipText = "{categoryY}: [bold]{valueX}[/]";
    series.columns.template.strokeWidth = 0;
    series.columns.template.adapter.add("fill", function(fill, target) {
      if (target.dataItem) {
        switch(target.dataItem.dataContext.region) {
          case "Selesai":
            return chart2.colors.getIndex(0);
            break;
          case "Off Progress":
            return chart2.colors.getIndex(1);
            break;
          case "Crtitical Contract":
            return chart2.colors.getIndex(2);
            break;
          case "OnTrack":
            return "#0df3a3";
            break;
        }
      }
      return fill;
    });

    var axisBreaks = {};
    var legendData = [];

    // Add ranges



    chart.cursor = new am4charts.XYCursor();


    var legend = new am4charts.Legend();
    legend.position = "right";
    legend.scrollable = true;
    legend.valign = "top";
    legend.reverseOrder = true;

    chart.legend = legend;
    legend.data = legendData;

    legend.itemContainers.template.events.on("toggled", function(event){
      var name = event.target.dataItem.dataContext.name;
      var axisBreak = axisBreaks[name];
      if(event.target.isActive){
        axisBreak.animate({property:"breakSize", to:0}, 1000, am4core.ease.cubicOut);
        yAxis.dataItems.each(function(dataItem){
          if(dataItem.dataContext.region == name){
            dataItem.hide(1000, 500);
          }
        })
        series.dataItems.each(function(dataItem){
          if(dataItem.dataContext.region == name){
            dataItem.hide(1000, 0, 0, ["valueX"]);
          }
        })
      }
      else{
        axisBreak.animate({property:"breakSize", to:1}, 1000, am4core.ease.cubicOut);
        yAxis.dataItems.each(function(dataItem){
          if(dataItem.dataContext.region == name){
            dataItem.show(1000);
          }
        })

        series.dataItems.each(function(dataItem){
          if(dataItem.dataContext.region == name){
            dataItem.show(1000, 0, ["valueX"]);
          }
        })
      }
    });

</script>

<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end



var chart2 = am4core.create('chartdiv2', am4charts.XYChart)
chart2.colors.step = 2;

chart2.legend = new am4charts.Legend()
chart2.legend.position = 'top'
chart2.legend.paddingBottom = 20
chart2.legend.labels.template.maxWidth = 95

var xAxis = chart2.xAxes.push(new am4charts.CategoryAxis())
xAxis.dataFields.category = 'category'
xAxis.renderer.cellStartLocation = 0.1
xAxis.renderer.cellEndLocation = 0.9
xAxis.renderer.grid.template.location = 0;

var yAxis = chart2.yAxes.push(new am4charts.ValueAxis());
yAxis.min = 0;

function createSeries(value, name) {
    var series = chart2.series.push(new am4charts.ColumnSeries())
    series.dataFields.valueY = value
    series.dataFields.categoryX = 'category'
    series.name = name

    series.events.on("hidden", arrangeColumns);
    series.events.on("shown", arrangeColumns);

    var bullet = series.bullets.push(new am4charts.LabelBullet())
    bullet.interactionsEnabled = false
    bullet.dy = 30;
    bullet.label.text = '{valueY}'
    bullet.label.fill = am4core.color('#ffffff')

    return series;
}

chart2.data = [
    {
        category: 'UPTD 1',
        first: 40,
        second: 55,
        third: 60
    },
    {
        category: 'UPTD 2',
        first: 30,
        second: 78,
        third: 69
    },
    {
        category: 'UPTD 3',
        first: 27,
        second: 40,
        third: 45
    },
    {
        category: 'UPTD 4',
        first: 50,
        second: 33,
        third: 22
    }
]


createSeries('first', 'Pagu Anggaran');
createSeries('second', 'Nilai Kontrak');
createSeries('third', 'Total Sisa Lelang');

function arrangeColumns() {

    var series = chart2.series.getIndex(0);

    var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
    if (series.dataItems.length > 1) {
        var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
        var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
        var delta = ((x1 - x0) / chart2.series.length) * w;
        if (am4core.isNumber(delta)) {
            var middle = chart2.series.length / 2;

            var newIndex = 0;
            chart2.series.each(function(series) {
                if (!series.isHidden && !series.isHiding) {
                    series.dummyData = newIndex;
                    newIndex++;
                }
                else {
                    series.dummyData = chart2.series.indexOf(series);
                }
            })
            var visibleCount = newIndex;
            var newMiddle = visibleCount / 2;

            chart2.series.each(function(series) {
                var trueIndex = chart2.series.indexOf(series);
                var newIndex = series.dummyData;

                var dx = (newIndex - trueIndex + middle - newMiddle) * delta

                series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
                series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
            })
        }
    }
}

}); // end am4core.ready()
</script>
@endsection
