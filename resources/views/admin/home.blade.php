@extends('admin.t_index')

@section('title') Admin Dashboard @endsection

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
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Widget</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')

<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8"><a href="kendali-kontrak/status/CRITICAL CONTRACT">
                        <h4 class="text-c-yellow f-w-600">{{ count($ruas_jalan_lists) }}</h4></a>
                        {{-- <h6 class="text-muted m-b-0">Critical Contract</h6> --}}
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-map f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-c-yellow">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">Ruas Jalan</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8"><a href="kendali-kontrak/status/ON PROGRESS">
                        <h4 class="text-c-green f-w-600">{{ count($jembatan_lists) }}</h4> </a>
                        {{-- <h6 class="text-muted m-b-0">On Progress</h6> --}}
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-file-text f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-c-green">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">Jembatan</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8"><a href="kendali-kontrak/status/FINISH">
                        <h4 class="text-c-blue f-w-600">{{ count($cctv_lists) }}</h4> </a>
                        {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-video f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-c-blue">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">CCTV</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8"><a href="kendali-kontrak/status/FINISH">
                        <h4 class="text-c-yellow f-w-600">{{ count($rawan_bencana_lists) }}</h4> </a>
                        {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-bar-chart f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-c-yellow">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">Rawan Bencana</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8"><a href="kendali-kontrak/status/FINISH">
                        <h4 class="text-c-blue f-w-600">{{ count($user_lists) }}</h4> </a>
                        {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-users f-28"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-c-blue">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="text-white m-b-0">Registered Users</p>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <div class="col-sm-12">
        <div class="card">
            
            <div class="card-header">
                <h5>Hello {{ Auth::user()->name }}</h5>
                {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <p>
                  
                </p>
            </div>
        </div>
    </div>
</div>
@endsection