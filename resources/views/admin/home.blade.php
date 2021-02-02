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
                <li class="breadcrumb-item"><a href="#!">Home</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
@php
  if (hasAccess(Auth::user()->internal_role_id, "User", "View")) {
     $number = 4;
  }else{
    $number = 6;
  }  
@endphp
<div class="row">
    <div class="col-xl-{{ $number }} col-md-6">
        <div class="card">
            <a href="{{ url('admin/master-data/ruas-jalan') }}">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-yellow f-w-600">
                            @if(Auth::user()->internalRole->uptd == null)
                                {{ count($ruas_jalan_lists) }}
                            @else
                                {{ count($ruas_jalan_lists_uptd) }}
                            @endif
                        </h4>
                        {{-- <h6 class="text-muted m-b-0">Critical Contract</h6> --}}
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-map f-28"></i>
                    </div>
                </div>
            </div>
            </a>
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
    <div class="col-xl-{{ $number }} col-md-6">
        <div class="card">
            <a href="{{ url('admin/master-data/jembatan') }}">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-green f-w-600">
                            @if(Auth::user()->internalRole->uptd == null)
                            {{ count($jembatan_lists) }}
                            @else
                            {{ count($jembatan_lists_uptd) }}
                            @endif
                        
                        </h4> 
                        {{-- <h6 class="text-muted m-b-0">On Progress</h6> --}}
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-file-text f-28"></i>
                    </div>
                </div>
            </div>
            </a>
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
    <div class="col-xl-{{ $number }} col-md-12 col-sm-12">
        <div class="card">
            <a href="{{ url('admin/master-data/CCTV') }}">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-blue f-w-600">
                            @if(Auth::user()->internalRole->uptd == null)
                                {{ count($cctv_lists) }}
                            @else
                                {{ count($cctv_lists_uptd) }}
                            @endif
                        </h4> 
                        {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-video f-28"></i>
                    </div>
                </div>
            </div>
            </a>
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
            <a href="{{ url('admin/master-data/rawanbencana') }}">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-yellow f-w-600">
                            @if(Auth::user()->internalRole->uptd == null)
                                {{ count($rawan_bencana_lists) }}
                            @else
                                {{ count($rawan_bencana_lists_uptd) }}
                            @endif
                        </h4> 
                        {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-bar-chart f-28"></i>
                    </div>
                </div>
            </div>
            </a>
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
    @if (hasAccess(Auth::user()->internal_role_id, "User", "View"))
        <div class="col-xl-6 col-md-12">
            <div class="card">
                <a href="{{ route('getMasterUser') }}">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-blue f-w-600">{{ count($user_lists) }}</h4>
                            {{-- <h6 class="text-muted m-b-0">Finish</h6> --}}
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-users f-28"></i>
                        </div>
                    </div>
                </div>
                </a>
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
    @endif

    

    <div class="col-sm-12">
        <div class="card">
            
            <div class="card-header">
                {{-- <h5>Selamat Datang {{ Auth::user()->name }}</h5> --}}
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
                    <h6>
                        Panduan Penggunaan Teman Jabar : <a href="https://drive.google.com/file/d/1-X-WGW_u3SO-oSjXhxUDWBOFJ9wqzfOR/view?usp=sharing" style="color: blue; font-weight: bold" target="_blank">File here</a>
                    </h6>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection