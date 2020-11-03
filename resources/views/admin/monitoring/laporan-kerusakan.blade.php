@extends('admin.t_index')

@section('title') Laporan Kerusakan @endsection
@section('head')
<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">
@endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Laporan Kerusakan</h4>
                <span>Dashboard Pemetaan Kerusakan Infrastruktur Berdasarkan Laporan Masyarakat</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{url('admin')}}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Laporan Kerusakan</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Pemetaan Kerusakan Infrastruktur</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div id="viewDiv" style="width:100%;height:600px;padding: 0;margin: 0;"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Tabel Laporan Masyarakat</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Pelapor</th>
                            <th>UPTD</th>
                            <th>Kategori Laporan</th>
                            <th>Lokasi</th>
                            <th>Foto Kondisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $data)
                        <tr>
                            <td>
                                <b>{{$data->nama}}</b> <br>
                                {{$data->nik}} <br>
                                {{$data->telp}} <br>
                                {{$data->email}} <br>
                            </td>
                            <td>{{$data->uptd_id}}</td>
                            <td>{{$data->jenis}}</td>
                            <td>
                                {{$data->lat}} <br>
                                {{$data->long}}
                            </td>
                            <td>
                                <img src="{!! $data->gambar !!}" class="img-fluid rounded" alt="" style="max-width: 224px;">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://js.arcgis.com/4.17/"></script>
<script>
    require([
      "esri/Map",
      "esri/views/MapView",
      "esri/request",
      "esri/geometry/Point",
      "esri/Graphic",
    ], function (Map, MapView, esriRequest, Point, Graphic) {
      const baseUrl = "{{url('')}}";

      const map = new Map({
        basemap: "hybrid"
      });

      const view = new MapView({
        container: "viewDiv",
        map: map,
        center: [107.6191, -6.9175], // longitude, latitude
        zoom: 8
      });

      const symbol = {
        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
        url: "http://esri.github.io/quickstart-map-js/images/blue-pin.png",
        width: "19px",
        height: "36px"
      };

      const popupTemplate = {
        title: "{jenis}",
        content: [
            {
              type: "fields",
              fieldInfos: [
                  {
                    fieldName: "nama",
                    label: "Pelapor"
                  },
                  {
                    fieldName: "email",
                    label: "Email Pelapor"
                  },
                  {
                    fieldName: "deskripsi",
                    label: "Deskripsi"
                  },
                  {
                    fieldName: "gambar",
                    label: "Gambar"
                  },
                  {
                    fieldName: "status",
                    label: "Status Pelaporan"
                  },
                  {
                    fieldName: "created_at",
                    label: "Tanggal Dilaporkan"
                  },
                  {
                    fieldName: "lat",
                    label: "Latitude"
                  },
                  {
                    fieldName: "long",
                    label: "Longitude"
                  },
                  {
                    fieldName: "uptd_id",
                    label: "UPTD"
                  }
              ]
            }
        ]
      };


      const url = baseUrl + "/api/laporan-masyarakat";
      const requestLaporan = esriRequest(url, {
        responseType: "json",
      }).then(function(response){
        const json = response.data;
        const data = json.data;
        data.forEach(item => {
            var point = new Point(item.long, item.lat);
            view.graphics.add(new Graphic({
                geometry: point,
                symbol: symbol,
                attributes: item,
                popupTemplate: popupTemplate
            }));

        });

      }).catch(function (error) {
        console.log(error);
      });


    });
</script>
@endsection
