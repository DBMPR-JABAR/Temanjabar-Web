<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="icon" href="{{ asset('assets/images/favicon/favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/status_jalan.css') }}">
    <link rel="stylesheet" href="https://js.arcgis.com/4.19/esri/themes/light/main.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Status Jalan</title>
</head>

<body>
    <div id="logo">
        <img width="200" class="img-fluid" src="{{ asset('assets/images/brand/text_putih.png')}}" alt="Logo DBMPR">
    </div>
    <div id="maps_container"></div>
    <div id="feature_node" class="esri-widget overflow-auto">
        <div class="row g-3 w-100">
            <div class="col-12 col-sm-12 col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Status Jalan</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Informasi Posisi Anda</h6>
                        <p class="card-text">Latitude : <span id="latitude"></span> Longitude : <span
                                id="longitude"></span></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pekerjaan</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Lokasi pekerjaan terdekat</h6>
                        <div class="list-group" id="pekerjaan_list_container">
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
</script>
<script src="https://js.arcgis.com/4.19"></script>
<script>
    const baseUrl = "{{ url('/') }}";
    const geoServerUrl = "{{ env('GEOSERVER') }}";
</script>
<script type="text/javascript" src="{{ asset('assets/js/status_jalan.js') }}"></script>

</html>
