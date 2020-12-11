@extends('landing.template')

@section('title') | {{$uptd->nama}} @endsection

@section('head')
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/docsupport/style.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/docsupport/prism.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/chosen.css') }}">
<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">
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
        <div id="features" class="col-lg-4">

            <div class="container-fluid">
                <div class="row whitebox top30">
                    <div class="col-lg-12 col-md-12">
                        <div class="widget heading_space text-center text-md-left">
                            <div class="sidebar-header mb-4 text-center">
                                <img src="{{asset('assets/images/brand/jabar.png')}}">
                                <h3>{{$uptd->nama}}</h3>
                                <h6>{{$uptd->altnama}}</h6>
                            </div>
                            <div id="filter" class="bg-light">
                                <div class="container">
                                <div id="preloader" style="display:none">Loading...</div>
                                    <form>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="kegiatan">UPTD</label>
                                                </div>
                                                <div class="col-12">
                                                    <select data-placeholder="Pilih UPTD" multiple class="chosen-select chosen-select-uptd w-100" id="uptd">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="uptdSpp">SPP / SUP</label>
                                                </div>
                                                <div class="col-12">
                                                    <select id="spp_filter" data-placeholder="Pilih UPTD dengan SPP"  class="chosen-select w-100" multiple tabindex="6">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="kegiatan">Kegiatan</label>
                                                </div>
                                                <div class="col-12">
                                                    <select data-placeholder="Pilih kegiatan" multiple class="chosen-select w-100" tabindex="8" id="kegiatan">
                                                        <option value="ruasjalan">Ruas Jalan</option>
                                                        <option value="pembangunan">Pembangunan</option>
                                                        <option value="peningkatan">Peningkatan</option>
                                                        <option value="rehabilitasi">Rehabilitasi</option>
                                                        <option value="jembatan">Jembatan</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="basemap">Basemap</label>
                                                </div>
                                                <div class="col-12">
                                                    <select data-placeholder="Basemap..." class="chosen-select form-control" id="basemap" tabindex="-1">
                                                        <option value="streets">Street</option>
                                                        <option value="hybrid" selected>Hybrid</option>
                                                        <option value="satellite">Satelite</option>
                                                        <option value="topo">Topo</option>
                                                        <option value="gray">Gray</option>
                                                        <option value="national-geographic">National Geographic</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="exampleFormControlSelect1">Zoom</label>
                                                </div>
                                                <div class="col-12">
                                                    <select class="chosen-select form-control" id="zoom">
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8" selected>8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                    </select>
                                                </div>
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
        <div id="wrapper" class="col-lg-8">
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
                                        <div class="full-map short-map" id="viewDiv" style="max-height: 567px"></div>
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
@section('script')
<script src="https://js.arcgis.com/4.17/"></script>

<script type="text/javascript" src="{{ asset('assets/vendor/chosen_v1.8.7/chosen.jquery.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/chosen_v1.8.7/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
<script>
    function fillSUP(uptd){
        return new Promise(function (resolve, reject) {
            $.ajax({
                type:"POST",
                url: "{{ route('api.supdata') }}",
                data: {uptd:uptd},
                success: function(response){
                    $("#spp_filter").empty();
                    let len = ''; let spp = '';
                    if(response['data'] != null){
                        len = response['data']['uptd'];
                        spp = response['data']['spp'];
                    }
                    if(len.length > 0){
                        // Read data and create <option>
                        let select = '';
                        for(let i=0; i<len.length; i++){
                            select += '<optgroup label='+len[i]+'>' ;
                            select +='';
                            for(let j=0; j<spp.length; j++){
                                if(len[i] == spp[j].UPTD) {
                                    select +='<option value="'+spp[j].SUP+'" selected>'+spp[j].SUP+'</option>';
                                }
                            }
                            select +='</optgroup>';
                        }

                        $('#spp_filter').html(select).trigger('liszt:updated');
                        $('#spp_filter').trigger("chosen:updated");
                        // $('#spp_filter .chosen-select').append("<li id='spp_filter" + id + "' class='active-result' style>" +name+ "</li>");
                    }
                    $("#preloader").hide();
                    return resolve($("#spp_filter").val());
                }
            });
        });
    }
    async function getSUPData() {
        const uptd =   $("#uptd").val();
        let data = [];
        $("#preloader").show();
        // getMapData(uptd,basemap);
        // option = "";
        if (uptd.length == 0){
            $("#spp_filter").empty();
            $('#spp_filter').trigger("chosen:updated");
        }else{
            data = await fillSUP(uptd);
        }
        return data;
    }
    function initFilter(){
        $("#uptd").empty();
        const slug = `{{ $uptd->slug }}`;
        select = `<option value="${slug}">UPTD ${slug.replace('uptd','')}</option>`;

        $('#uptd').html(select).trigger('liszt:updated');
        $('#uptd').trigger("chosen:updated");

        $("#spp_filter").empty();
        $('#spp_filter').trigger("chosen:updated");

        $("#kegiatan").empty();
        kegiatan = `<option value="ruasjalan">Ruas Jalan</option>
                    <option value="pembangunan">Pembangunan</option>
                    <option value="peningkatan">Peningkatan</option>
                    <option value="rehabilitasi">Rehabilitasi</option>
                    <option value="pemeliharaan">Pemeliharaan</option>
                    <option value="vehiclecounting">Vehicle Counting</option>
                    <option value="jembatan">Jembatan</option>`;
        $('#kegiatan').html(kegiatan).trigger('liszt:updated');
        $('#kegiatan').trigger("chosen:updated");

        $("#proyek").empty();
        proyek = `<option value="onprogress">On-Progress</option>
                    <option value="criticalprogress">Critical Contract</option>
                    <option value="offprogress">Off Progress</option>
                    <option value="finishprogress">Finish</option>`;
        $('#proyek').html(proyek).trigger('liszt:updated');
        $('#proyek').trigger("chosen:updated");

    }
    function difference(array1, array2) {
        let result = [];
        for (let i = 0; i < array1.length; i++) {
            if (array2.indexOf(array1[i]) === -1) {
                result.push(array1[i]);
            }
        }
        return result;
    }

    $(document).ready(function () {
        initFilter();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : { allow_single_deselect: true },
            '.chosen-select-no-single' : { disable_search_threshold: 10 },
            '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
            '.chosen-select-rtl'       : { rtl: true },
            '.chosen-select-width'     : { width: '95%' }
        };
        for (let selector in config) {
            $(selector).chosen(config[selector]);
        }

        $("#spp_filter, #kegiatan").chosen().change(function(){
            const sup = $("#spp_filter").val();
            const kegiatan = $("#kegiatan").val();
            kegiatan.push("progressmingguan");
            getMapData(sup, kegiatan);
        });

        $("#uptd").chosen().change(async function(){
            const sup = await getSUPData();
            const kegiatan = $("#kegiatan").val();
            kegiatan.push("progressmingguan");
            getMapData(sup, kegiatan);
        });

        function getMapData(sup, kegiatan) {
            require([
                "esri/Map",
                "esri/views/MapView",
                "esri/request",
                "esri/geometry/Point",
                "esri/Graphic",
                "esri/layers/GraphicsLayer",
                "esri/layers/GroupLayer",
                "esri/tasks/RouteTask",
                "esri/tasks/support/RouteParameters",
                "esri/tasks/support/FeatureSet"
            ], function (Map, MapView, esriRequest, Point, Graphic, GraphicsLayer,
                        GroupLayer, RouteTask, RouteParameters, FeatureSet) {

                // Map Initialization
                const baseUrl = "{{url('/')}}";
                const map = new Map({
                    basemap: "hybrid"
                });
                const view = new MapView({
                    container: "viewDiv",
                    map: map,
                    center: [107.6191, -6.9175], // longitude, latitude
                    zoom: 8
                });

                // Layering
                let ruteLayer = new GraphicsLayer();
                let ruasjalanLayer = new GraphicsLayer();
                let jembatanLayer = new GraphicsLayer();
                let pembangunanLayer = new GraphicsLayer();
                let peningkatanLayer = new GraphicsLayer();
                let rehabilitasiLayer = new GraphicsLayer();
                let pemeliharaanLayer = new GraphicsLayer();
                let progressLayer = new GraphicsLayer();
                let vehiclecountingLayer = new GraphicsLayer();
                let allProgressLayer = new GroupLayer();

                // Request API
                const requestUrl = baseUrl + '/api/map/dashboard/data';
                const requestBody = new FormData();
                for (i in kegiatan) { requestBody.append("kegiatan[]",kegiatan[i]); }
                for (i in sup) { requestBody.append("sup[]",sup[i]); }

                const requestApi = esriRequest(requestUrl, {
                    responseType: "json",
                    method: "post",
                    body: requestBody
                }).then(function (response) {
                    const json = response.data;
                    const data = json.data;
                    if(json.status === "success"){
                        ruasjalanLayer = addRuasJalan(data.ruasjalan, ruasjalanLayer);
                        pembangunanLayer = addPembangunan(data.pembangunan, pembangunanLayer);
                        peningkatanLayer = addPeningkatan(data.peningkatan, peningkatanLayer);
                        rehabilitasiLayer = addRehabilitasi(data.rehabilitasi, rehabilitasiLayer);
                        jembatanLayer = addJembatan(data.jembatan, jembatanLayer);
                        pemeliharaanLayer = addPemeliharaan(data.pemeliharaan, pemeliharaanLayer);
                        vehiclecountingLayer = addVehicleCounting(data.vehiclecounting, vehiclecountingLayer);

                        allProgressLayer = addProgressGroup(data.progressmingguan);
                        map.add(allProgressLayer);

                        $("#proyek").chosen().change(function() {
                            const proyek = $("#proyek").val();
                            const allProyek = ["onprogress","criticalprogress","offprogress","finishprogress"];
                            const diff = difference(allProyek, proyek);

                            for(i in proyek){
                                allProgressLayer.findLayerById(proyek[i]).visible = true;
                            }
                            for(i in diff){
                                allProgressLayer.findLayerById(diff[i]).visible = false;
                            }
                        });
                    }
                }).catch(function(error){
                    console.log(error);
                });



                // Creating Group Layer
                const groupLayer = new GroupLayer();
                groupLayer.add(jembatanLayer);
                groupLayer.add(ruasjalanLayer);
                groupLayer.add(pemeliharaanLayer);
                groupLayer.add(pembangunanLayer);
                groupLayer.add(peningkatanLayer);
                groupLayer.add(rehabilitasiLayer);
                groupLayer.add(vehiclecountingLayer);
                map.add(groupLayer);


                $("#basemap").change(function(){
                    const basemap = this.value;
                    map.basemap = basemap;
                });
                $("#zoom").change(function(){
                    const zoom = this.value;
                    view.zoom = zoom;
                });


                function addPembangunan(pembangunan, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/pembangunan.png",
                        width: "28px",
                        height: "28px"
                    };
                    const popupTemplate = {
                        title: "{NAMA_PAKET}",
                        content: [{
                        type: "fields",
                        fieldInfos: [
                            {
                                fieldName: "NOMOR_KONTRAK",
                                label: "Nomor Kontrak"
                            },
                            {
                                fieldName: "TGL_KONTRAK",
                                label: "Tanggal Kontrak"
                            },
                            {
                                fieldName: "WAKTU_PELAKSANAAN_HK",
                                label: "Waktu Kontrak (Hari Kerja)"
                            },
                            {
                                fieldName: "KEGIATAN",
                                label: "Jenis Pekerjaan"
                            },
                            {
                                fieldName: "JENIS_PENANGANAN",
                                label: "Jenis Penanganan"
                            },
                            {
                                fieldName: "RUAS_JALAN",
                                label: "Ruas Jalan"
                            },
                            {
                                fieldName: "LAT",
                                label: "Latitude"
                            },
                            {
                                fieldName: "LNG",
                                label: "Longitude"
                            },
                            {
                                fieldName: "LOKASI",
                                label: "Lokasi"
                            },
                            {
                                fieldName: "SUP",
                                label: "SUP"
                            },
                            {
                                fieldName: "NILAI_KONTRAK",
                                label: "Nilai Kontrak"
                            },
                            {
                                fieldName: "PAGU_ANGGARAN",
                                label: "Pagu Anggaran"
                            },
                            {
                                fieldName: "PENYEDIA_JASA",
                                label: "Penyedia Jasa"
                            },
                            {
                                fieldName: "UPTD",
                                label: "UPTD"
                            }
                        ]}
                    ]};
                    pembangunan.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                    return layer;
                }
                function addPeningkatan(peningkatan, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/peningkatan.png",
                        width: "28px",
                        height: "28px"
                    };
                    const popupTemplate = {
                        title: "{NAMA_PAKET}",
                        content: [{
                        type: "fields",
                        fieldInfos: [
                            {
                                fieldName: "NOMOR_KONTRAK",
                                label: "Nomor Kontrak"
                            },
                            {
                                fieldName: "TGL_KONTRAK",
                                label: "Tanggal Kontrak"
                            },
                            {
                                fieldName: "WAKTU_PELAKSANAAN_HK",
                                label: "Waktu Kontrak (Hari Kerja)"
                            },
                            {
                                fieldName: "KEGIATAN",
                                label: "Jenis Pekerjaan"
                            },
                            {
                                fieldName: "JENIS_PENANGANAN",
                                label: "Jenis Penanganan"
                            },
                            {
                                fieldName: "RUAS_JALAN",
                                label: "Ruas Jalan"
                            },
                            {
                                fieldName: "LAT",
                                label: "Latitude"
                            },
                            {
                                fieldName: "LNG",
                                label: "Longitude"
                            },
                            {
                                fieldName: "LOKASI",
                                label: "Lokasi"
                            },
                            {
                                fieldName: "SUP",
                                label: "SUP"
                            },
                            {
                                fieldName: "NILAI_KONTRAK",
                                label: "Nilai Kontrak"
                            },
                            {
                                fieldName: "PAGU_ANGGARAN",
                                label: "Pagu Anggaran"
                            },
                            {
                                fieldName: "PENYEDIA_JASA",
                                label: "Penyedia Jasa"
                            },
                            {
                                fieldName: "UPTD",
                                label: "UPTD"
                            }
                        ]}
                    ]};
                    peningkatan.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                        console.log("PEMBANGAN");
                    });
                    return layer;
                }
                function addRehabilitasi(rehabilitasi, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/rehabilitasi.png",
                        width: "32px",
                        height: "32px"
                    };
                    const popupTemplate = {
                        title: "{NAMA_PAKET}",
                        content: [{
                        type: "fields",
                        fieldInfos: [
                            {
                                fieldName: "NOMOR_KONTRAK",
                                label: "Nomor Kontrak"
                            },
                            {
                                fieldName: "TGL_KONTRAK",
                                label: "Tanggal Kontrak"
                            },
                            {
                                fieldName: "WAKTU_PELAKSANAAN_HK",
                                label: "Waktu Kontrak (Hari Kerja)"
                            },
                            {
                                fieldName: "KEGIATAN",
                                label: "Jenis Pekerjaan"
                            },
                            {
                                fieldName: "JENIS_PENANGANAN",
                                label: "Jenis Penanganan"
                            },
                            {
                                fieldName: "RUAS_JALAN",
                                label: "Ruas Jalan"
                            },
                            {
                                fieldName: "LAT",
                                label: "Latitude"
                            },
                            {
                                fieldName: "LNG",
                                label: "Longitude"
                            },
                            {
                                fieldName: "LOKASI",
                                label: "Lokasi"
                            },
                            {
                                fieldName: "SUP",
                                label: "SUP"
                            },
                            {
                                fieldName: "NILAI_KONTRAK",
                                label: "Nilai Kontrak"
                            },
                            {
                                fieldName: "PAGU_ANGGARAN",
                                label: "Pagu Anggaran"
                            },
                            {
                                fieldName: "PENYEDIA_JASA",
                                label: "Penyedia Jasa"
                            },
                            {
                                fieldName: "UPTD",
                                label: "UPTD"
                            }
                        ]}
                    ]};
                    rehabilitasi.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                    return layer;
                }
                function addJembatan(jembatan, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/jembatan.png",
                        width: "24px",
                        height: "24px"
                    };
                    const popupTemplate = {
                        title: "{NAMA_JEMBATAN}",
                        content: [{
                        type: "fields",
                        fieldInfos: [
                            {
                                fieldName: "PANJANG",
                                label: "Panjang"
                            },
                            {
                                fieldName: "LEBAR",
                                label: "Lebar"
                            },
                            {
                                fieldName: "RUAS_JALAN",
                                label: "Ruas Jalan"
                            },
                            {
                                fieldName: "LAT",
                                label: "Latitude"
                            },
                            {
                                fieldName: "LNG",
                                label: "Longitude"
                            },
                            {
                                fieldName: "LOKASI",
                                label: "Lokasi"
                            },
                            {
                                fieldName: "SUP",
                                label: "SUP"
                            },
                            {
                                fieldName: "UPTD",
                                label: "UPTD"
                            }
                        ]}
                    ]};
                    jembatan.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                    return layer;
                }
                function addPemeliharaan(pemeliharaan, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/pemeliharaan.png",
                        width: "28px",
                        height: "28px"
                    };
                    const popupTemplate = {
                        title: "{RUAS_JALAN}",
                        content: [{
                        type: "fields",
                        fieldInfos: [
                            {
                                fieldName: "TANGGAL",
                                label: "Tanggal"
                            },
                            {
                                fieldName: "JENIS_PEKERJAAN",
                                label: "Jenis Pekerjaan"
                            },
                            {
                                fieldName: "NAMA_MANDOR",
                                label: "Nama Mandor"
                            },
                            {
                                fieldName: "PANJANG",
                                label: "Panjang "
                            },
                            {
                                fieldName: "PERALATAN",
                                label: "Peralatan"
                            },
                            {
                                fieldName: "LAT",
                                label: "Latitude"
                            },
                            {
                                fieldName: "LNG",
                                label: "Longitude"
                            },
                            {
                                fieldName: "LOKASI",
                                label: "Lokasi"
                            },
                            {
                                fieldName: "SUP",
                                label: "SUP"
                            },
                            {
                                fieldName: "UPTD",
                                label: "UPTD"
                            }
                        ]}
                    ]};
                    pemeliharaan.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                    return layer;
                }
                function addRuasJalan(ruasjalan, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/jalan.png",
                        width: "28px",
                        height: "28px"
                    };
                    const popupTemplate = {
                        title: "{NAMA_JALAN}",
                        content: [{
                        type: "fields",
                        fieldInfos: [
                            {
                                fieldName: "LAT_AWAL",
                                label: "Latitude 0"
                            },
                            {
                                fieldName: "LONG_AWAL",
                                label: "Longitude 0"
                            },
                            {
                                fieldName: "LAT_AKHIR",
                                label: "Latitude 1"
                            },
                            {
                                fieldName: "LONG_AKHIR",
                                label: "Longitude 1"
                            },
                            {
                                fieldName: "SUP",
                                label: "SUP"
                            },
                            {
                                fieldName: "UPTD",
                                label: "UPTD"
                            }
                        ]}
                    ]};
                    ruasjalan.forEach(item => {
                        let point = new Point(item.LONG_AWAL, item.LAT_AWAL);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));

                        point = new Point(item.LONG_AKHIR, item.LAT_AKHIR);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                    return layer;
                }
                function addProgressGroup(progress) {
                    const layerGroup = new GroupLayer();
                    const onProgress = new GraphicsLayer({id: "onprogress", visible: false});
                    const offProgress = new GraphicsLayer({id: "offprogress", visible: false});
                    const criticalProgress = new GraphicsLayer({id: "criticalprogress", visible: false});
                    const finishProgress = new GraphicsLayer({id: "finishprogress", visible: false});

                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/pembangunan.png",
                        width: "24px",
                        height: "24px"
                    };
                    const popupTemplate = {
                        title: "{NAMA_PAKET}",
                        content: [
                            {
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "TANGGAL",
                                    label: "Tanggal"
                                },
                                {
                                    fieldName: "WAKTU_KONTRAK",
                                    label: "Waktu Kontrak"
                                },
                                {
                                    fieldName: "TERPAKAI",
                                    label: "Terpakai"
                                },
                                {
                                    fieldName: "JENIS_PEKERJAAN",
                                    label: "Jenis Pekerjaan"
                                },
                                {
                                    fieldName: "RUAS_JALAN",
                                    label: "Ruas Jalan"
                                },
                                {
                                    fieldName: "LAT",
                                    label: "Latitude"
                                },
                                {
                                    fieldName: "LNG",
                                    label: "Longitude"
                                },
                                {
                                    fieldName: "LOKASI",
                                    label: "Lokasi"
                                },
                                {
                                    fieldName: "SUP",
                                    label: "SUP"
                                },
                                {
                                    fieldName: "RENCANA",
                                    label: "Rencana"
                                },
                                {
                                    fieldName: "REALISASI",
                                    label: "Realisasi"
                                },
                                {
                                    fieldName: "DEVIASI",
                                    label: "Deviasi"
                                },
                                {
                                    fieldName: "NILAI_KONTRAK",
                                    label: "Nilai Kontrak"
                                },
                                {
                                    fieldName: "PENYEDIA_JASA",
                                    label: "Penyedia Jasa"
                                },
                                {
                                    fieldName: "KEGIATAN",
                                    label: "Kegiatan"
                                },
                                {
                                    fieldName: "STATUS_PROYEK",
                                    label: "Status"
                                },
                                {
                                    fieldName: "UPTD",
                                    label: "UPTD"
                                }
                            ]
                            }
                        ]
                    };
                    progress.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        switch(item.STATUS_PROYEK){
                            case "ON PROGRESS":
                                onProgress.graphics.add(new Graphic({
                                    geometry: point,
                                    symbol: symbol,
                                    attributes: item,
                                    popupTemplate: popupTemplate
                                }));
                                break;
                            case "CRITICAL CONTRACT":
                                criticalProgress.graphics.add(new Graphic({
                                    geometry: point,
                                    symbol: symbol,
                                    attributes: item,
                                    popupTemplate: popupTemplate
                                }));
                                break;
                            case "OFF PROGRESS":
                                offProgress.graphics.add(new Graphic({
                                    geometry: point,
                                    symbol: symbol,
                                    attributes: item,
                                    popupTemplate: popupTemplate
                                }));
                                break;
                            case "FINISH":
                                finishProgress.graphics.add(new Graphic({
                                    geometry: point,
                                    symbol: symbol,
                                    attributes: item,
                                    popupTemplate: popupTemplate
                                }));
                                break;
                            default:
                                break;
                        }
                    });

                    layerGroup.add(onProgress);
                    layerGroup.add(offProgress);
                    layerGroup.add(criticalProgress);
                    layerGroup.add(finishProgress);

                    return layerGroup;
                }
                function addProgress(progress, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/pembangunan.png",
                        width: "24px",
                        height: "24px"
                    };
                    const popupTemplate = {
                        title: "{NAMA_PAKET}",
                        content: [
                            {
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "TANGGAL",
                                    label: "Tanggal"
                                },
                                {
                                    fieldName: "WAKTU_KONTRAK",
                                    label: "Waktu Kontrak"
                                },
                                {
                                    fieldName: "TERPAKAI",
                                    label: "Terpakai"
                                },
                                {
                                    fieldName: "JENIS_PEKERJAAN",
                                    label: "Jenis Pekerjaan"
                                },
                                {
                                    fieldName: "RUAS_JALAN",
                                    label: "Ruas Jalan"
                                },
                                {
                                    fieldName: "LAT",
                                    label: "Latitude"
                                },
                                {
                                    fieldName: "LNG",
                                    label: "Longitude"
                                },
                                {
                                    fieldName: "LOKASI",
                                    label: "Lokasi"
                                },
                                {
                                    fieldName: "SUP",
                                    label: "SUP"
                                },
                                {
                                    fieldName: "RENCANA",
                                    label: "Rencana"
                                },
                                {
                                    fieldName: "REALISASI",
                                    label: "Realisasi"
                                },
                                {
                                    fieldName: "DEVIASI",
                                    label: "Deviasi"
                                },
                                {
                                    fieldName: "NILAI_KONTRAK",
                                    label: "Nilai Kontrak"
                                },
                                {
                                    fieldName: "PENYEDIA_JASA",
                                    label: "Penyedia Jasa"
                                },
                                {
                                    fieldName: "KEGIATAN",
                                    label: "Kegiatan"
                                },
                                {
                                    fieldName: "STATUS_PROYEK",
                                    label: "Status"
                                },
                                {
                                    fieldName: "UPTD",
                                    label: "UPTD"
                                }
                            ]
                            }
                        ]
                    };
                    progress.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                    return layer;
                }
                function addVehicleCounting(vehiclecounting, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/vehiclecounting.png",
                        width: "24px",
                        height: "24px"
                    };
                    const popupTemplate = {
                        title: "{RUAS_JALAN}",
                        content: [
                            {
                                type: "fields",
                                fieldInfos: [
                                    {
                                        fieldName: "LAT",
                                        label: "Latitude"
                                    },
                                    {
                                        fieldName: "LONG",
                                        label: "Longitude"
                                    },
                                    {
                                        fieldName: "JUMLAH_MOBIL",
                                        label: "Jumlah Mobil"
                                    },
                                    {
                                        fieldName: "JUMLAH_MOTOR",
                                        label: "Jumlah Motor"
                                    },
                                    {
                                        fieldName: "JUMLAH_BIS",
                                        label: "Jumlah Bis"
                                    },
                                    {
                                        fieldName: "JUMLAH_TRUK_BOX",
                                        label: "Jumlah Truk Box"
                                    },
                                    {
                                        fieldName: "JUMLAH_TRUK_TRAILER",
                                        label: "Jumlah Truk Trailer"
                                    },
                                    {
                                        fieldName: "SUP",
                                        label: "SUP"
                                    },
                                    {
                                        fieldName: "UPTD",
                                        label: "UPTD"
                                    },
                                    {
                                        fieldName: "CREATED_AT",
                                        label: "Terakhir Diperbarui"
                                    },
                                ]
                            },
                            {
                                type: "media",
                                mediaInfos: [
                                    {
                                        title: "<b>Foto Aktual</b>",
                                        type: "image",
                                        caption: "{CREATED_AT}",
                                        value: {
                                        sourceURL:
                                            "{GAMBAR}"
                                        }
                                    }
                                ]
                            }
                        ]
                    };
                    vehiclecounting.forEach(item => {
                        let point = new Point(item.LONG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                    return layer;
                }

            });

        }

        getMapData("","");
    });
</script>
@endsection
