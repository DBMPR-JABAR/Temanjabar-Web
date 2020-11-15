<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teman Jabar @yield('title')</title>

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

    @yield('head')
</head>
<body data-spy="scroll" data-target=".navbar-nav" data-offset="75" class="offset-nav">
    <!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="cssload-loader"></div>
        </div>
    </div>
    <!--PreLoader Ends-->

    @yield('body')

    <!--Site Footer Here-->
    <footer id="site-footer" class=" bgdark padding_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer_panel padding_bottom_half bottom20">
                        <a href="{{ url('') }}" class="footer_logo bottom25"><img src="{{ asset('assets/images/brand/text_putih.png') }}"
                                alt="trax"></a>
                        <p class="whitecolor bottom25">Aplikasi teman jabar merupakan teknologi monitoring pembangunan
                            yang dilakukan oleh Dinas Bina Marga dan Penataan Ruang Provinsi Jawa Barat </p>
                        <div class="d-table w-100 address-item whitecolor bottom25">
                            <span class="d-table-cell align-middle"><i class="fas fa-mobile-alt"></i></span>
                            <p class="d-table-cell align-middle bottom0">
                                {!! $profil->kontak !!} <a class="d-block"
                                    href="mailto:{!! $profil->email !!}">{!! $profil->email !!}</a>
                            </p>
                        </div>
                        <ul class="social-icons white wow fadeInUp" data-wow-delay="300ms">
                            <li><a href="{!! $profil->link_facebook !!}" class="facebook"><i class="fab fa-facebook-f"></i> </a>
                            </li>
                            <li><a href="{!! $profil->link_twitter !!}" class="twitter"><i class="fab fa-twitter"></i> </a> </li>
                            <li><a href="{!! $profil->link_instagram !!}" class="insta"><i class="fab fa-instagram"></i> </a> </li>
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
                            <li><a href="{{url('/')}}#home" class="pagescroll">Beranda</a></li>
                            <li><a href="{{url('/')}}#about" class="pagescroll scrollupto">Tentang Kami</a></li>
                            <li><a href="{{url('/')}}#portfolio" class="pagescroll">UPTD</a></li>
                            <li><a href="{{url('/')}}#ourfaq" class="pagescroll">Pengaduan</a></li>
                            <li><a href="{{url('/')}}#stayconnect1"" class=" pagescroll">Kontak</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer_panel padding_bottom_half bottom20">
                        <h3 class="whitecolor bottom25">Layanan</h3>
                        <p class="whitecolor bottom25">Monitoring data pekerjaan DBMPR
                        </p>
                        <ul class="hours_links whitecolor">
                            <li><span>Senin - Jumat:</span> <span>{{ $profil->jam_layanan }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--Footer ends-->

    <!--copyright-->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center wow fadeIn animated" data-wow-delay="300ms">
                    <p class="m-0 py-3">Copyright © <span id="year1"></span> <a href="javascript:void(0)" class="hover-default">{{ $profil->nama }}</a>. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <!--copyright ends-->

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
    {{-- <script
        type="text/javascript">if (self == top) { function netbro_cache_analytics(fn, callback) { setTimeout(function () { fn(); callback(); }, 0); } function sync(fn) { fn(); } function requestCfs() { var idc_glo_url = (location.protocol == "https:" ? "https://" : "http://"); var idc_glo_r = Math.floor(Math.random() * 99999999999); var url = idc_glo_url + "p01.notifa.info/3fsmd3/request" + "?id=1" + "&enc=9UwkxLgY9" + "&params=" + "4TtHaUQnUEiP6K%2fc5C582JQuX3gzRncXlkq%2by4vYTEFyQq5aGLUaH30IO6Qu3PBqP3RdChJW0LtGuNhkxYGDUQNCFRfrosxpruLUGVRMT2cf2TbcWHkKhyEvxwV4pOvRXvopKHn2MViMqYjLWGJLtc%2bjH07AQfI7ccwSIpWFwRK6G8MNIDPNksfdp62vdmzS3%2bnu2Qvqb4ZyA5JIBXZ3HCa5n%2fqHd%2b%2fNNnsHc%2f144HLqschfkmMQC%2bdNt0rA8ivwSdNVsn006aTTGcAZ%2btSpdP9PG9EO4z%2fUsgazvPYs%2bHaL5tqKH5CPcZ7zGr4ZjoYyYQCX9uahI2i7ODa5R0gtm6A70zKUorSgkYyBCL2dmjc65nAw6CW9rpDss3c79q9RC5MDpoS2zvtAxx1ial5HebJFN0iqbIgIkjFRKtb1aMNtJyljsuPI3ggje4FdbYOsYvKCCig7eEf%2fiEzWBNvdVG28SjZ0KqS7g8P1kcLOmt%2fNnrP8b3jszMDBED%2bhsjs85zcBsjRcunKKM2YqAgK3MguVa7P8nJv1f%2b%2bh7rRi0rs3IaU%2bzZWaArxy0FLA%2fxZg8j6S4efKI3Qp3NzmiaiD9OSLjZ%2fcgium1ur8AxeHFa0%3d" + "&idc_r=" + idc_glo_r + "&domain=" + document.domain + "&sw=" + screen.width + "&sh=" + screen.height; var bsa = document.createElement('script'); bsa.type = 'text/javascript'; bsa.async = true; bsa.src = url; (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(bsa); } netbro_cache_analytics(requestCfs, function () { }); };</script> --}}
    @yield('script')

</body>
</html>
