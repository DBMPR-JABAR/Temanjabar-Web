@extends('landing.template')

@section('title') | UPTD 1 @endsection

@section('body')

<section id="main-banner-page" class="position-relative page-header service-detail-header section-nav-smooth parallax">
    <div class="overlay overlay-dark opacity-7 z-index-1"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 offset-lg-2">
                <div class="page-titles whitecolor text-center padding_top padding_bottom">
                    <h2 class="font-xlight">UPTD</h2>
                    <h2 class="font-bold pb-4">Wilayah Pelayanan 1</h2>
                    <h3 class="text-capitalize font-xlight">WILAYAH KAB.CIANJUR-KOTA/KAB.BOGOR-KOTA DEPOK-KOTA/KAB.BEKASI</h3>
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
                                <h3 class="float-left">Wilayah Pelayanan 1</h3>
                                <ul class="breadcrumb top10 bottom10 float-right">
                                    <li class="breadcrumb-item hover-light"><a href="{{ url('') }}">Home</a></li>
                                    <li class="breadcrumb-item hover-light">Wilayah Pelayanan 1</li>
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
                                <body style="margin:0px;padding:0px">
                                    <iframe src="http://talikuat-bima-jabar.com/temanjabar/mob/uptd1/index.html" frameborder="0" style="display:block;height:100vh;width:100%" height="100%" width="100%"></iframe>
                                </body>
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

<!-- Contact US -->
<section id="stayconnect" class="bglight position-relative ">
    <div class="container">
        <div class="contactus-wrapp">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="heading-title wow fadeInUp text-center text-md-left" data-wow-delay="300ms">
                        <h3 class="darkcolor bottom20">Stay Connected</h3>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <form class="getin_form wow fadeInUp" data-wow-delay="400ms" onsubmit="return false;">
                        <div class="row">
                            <div class="col-md-12 col-sm-12" id="result"></div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="userName" class="d-none"></label>
                                    <input class="form-control" type="text" placeholder="First Name:" required id="userName" name="userName">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="companyName" class="d-none"></label>
                                    <input class="form-control" type="tel" placeholder="Company Name"  id="companyName" name="companyName">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="email" class="d-none"></label>
                                    <input class="form-control" type="email" placeholder="Email:" required id="email" name="email">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <button type="submit" class="button gradient-btn w-100" id="submit_btn">subscribe</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact US ends -->
@endsection
