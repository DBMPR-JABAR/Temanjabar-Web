@extends('landing.template')
@section('body')
<script type="text/javascript">
var datanya = [
        {
                     "lat_long": '{"polyline":[[-6.943040,106.912361],[-6.932560,106.902359]]}',
             "keterangan": 'Rehabilitasi Jalan Ruas Jl. Lingkar Sukabumi (Cibolang - Pelabuhan II) '
        },
            {
                     "lat_long": '{"polyline":[[-6.940440, 106.948509],[-6.944250,106.944000]]}',
             "keterangan": 'Rehabilitasi  Jalan  (Baros - Jl. Pembangunan )'
        },
            {
                     "lat_long": '{"polyline":[[-7.340470,106.566582],[-7.350370,106.553848]]}',
             "keterangan": 'Paket Pekerjaan Peningkatan Jalan Ruas Jalan Sp. Surade - Ujunggenteng '
        },
            {
                     "lat_long": '{"polyline":[[-6.861000,106.449303],[-6.854190,106.445061]]}',
             "keterangan": 'Paket Pekerjaan Peningkatan Jalan Ruas Jalan Sp. Karanghawu - Bts.Prop.Banten'
        },
            {
                     "lat_long": '{"polyline":[[-6.875320,106.764664],[-6.871570,106.746132]]}',
             "keterangan": 'Paket Pekerjaan Peningkatan Jalan Ruas Jalan Cibadak - Cikidang - Pelabuhan Ratu '
        },
            {
                     "lat_long": '{"polyline":[[-7.001380,106.797089],[-7.005040,106.796623]]}',
             "keterangan": 'Paket Pekerjaan Peningkatan Jalan Ruas Jalan  Jampang Tengah - Kiaradua'
        },
            {
                     "lat_long": '{"polyline":[[-6.986660,106.791298],[-6.993950,106.802170]]}',
             "keterangan": 'Paket Pekerjaan Peningkatan Jalan Ruas Jalan  Cikembar - Jampang Tengah '
        },
            {
                     "lat_long": '{"polyline":[[-7.218986,106.885674],[-7.365940,106.880463]]}',
             "keterangan": 'Paket Pekerjaan Peningkatan Jalan JL Gudang (Sagaranten)'
        },
            {
                     "lat_long": '{"polyline":[[-7.365741,106.819283],[-7.365940,106.819496]]}',
             "keterangan": 'Paket Pekerjaan Peningkatan Jalan Ruas Jalan Sagaranten - Tegalbuleud'
        },
            {
                     "lat_long": '{"polyline":[[-6.969434,106.949104],[-6.969945,106.953598]]}',
             "keterangan": 'Paket Pekerjaan Peningkatan Jalan Ruas Jalan Sukabumi (Baros) - Sagaranten'
        },
            {
                     "lat_long": '{"polyline":[[-7.143099,107.561165],[-7.153396,107.559906]]}',
             "keterangan": 'Rehabilitasi Jalan Banjaran - Pangalengan'
        },
            {
                     "lat_long": '{"polyline":[[-7.143115,107.561066],[-7.153393,107.559921]]}',
             "keterangan": 'Rehabilitasi Jalan Banjaran - Pangalengan'
        },
            {
                     "lat_long": '{"polyline":[[-6.892629,107.536720],[-6.902807,107.535217]]}',
             "keterangan": 'Rehabilitasi Jalan Jl. Baros (Cimahi)'
        },
            {
                     "lat_long": '{"polyline":[[-6.936882,107.622810],[-6.947962,107.633369]]}',
             "keterangan": 'Rehabilitasi Jalan Jl. Buah Batu (Sp. 4 Pelajar Pejuang 45 - Sp. 4 Soekarno Hatta)'
        },
            {
                     "lat_long": '{"polyline":[[-6.937547,107.606224],[-6.948336,107.609375]]}',
             "keterangan": 'Rehabilitasi Jalan Jl. Moh. Toha (Sp. Jl. BKR - Bts. Kota/Kab. Bandung)'
        },
            {
                     "lat_long": '{"polyline":[[-6.912338,107.598038],[-6.906583,107.597740]]}',
             "keterangan": 'Rehabilitasi Jalan Jl. Pasirkaliki (Sp. Kebonkawung - Sp. Pajajaran) Kota Bandung'
        },
            {
                     "lat_long": '{"polyline":[[-7.060727,107.829468],[-7.060571,107.848724]]}',
             "keterangan": 'Rehabilitasi Jalan Majalaya (Sp. 3 Jl. Cikareo/Jl. Tengah) - Sawahbera (Sp. 3 Cijapati) - Bts. Bdg/Garut (Cijapati) (2,50 Km)'
        },
            {
                     "lat_long": '{"polyline":[[-6.818608,107.538567],[-6.827386,107.524139]]}',
             "keterangan": 'Rehabilitasi Jalan Padalarang (Sp. 3 Stasion) - Sp. Cisarua'
        },
            {
                     "lat_long": '{"polyline":[[-6.454417],[107.808899],[-6.457461,107.812073]]}',
             "keterangan": 'Rehabilitasi Jalan Pagaden - Subang'
        },
            {
                     "lat_long": '{"polyline":[[-6.678854,107.691498],[-6.687009,107.712433]]}',
             "keterangan": 'Paket Pekerjaan Peningkatan Jalan Jl. Cagak - Bts. Subang/Sumedang (Cikaramas)'
        },
            {
                     "lat_long": '{"polyline":[[-6.783556,107.650742],[-6.773948,107.636192]]}',
             "keterangan": 'Paket Pekerjaan Peningkatan Jalan Lembang - Bts. Kab. Bandung Kab. Subang'
        },
            {
                     "lat_long": '{"polyline":[[-6.734358,107.386795],[-6.735753,107.415146]]}',
             "keterangan": 'Paket Pekerjaan Peningkatan Jalan Rajamandala - Cipeundeuy - Cikalongwetan'
        },
            ];
        </script>
    
        <script>
          var customLabel = {
            restaurant: {
              label: 'R'
            },
            bar: {
              label: 'B'
            }
          };
    
            function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
              center: new google.maps.LatLng(-6.921475,107.610538),
              zoom: 10
            });
            var infoWindow = new google.maps.InfoWindow;
    //----------------
                for (i = 0; i < datanya.length; i++) {
                    var data = datanya[i];
                    var temp = data.lat_long;
                    var ket = data.keterangan;
                    var hasil = eval('(' + temp + ')');
                    var pathnya = [];
                    
                    for(var j=0;j < hasil.polyline.length;j++){
                        pathnya[j] = {'lat':hasil.polyline[j][0],'lng':hasil.polyline[j][1]};
                        var LatLng = new google.maps.LatLng(pathnya[j].lat,pathnya[j].lng);
                    
                        var marker = new google.maps.Marker({
                                position: LatLng,
                               // icon: null, //'http://www.busindia.com/images/cab_icon.png', // null = default icon
                                map: map,
                                title: ket,
                                animation: google.maps.Animation.BOUNCE
                            });
                        
                        
                        
                    };
                    
                    
                    
                    polylinenya = new google.maps.Polyline({
                        path: pathnya,
                        geodesic: true,
                        strokeOpacity: 1.0,
                        strokeWeight: 2
                    });
    
                    polylinenya.setMap(map);
                          /*  var marker = new google.maps.Marker({
                                position: LatLng,
                                icon: null, //'http://www.busindia.com/images/cab_icon.png', // null = default icon
                                map: map,
                                title: ket
                            });*/
                
                }
    //--------------
              // Change this depending on the name of your PHP or XML file
            }

          function doNothing() {}
        </script>
        
        <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBSpJ4v4aOY7DEg4QAIwcSFCXljmPJFUg&callback=initMap">
        </script>

<!--PreLoader-->
<div class="loader">
    <div class="loader-inner">
        <div class="cssload-loader"></div>
    </div>
</div>
<!--PreLoader Ends-->
<!-- header -->

<!--Page Header-->
<section id="main-banner-page" class="position-relative page-header service-detail-header section-nav-smooth parallax">
    <div class="overlay overlay-dark opacity-7 z-index-1"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="page-titles whitecolor text-center padding_top padding_bottom">
                    <h2 class="font-xlight">Pemetaan</h2>
                    <h2 class="font-bold">Paket Pekerjaan</h2>
                </div>
            </div>
        </div>
        <div class="gradient-bg title-wrap">
            <div class="row">
                <div class="col-lg-12 col-md-12 whitecolor">
                    <h3 class="float-left">Paket Pekerjaan</h3>
                    <ul class="breadcrumb top10 bottom10 float-right">
                        <li class="breadcrumb-item hover-light"><a href="{{ url('')}}">Home</a></li>
                        <li class="breadcrumb-item hover-light">Paket Pekerjaan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Page Header ends -->
<br>
<!-- Services us -->
<main class="container-fluid bglight">
    <!-- content -->
    <section id="content" class="row">
        <div id="features" class="col-lg-3">

            <div class="container-fluid">
                <div class="row whitebox top15">
                    <<div class="col-lg-12 col-md-12">
                        <div class="image widget bottom20"><img alt="temanjabar" src="{{ asset('assets/images/brand/text_hitam.png') }}"></div>
                        <div class="widget heading_space text-center text-md-left">
                            <h4 class="text-capitalize darkcolor bottom20">Lapor?</h4>
                            <div class="contact-table colorone d-table bottom15">
                                <div class="d-table-cell cells">
                                    <span class="icon-cell"><i class="fas fa-mobile-alt"></i></span>
                                </div>
                                <div class="d-table-cell cells">
                                    <p class="bottom0">+92-0900-10072 <span class="d-block">+92-0900-10072</span></p>
                                </div>
                            </div>
                            <div class="contact-table colorone d-table bottom15 text-left">
                                <div class="d-table-cell cells">
                                    <span class="icon-cell"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <div class="d-table-cell cells">
                                    <p class="bottom0">Jl. Asia Afrika,
                                        <span class="d-block">Bandung</span>
                                    </p>
                                </div>
                            </div>
                            <div class="contact-table colorone d-table text-left">
                                <div class="d-table-cell cells">
                                    <span class="icon-cell"><i class="far fa-clock"></i></span>
                                </div>
                                <div class="d-table-cell cells">
                                    <p class="bottom0">Mon to Sat - 9:00am to 6:00pm
                                        <span class="d-block">Sunday: Closed</span>
                                    </p>
                                </div>
                            </div>
                            <a href="index.html" class="button btnsecondary gradient-btn top30"> Form Lapor</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div id="wrapper" class="col-lg-9">
            <!-- Services us -->
            <section id="our-services" class="pt-5 bglight">
                <div class="container">
                    <div class="row whitebox top15">
                        
                        <div class="col-lg-12 col-md-12">
                            <div class="widget heading_space text-center text-md-left">
                                <h3 class="darkcolor font-normal bottom15">Paket Pekerjaan</h3>
                                <p class="bottom30">Berikut merupakan pemetaan dari paket pekerjaan projek pembangunan infrasutruktur yang sudah dikerjakan oleh DBMPR.</p>
                                <div class="col-12 px-0">
                                    <div class="w-100">
                                        <div class="full-map short-map" id="map"></div>
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
@endsection