@extends('admin.layout.index')

@section('title') Bantuan Keuangan @endsection
@section('head')
<link rel="stylesheet" href="https://js.arcgis.com/4.18/esri/themes/light/main.css">
{{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer>
</script> --}}

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Bantuan Keuangan {{$bankeu->id}}</h4>
                <span>Bantuan Keuangan DBMPR Jabar</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class=" breadcrumb breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('bankeu.index') }}">Bantuan Keuangan</a>
                </li>
                <li class="breadcrumb-item"><a href="#">Tambah</a> </li>
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
                <h5>Progress Data Bantuan Keuangan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        {{-- <li><i class="feather icon-maximize full-card"></i></li> --}}
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block pl-5 pr-5 pb-5">
                <figure class="highcharts-figure">
                    <div id="container"></div>
                    <p class="highcharts-description">
                        This chart shows the use of a logarithmic y-axis. Logarithmic axes can
                        be useful when dealing with data with spikes or large value gaps,
                        as they allow variance in the smaller values to remain visible.
                    </p>
                </figure>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/js/jquery.mask.js') }}"></script>
<script src="https://js.arcgis.com/4.18/"></script>
<script>
    const bankeu = @json($bankeu)

    const historis = @json($historis)


    const data = [0]
    console.log(historis.length)
    historis && historis.forEach((histori, idx)=> {
        // for(let i = (Number(historis[idx].progress)-(Number(historis[idx-0].progress)||0)); i>0;i--) {
            data.push(Number(historis[idx].progress))
        // }
    })
    // for(let i = data[historis.length]; i<100;i++) {
    //     data.push(data[historis.length])
    // }

    console.log(historis)
    $(document).ready(() => {
        Highcharts.chart('container', {

            title: {
        text: 'Solar Employment Growth by Sector, 2010-2016'
    },

    subtitle: {
        text: 'Source: thesolarfoundation.com'
    },

    yAxis: {
        title: {
            text: 'Number of Employees'
        }
    },

    xAxis: {
        accessibility: {
            rangeDescription: 'Range: 2010 to 2017'
        },
        min:0,
        max:100
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 0,
            pointEnd: 100
        }
    },

    series: [{
        name: 'Installation',
        data
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

        });
        })

</script>
@endsection
