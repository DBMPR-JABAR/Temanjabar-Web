@extends('admin.layout.index')

@section('title') Admin Dashboard @endsection

@section('head')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<style>
   .highcharts-credits {
       display: none !important
    }
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 310px;
        /* max-width: 800px; */
        margin: 1em auto;
        width: 100%
    }

    #container {
        height: 400px;
        width: 100%
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        /* max-width: 500px; */
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }

    /* The Modal (background) */
    .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 80%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
    }

    /* Add Animation */
    @-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
    }

    @keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
    }

    /* The Close Button */
    .close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
    }

    .close:hover,
    .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    }

    .modal-header {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
    }

    .modal-body {padding: 2px 16px;}

    .modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
    }
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.3.1/echarts.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5.3.1/dist/echarts.min.js"></script>
@endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Selamat Datang di Dashboard Teman Jabar</h4>
                {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class=" breadcrumb breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Home</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
<div class="row">
    {{-- <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Data Pemasukan</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><i class="fa fa-window-maximize full-card"></i></li>
                        <li><i class="fa fa-minus minimize-card"></i></li>
                        <li><i class="fa fa-times close-card"></i></li>
                    </ul>
                </div>
            <figure class="highcharts-figure">
                <div id="container_pembangunan_talikuat_uptd"></div>
                
            </figure>

        </div>
    </div> --}}
    <div class="col-sm-12">
		<div class="card">
            <div class="card-header">
                <h4>Grafik UPTD, Kota/Kabupaten & Ruas Jalan </h4>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        {{-- <li><i class="feather icon-maximize full-card"></i></li> --}}
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
			<div class="card-block">
                <div class="row">
                    <div class="chart has-fixed-height" id="pie_basic" style="width: 1000px; height: 700px;"></div>
                    
                </div>
			</div>
		</div>
	</div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-block accordion-block">
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="accordion-panel">
                        <div class="accordion-heading" role="tab" id="headingOne">
                            <h4 class="card-title accordion-title">
                                Filter
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel"
                            aria-labelledby="headingOne">
                            <div class="accordion-content accordion-desc">
                                <div class="card-block w-100">
                                    <form  enctype="multipart/form-data">
                                        @csrf
                                        <div class="row col-12">
                                            @php
                                                $grid = 5;
                                            @endphp
                                            {{-- @if (Auth::user()->internalRole->uptd == null)
                                            <div class="col-sm-12 col-xl-2">
                                                <h4 class="sub-title">UPTD</h4>
                                                <select class="form-control" style="width: 100%" name="uptd_filter">
                                                    <option value="">Pilih Semua</option>
                                                    <option value="1" @if(@$filter['uptd_filter'] == 1 ) selected @endif>UPTD 1</option>
                                                    <option value="2" @if(@$filter['uptd_filter'] == 2 ) selected @endif>UPTD 2</option>
                                                    <option value="3" @if(@$filter['uptd_filter'] == 3 ) selected @endif>UPTD 3</option>
                                                    <option value="4" @if(@$filter['uptd_filter'] == 4 ) selected @endif>UPTD 4</option>
                                                    <option value="5" @if(@$filter['uptd_filter'] == 5 ) selected @endif>UPTD 5</option>
                                                    <option value="6" @if(@$filter['uptd_filter'] == 6 ) selected @endif>UPTD 6</option>
                                                </select>
                                            </div>
                                            @php
                                                $grid = 4;
                                            @endphp
                                            @endif --}}
                                            <div class="col-sm-12 col-xl-{{ $grid }} col-md-{{ $grid }} ">
                                                <h4 class="sub-title">Tanggal Awal</h4>
                                                <input required name="tanggal_awal" type="date"
                                                    class="form-control form-control-primary" value="{{ @$filter['tanggal_awal'] }}">
                                            </div>
                                            <div class="col-sm-12 col-xl-{{ $grid }} col-md-{{ $grid }} ">
                                                <h4 class="sub-title">Tanggal Akhir</h4>
                                                <input required name="tanggal_akhir" type="date"
                                                    class="form-control form-control-primary" value="{{ @$filter['tanggal_akhir'] }}">
                                            </div>
                                            
                                            {{-- <input name="filter" value="true" style="display: none" /> --}}

                                            <div class="mt-3 col-sm-12 col-xl-2">
                                                {{-- <button type="submit" class="mt-4 btn btn-primary waves-effect waves-light">Filter</button> --}}
                                                <button class="mt-4 btn btn-primary waves-effect waves-light" type="submit" formmethod="get" formaction="{{ url('admin/home') }}">Filter</button>
                                                {{-- <button class="mt-4 btn btn-mat btn-success " formmethod="post" type="submit" formaction="{{ route('sapu-lobang.rekapitulasi') }}">Cetak Rekap Entry</button> --}}
                                            </div>
                                            
                                        </div>
                                    </form>
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
                <h4 class="card-title">Rekap Pekerjaan Pemeliharaan {{ @$filter['tanggal_awal'] }} - {{ @$filter['tanggal_akhir'] }}</h4>
                {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        {{-- <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li> --}}
                    </ul>
                </div>
            </div>
            <div class="card-block">
                
                <div class="chart has-fixed-height" id="chart_pemeliharaan" style="width: 800px; height: 600px;"></div>
                <div class="card-deck col-md-12">
                    <div class="card w-100">
                        {{-- <a href="{{ url('admin/lapor') }}"> --}}
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-warning f-w-600">
                                        {{ @$total_report['not_complete'] }}
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
                                        {{ @$total_report['submit'] }}
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
                                        {{ @$total_report['approve'] }}
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
                                        {{ @$total_report['reject'] }}
    
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
                                        {{ array_sum($total_report) }}
                                        
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
                <h4 class="card-title">Monitoring Lubang {{ @$filter['tanggal_awal'] }} - {{ @$filter['tanggal_akhir'] }}</h4>
                {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        {{-- <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li> --}}
                    </ul>
                </div>
            </div>
            <div class="card-block align-items-center justify-content-center">
                <div class="chart has-fixed-height" id="chart_lubang" style="width: 800px; height: 600px;"></div>
                <div class="row">
                    <div class="col-md-3 align-items-center justify-content-center my-auto">
                        <div class="card w-100 ">
                            {{-- <a href="{{ route('sapu-lobang.potensi') }}" target="_blank"> --}}
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-warning f-w-600">
                                            {{ @$temporari1['jumlah']['potensi'] }} Lubang
                                        </h4>
                                        <h6 class="text-muted m-b-0">{{ @$temporari1['panjang']['potensi'] }} Lubang</h6>
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
                                        <p class="text-white m-b-0">Potensi Lubang</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="feather icon-trending-up text-white f-16"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card-deck col-md-12">
                            <div class="card w-100">
                                {{-- <a href="{{ url('admin/input-data/sapu-lobang/data-lubang?status_filter=Dalam+Perencanaan') }}" target="_blank"> --}}
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h4 class="text-c-yellow f-w-600">
                                                {{ @$temporari['jumlah']['perencanaan'] }} Lubang
                                            </h4>
                                            <h6 class="text-muted m-b-0">{{ @$temporari['panjang']['perencanaan'] }} Km</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="feather icon-arrow-down f-28"></i>
                                        </div>
                                    </div>
                                </div>
                                {{-- </a> --}}
                                <div class="card-footer bg-c-yellow">
                                    <div class="row align-items-center">
                                        <div class="col-9">
                                            <p class="text-white m-b-0">Perencanaan</p>
                                        </div>
                                        <div class="col-3 text-right">
                                            <i class="feather icon-trending-up text-white f-16"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <div class="card w-100">
                                {{-- <a href="{{ url('admin/input-data/sapu-lobang/data-lubang?status_filter=Sudah+Ditangani') }}" target="_blank"> --}}
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h4 class="text-success f-w-600">
                                                {{ @$temporari['jumlah']['penanganan'] }} Lubang
                                            </h4>
                                            <h6 class="text-muted m-b-0">{{ @$temporari['panjang']['penanganan'] }} Km</h6>
            
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="feather icon-arrow-up f-28"></i>
                                        </div>
                                    </div>
                                </div>
                                {{-- </a> --}}
                                <div class="card-footer bg-success">
                                    <div class="row align-items-center">
                                        <div class="col-9">
                                            <p class="text-white m-b-0">Ditangani</p>
                                        </div>
                                        <div class="col-3 text-right">
                                            <i class="feather icon-trending-up text-white f-16"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <div class="card w-100">
                                {{-- <a href="{{ url('admin/input-data/sapu-lobang/data-lubang?status_filter=Belum+Ditangani') }}" target="_blank"> --}}
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h4 class="text-danger f-w-600">
                                                {{ @$temporari['jumlah']['sisa'] }} Lubang
            
                                            </h4>
                                            <h6 class="text-muted m-b-0">{{ @$temporari['panjang']['sisa'] }} Km</h6>
            
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
                                            <p class="text-white m-b-0">Sisa</p>
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
                                {{-- <a href="{{ route('sapu-lobang.lubang') }}" target="_blank"> --}}
    
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h4 class=" f-w-600">
                                                {{ array_sum($temporari['jumlah']) }} Lubang
                                                
                                            </h4>
                                            <h6 class="text-muted m-b-0">{{ array_sum($temporari['panjang']) }} Km</h6>
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
                                            <p class=" m-b-0" style="color: black">Total</p>
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
        </div>
    </div>
    @if (hasAccess(Auth::user()->internal_role_id, 'Daftar Laporan', 'View'))
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pengaduan</h4>
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
                        <a href="{{ url('admin/lapor') }}">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-primary f-w-600">
                                            @if(Auth::user()->internalRole->uptd == null)
                                            {{ count($submitted) }}
                                            @else
                                            {{ count($submitted_uptd) }}
                                            @endif
                                        </h4>
                                        {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-arrow-down f-28"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="card-footer bg-primary">
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
                        <a href="{{ url('admin/lapor') }}">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-blue f-w-600">
                                            @if(Auth::user()->internalRole->uptd == null)
                                            {{ count($approved) }}
                                            @else
                                            {{ count($approved_uptd) }}
                                            @endif
                                        </h4>
                                        {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-arrow-up f-28"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="card-footer bg-c-blue">
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
                        <a href="{{ url('admin/lapor') }}">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-yellow f-w-600">
                                            @if(Auth::user()->internalRole->uptd == null)
                                            {{ count($progress) }}
                                            @else
                                            {{ count($progress_uptd) }}
                                            @endif
                                        </h4>
                                        {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-clock f-28"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="card-footer bg-c-yellow">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">Progress</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card w-100">
                        <a href="{{ url('admin/lapor') }}">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-green f-w-600">
                                            @if(Auth::user()->internalRole->uptd == null)
                                            {{ count($done) }}
                                            @else
                                            {{ count($done_uptd) }}
                                            @endif
                                        </h4>
                                        {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-check-circle f-28"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="card-footer bg-c-green">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">Done</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-deck col-md-12">
                    <div class="card w-100">
                        <a href="{{ url('admin/lapor') }}">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-danger f-w-600">
                                            @if(Auth::user()->internalRole->uptd == null)
                                            {{ count($total_aduan) }}
                                            @else
                                            {{ count($total_aduan_uptd) }}
                                            @endif
                                        </h4>
                                        {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                                    </div>
                                    <div class="col-4 text-right">
                                        {{-- <i class="feather-archive"></i> --}}
                                        <i class="feather icon-clipboard f-28"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="card-footer bg-danger">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">Total Pengaduan</p>
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
    @endif

    <div class="col-sm-12">
        <div class="card">

            <div class="card-header">
                <h4>Pengumuman</h4>
                {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        {{-- {{-- <li><i class="feather icon-maximize full-card"></i></li> --}}
                        <li><i class="feather icon-minus minimize-card"></i></li> --}}
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <p>
                    <h6>
                        Panduan Penggunaan Teman Jabar : <a href="{{ url('admin/file') }}"
                            style="color: blue; font-weight: bold" target="_blank">File here</a>
                    </h6>
                </p>
                @foreach ($pengumuman_internal as $item)
                <div class="card w-100 mb-2">
                    <a href="{{ route('announcement.show', $item->slug) }}" target="_blank">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h6 class="card-title">{{ $item->title }}</h6>
                                    {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                                    <span style="color :grey; font-size: 10px;"><i class='icofont icofont-user'></i>
                                        {{ $item->nama_user }}|| <i class='icofont icofont-time'></i>
                                        {{ Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</span>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-arrow-down f-20"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
                {{ $pengumuman_internal->links() }}
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">&times;</span>
      
      </div>
      <div class="modal-body">
        <p>Some text in the Modal Body</p>
        <p>Some other text...</p>
      </div>
      
    </div>
  
</div>
  
@endsection

@section('script')
<script type="text/javascript">
            const uptd1 = @json($uptd1);
            const uptd2 = @json($uptd2);
            const uptd3 = @json($uptd3);
            const uptd4 = @json($uptd4);
            const uptd5 = @json($uptd5);
            const uptd6 = @json($uptd6);
</script>
<script type="text/javascript" src="{{ asset('assets/js/home.js') }}"></script>
<script>

    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 


    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    // window.onclick = function(event) {
    //   if (event.target == modal) {
    //     modal.style.display = "none";
    //   }
    // }


    function removeFirstWord(str) {
        const indexOfSpace = str.indexOf(' ');

        if (indexOfSpace === -1) {
            return '';
        }

        return str.substring(indexOfSpace + 1);
    }
    var data1 = {!! json_encode($data1) !!};
    var data2 = {!! json_encode($data2) !!};
    var data3 = {!! json_encode($data3) !!};
    var datauptd1 = {!! json_encode($datauptd1) !!};
    var datauptd2 = {!! json_encode($datauptd2) !!};
    var datauptdkota = {!! json_encode($datauptdkota) !!};
    var datauptdkabupaten = {!! json_encode($datauptdkabupaten) !!};
    var datakota = {!! json_encode($datakota) !!};

    console.log(datakota);
    
    var chartDom = document.getElementById('pie_basic');
    var myChart = echarts.init(chartDom);
    var option;

    option = {
    xAxis: [
        {
        type: 'category',
        // prettier-ignore
        data: datauptd1
        }
    ],
    yAxis: [
        {
        type: 'value'
        }
    ],
    dataGroupId: '',
    animationDurationUpdate: 500,

    tooltip: {
        trigger: 'axis',
        formatter: '{b}<br />{a0}: {c0}<br />{a1}: {c1}'
    },
    legend: {
        data: ['KOTA', 'KABUPATEN'],
        selected: {
        // selected'series 1'
        KOTA: true,
        // unselected'series 2'
        KABUPATEN: true
        }
    },
    toolbox: {
        show: true,
        feature: {
        dataView: { show: false, readOnly: false },
        magicType: { show: true, type: ['line', 'bar'] },
        restore: { show: true },
        saveAsImage: { show: true }
        }
    },
    calculable: true,

    series: [
        {
            name: 'KOTA',
            type: 'bar',
            id: 'sales',
            data: datauptdkota,
            universalTransition: {
                enabled: true,
                divideShape: 'clone'
            }
        },
        {
            name: 'KABUPATEN',
            type: 'bar',

            data: datauptdkabupaten,
            universalTransition: {
                enabled: true,
                divideShape: 'clone'
            }
        }
    ]
    };
    const drilldownData = datakota;
    myChart.on('click', function (event) {
        // console.log(event);
        // modal.style.display = "none";

        if (event.data) {
            var slug_kota ="";
            var subData = drilldownData.find(function (data) {
            return data.dataGroupId === event.data.groupId;
            });
            if (!subData) {
            return;
            }
            myChart.setOption({
                tooltip: {
                    trigger: 'item',
                    formatter: '{b}<br />{a0}: {c0}'
                },
                legend: {
                    data: ['RUAS'],
                    selected: {
                    // selected'series 1'
                    RUAS: true,
                    // unselected'series 2'
                    KABUPATEN: false
                    }
                },
                xAxis: {
                    data: subData.data
                    .map(function (item) {
                        return item[0];
                    })
                    .map(function (str) {
                        
                        if (str.split(' ').length > 2) {
                            str = removeFirstWord(str);
                        }
                        return str.replace(' ', '\n');
                    })
                },
                series: {
                    name: 'RUAS',
                    type: 'bar',
                    id: 'sales',
                    dataGroupId: subData.dataGroupId,
                    data: subData.data.map(function (item) {
                    return item[1];
                    }),
                    universalTransition: {
                    enabled: true,
                    divideShape: 'clone'
                    }
                },
                graphic: [
                    {
                    type: 'text',
                    left: 50,
                    top: 20,
                    style: {
                        text: 'BACK',
                        fontSize: 18
                    },
                    onclick: function () {
                        myChart.setOption(option);
                    }
                    }
                ]
            });
            // myChart.on('click', function(event) {
            // // Print name in console
            //     modal.style.display = "block";
            //     console.log(event.name);
            // });
        }
    });

    option && myChart.setOption(option);
</script>
<script>
    var library_uptd = {!! json_encode($datauptd1) !!};
    var data_not_complete = {!! json_encode($chart_pemeliharaan['not_complete']) !!};
    var data_submit = {!! json_encode($chart_pemeliharaan['submit']) !!};
    var data_approve = {!! json_encode($chart_pemeliharaan['approve']) !!};
    var data_reject = {!! json_encode($chart_pemeliharaan['reject']) !!};
    var chartDom = document.getElementById('chart_pemeliharaan');
    var myChart = echarts.init(chartDom);
    var option;

    option = {
        xAxis: {
            data: library_uptd
        },
        yAxis: [
            {
                type: 'value'
            }
        ],
        dataGroupId: '',
        animationDurationUpdate: 500,
        tooltip: {
            trigger: 'axis',
            // formatter: '{b}<br />{a0}: {c0} Km<br />{a1}: {c1} Km<br />{a2}: {c2} Km<br />{a3}: {c3} Km<br />{a4}: {c4} Km'
        },
        legend: {
            data: ['NOT COMPLETE', 'SUBMIT', 'APPROVE', 'REJECT']
        },
        toolbox: {
            show: true,
            feature: {
            dataView: { show: false, readOnly: false },
            magicType: { show: true, type: ['line', 'bar'] },
            restore: { show: true },
            saveAsImage: { show: true }
            }
        },
        calculable: true,

        series: [
            {
                name: 'NOT COMPLETE',
                type: 'bar',
                id: 'sales',
                itemStyle: {color: '#ffc107'},
                data: data_not_complete,
                universalTransition: {
                    enabled: true,
                    divideShape: 'clone'
                }
            },
            {
                name: 'SUBMIT',
                type: 'bar',
                itemStyle: {color: '#28a745'},

                data: data_submit,
                universalTransition: {
                    enabled: true,
                    divideShape: 'clone'
                }
            },
            {
                name: 'APPROVE',
                type: 'bar',

                data: data_approve,
                universalTransition: {
                    enabled: true,
                    divideShape: 'clone'
                }
            },
            {
                name: 'REJECT',
                type: 'bar',
                itemStyle: {color: '#dc3545'},

                data: data_reject,
                universalTransition: {
                    enabled: true,
                    divideShape: 'clone'
                }
            }
        ]
    };

    option && myChart.setOption(option);

</script>
<script>
    var library_uptd = {!! json_encode($datauptd1) !!};
    var data_sisa = {!! json_encode($chart_lubang['sisa']) !!};
    var data_perencanaan = {!! json_encode($chart_lubang['perencanaan']) !!};
    var data_penanganan = {!! json_encode($chart_lubang['ditangani']) !!};
    var data_potensi = {!! json_encode($chart_lubang['potensi']) !!};
    var data_total_km = {!! json_encode($chart_lubang['total_km']) !!};
    
    var chartDom = document.getElementById('chart_lubang');
    var myChart = echarts.init(chartDom);
    var option;
    
    option = {
        xAxis: {
            type: 'category',
            data: library_uptd
        },
        yAxis: [
            {
                type: 'value'
            }
        ],
        dataGroupId: '',
        animationDurationUpdate: 500,
        tooltip: {
            trigger: 'axis',
            // formatter: '{b}<br />{a0}: {c0} Km<br />{a1}: {c1} Km<br />{a2}: {c2} Km<br />{a3}: {c3} Km<br />{a4}: {c4} Km'
        },
        legend: {
            data: ['POTENSI', 'PERENCANAAN', 'DITANGANI', 'SISA','TOTAL KM'],
            selected: {
                
                POTENSI: true,
                PERENCANAAN: true,
                DITANGANI: true,
                SISA: true

            }
        },
        toolbox: {
            show: true,
            feature: {
            dataView: { show: false, readOnly: false },
            magicType: { show: true, type: ['line', 'bar'] },
            restore: { show: true },
            saveAsImage: { show: true }
            }
        },
        
        calculable: true,

        series: [
            {
                name: 'POTENSI',
                type: 'bar',
                id: 'sales',
                itemStyle: {color: '#ffc107'},
                data: data_potensi,
                universalTransition: {
                    enabled: true,
                    divideShape: 'clone'
                }
            },
            {
                name: 'PERENCANAAN',
                type: 'bar',
                itemStyle: {color: '#ffb64d'},

                data: data_perencanaan,
                universalTransition: {
                    enabled: true,
                    divideShape: 'clone'
                }
            },
            {
                name: 'DITANGANI',
                type: 'bar',
                itemStyle: {color: '#28a745'},

                data: data_penanganan,
                universalTransition: {
                    enabled: true,
                    divideShape: 'clone'
                }
            },
            {
                name: 'SISA',
                type: 'bar',
                itemStyle: {color: '#dc3545'},

                data: data_sisa,
                universalTransition: {
                    enabled: true,
                    divideShape: 'clone'
                }
            },
            {
                name: 'TOTAL KM',
                type: 'bar',
                
                data: data_total_km,
                universalTransition: {
                    enabled: true,
                    divideShape: 'clone'
                }
            }
        ]
    };
    option && myChart.setOption(option);

</script>
{{-- <script>
    function removeFirstWord(str) {
        const indexOfSpace = str.indexOf(' ');

        if (indexOfSpace === -1) {
            return '';
        }

        return str.substring(indexOfSpace + 1);
    }

    var data1 = {!! json_encode($data1) !!};
    var data2 = {!! json_encode($data2) !!};
    var data3 = {!! json_encode($data3) !!};
    var datauptd1 = {!! json_encode($datauptd1) !!};
    var datauptd2 = {!! json_encode($datauptd2) !!};
    var datakota = {!! json_encode($datakota) !!};

    console.log(datauptd1);
    console.log(datauptd2);
    console.log(datakota);
    
    var chartDom = document.getElementById('pie_basic');
    var myChart = echarts.init(chartDom);
    var option;

    option = {
        tooltip: {
            trigger: 'item',
            formatter: '{b} : {c} KOTA/KAB'
        },
        xAxis: {
            data: datauptd1
        },
        yAxis: {},
        
        animationDurationUpdate: 500,
        series: {
            type: 'bar',
            id: 'sales',
            data: datauptd2,
            universalTransition: {
            enabled: true,
            divideShape: 'clone'
            }
        }
        };
        const drilldownData = datakota;
        myChart.on('click', function (event) {
        if (event.data) {
            var subData = drilldownData.find(function (data) {
            return data.dataGroupId === event.data.groupId;
            });
            if (!subData) {
            return;
            }
            myChart.setOption({
                tooltip: {
                    trigger: 'item',
                    formatter: '{b} : {c} RUAS'
                },
                xAxis: {
                    data: subData.data.map(function (item) {
                    return item[0];
                    }).map(function (str) {
                        if(str.split(' ').length >2 ){
                            str = removeFirstWord(str)
                        }
                        return str.replace(' ', '\n');
                    })
                },
                series: {
                    
                    type: 'bar',
                    id: 'sales',
                    dataGroupId: subData.dataGroupId,
                    data: subData.data.map(function (item) {
                    return item[1];
                    }),
                    universalTransition: {
                    enabled: true,
                    divideShape: 'clone'
                    }
                },
                graphic: [
                    {
                    type: 'text',
                    left: 50,
                    top: 20,
                    style: {
                        text: 'Back',
                        fontSize: 18
                    },
                    onclick: function () {
                        myChart.setOption(option);
                    }
                    }
                ]
            });
        }
    });

    option && myChart.setOption(option);
</script> --}}

{{-- <script>
    var data1 = {!! json_encode($data1) !!};
    var data2 = {!! json_encode($data2) !!};
    var data3 = {!! json_encode($data3) !!};
    console.log(data1);
    console.log(data2);
    console.log(data3);

    var chartDom = document.getElementById('pie_basic');
    var myChart = echarts.init(chartDom);
    var option;

    option = {
    tooltip: {
        trigger: 'item',
        formatter: '{a} <br/>{b}: {c} ({d}%)'
    },
    legend: {
        data: data1
    },
    series: [
        {
        name: 'HUMLAH KOTA/KABUPATEN',
        type: 'pie',
        selectedMode: 'single',
        radius: [0, '30%'],
        label: {
            position: 'inner',
            fontSize: 14
        },
        labelLine: {
            show: false
        },
        data: data2
        },
        {
        name: 'JUMLAH RUAS',
        type: 'pie',
        radius: ['45%', '60%'],
        labelLine: {
            length: 30
        },
        label: {
            formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}  {per|{d}%}  ',
            backgroundColor: '#F6F8FC',
            borderColor: '#8C8D8E',
            borderWidth: 1,
            borderRadius: 4,
            rich: {
            a: {
                color: '#6E7079',
                lineHeight: 22,
                align: 'center'
            },
            hr: {
                borderColor: '#8C8D8E',
                width: '100%',
                borderWidth: 1,
                height: 0
            },
            b: {
                color: '#4C5058',
                fontSize: 14,
                fontWeight: 'bold',
                lineHeight: 33
            },
            per: {
                color: '#fff',
                backgroundColor: '#4C5058',
                padding: [3, 4],
                borderRadius: 4
            }
            }
        },
        data: data3
        }
    ]
    };

    option && myChart.setOption(option);
</script> --}}
@endsection
