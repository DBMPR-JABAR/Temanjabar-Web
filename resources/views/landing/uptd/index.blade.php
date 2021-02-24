@extends('landing.template')

@section('title') | {{$uptd->nama}} @endsection

@section('head')
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/docsupport/style.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/docsupport/prism.css') }}"> --}}
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('body')

<section id="main-banner-page" class="position-relative page-header service-detail-header section-nav-smooth parallax">
    <div class="overlay overlay-dark opacity-7 z-index-1"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 offset-lg-2">
                <div class="page-titles whitecolor text-center padding_top padding_bottom">
                    <h2 class="font-xlight">UPTD</h2>
                    <h2 class="font-bold pb-4">{{$uptd->altnama}}</h2>
                    <h3 class="text-capitalize font-xlight">{{$uptd->deskripsi}}</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Page Header ends -->

<!-- main -->
<main class="container-fluid bglight">
    <!-- content -->
    <section id="content" class="row">
        <div id="wrapper" class="col-lg-12">
            <!--Page Header-->
            <section id="main-banner-page" class="pb-4 position-relative page-header service-detail-header section-nav-smooth parallax">
                <div class="container">
                    <div class="gradient-bg title-wrap">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 whitecolor">
                                <h3 class="float-left">{{$uptd->altnama}}</h3>
                                <ul class="breadcrumb top10 bottom10 float-right">
                                    <li class="breadcrumb-item hover-light"><a href="{{url('')}}">Home</a></li>
                                    <li class="breadcrumb-item hover-light">{{$uptd->altnama}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--Page Header ends -->

            <!-- Services us -->
            <section id="our-services" class="pt-5 bglight">
                <div class="container">
                    <div class="row whitebox top15">
                        <div class="col-lg-12 col-md-12">
                            <div class="widget heading_space text-center text-md-left">
                                <h3 class="darkcolor font-normal bottom15">DBMPR</h3>
                                <p class="bottom30">Sistem Pengendalian Jalan dan Jembatan Dinas Bina Marga dan Penataan Ruang (DBMPR) merupakan sebuah aplikasi WebGIS yang dikembangkan sebagai media pelaporan dan penyampaian informasi spasial pembangunan infrastruktur DBMPR.</p>
                                <div class="col-12 px-0">
                                    <div class="w-100">
                                        <iframe src="{{ route('landing.map.map-dashboard-uptd', $uptd->id) }}" frameborder="0" style="width: 100%; height: 600px"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Services us ends -->
        </div>
    </div>
    <!-- content ends -->

</main>
<!-- main ends -->
@endsection

