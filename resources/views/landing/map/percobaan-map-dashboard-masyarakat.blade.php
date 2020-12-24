@extends('landing.template')
@section('body')
<style>
        html,
        body,
        #viewDiv {
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%;
            z-index: -1;
        }

        #showFilter {
            position: absolute;
            top: 15px;
            right: 15px;
        }

        #showFilter button {
            width: 32px;
            height: 32px;
            background-color: white;
            border: none;
            outline: none;
            cursor: pointer;
        }

        #filter {
            position: fixed;
            padding: 20px;
            top: 15px;
            right: 55px;
            width: 300px;
            max-height: 500px;
            overflow-y: scroll;
            transform: translate(1200px, 0);
            transition: transform 0.3s ease-in-out;
        }

        #filter.open {
            transform: translate(0, 0);
        }

        #filter .form-group>* {
            font-size: 13px;
            margin: 0px;
        }

        #logo {
            display: block;
            position: absolute;
            top: 30px;
            right: 80px;
        }

        #showBaseMaps {
            position: absolute;
            top: 47.5px;
            right: 15px;
        }

        #showBaseMaps button {
            width: 32px;
            height: 32px;
            background-color: white;
            border: none;
            outline: none;
            cursor: pointer;
        }

        #fullscreen {
            position: absolute;
            top: 81px;
            right: 15px;
        }

        #fullscreen button {
            width: 32px;
            height: 32px;
            background-color: white;
            border: none;
            outline: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 1px;
        }

        #back {
            position: absolute;
            top: 114px;
            right: 15px;
        }

        #back button {
            width: 32px;
            height: 32px;
            background-color: white;
            border: none;
            outline: none;
            cursor: pointer;
        }

        #baseMaps {
            position: fixed;
            padding: 15px;
            top: 15px;
            right: 55px;
            width: 320px;
            max-height: 500px;
            transform: translate(1200px, 0);
            transition: transform 0.3s ease-in-out;
            overflow-y: scroll;
        }

        #baseMaps.open {
            transform: translate(0, 0);
        }

        #baseMaps .listMaps ul.row {
            display: flex;
        }

        #baseMaps .listMaps ul li {
            padding: 0;
            margin: 5px;
            list-style: none;
        }

        #baseMaps .listMaps ul li button {
            border: 1px solid #222;
            padding: 0;
        }

        #baseMaps .listMaps ul li button:hover {
            border: 3px solid green;
        }

        #baseMaps .listMaps ul li button:focus {
            border: 3px solid green;
        }

        #baseMaps .listMaps ul li img {
            display: block;
            width: 84px;
            max-height: 56px;
            background-position: center;
            object-fit: cover;
        }
    </style>
<!--Page Header-->
<section id="main-banner-page" class="position-relative page-header about-header parallax section-nav-smooth">
    <div class="overlay overlay-dark opacity-7"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">

            </div>
        </div>
        <div class="gradient-bg title-wrap">
            <div class="row">
                <div class="col-lg-12 col-md-12 whitecolor">
                    <h3 class="float-left">MAP DBMPR</h3>
                    <ul class="breadcrumb top10 bottom10 float-right">
                        <li class="breadcrumb-item hover-light"><a href="index.html">Beranda</a></li>
                        <li class="breadcrumb-item hover-light">map-dashboard-masyarakat</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Page Header ends -->

@endsection