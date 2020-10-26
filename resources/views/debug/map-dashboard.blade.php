<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/feather/css/feather.css') }}">
    <title>ArcGIS API for JavaScript Tutorials: Create a JavaScript starter app</title>
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
        #showFilter{
          position: absolute;
          top: 15%;
          left: 1.1%;
        }
        #showFilter button {
          width: 32px;
          height: 32px;
          background-color: white;
          border: none;
          cursor: pointer;
        }
        #filter {
          position: absolute;
          top: 15%;
          left: 1.1%;
          min-width: 300px;
          transform: translate(-350px, 0);
          transition: transform 0.3s ease-in-out;
        }
        #filter.open {
          transform: translate(0, 0);
        }
      #filter .container {
        padding: 20px 30px;
      }
    </style>
    <link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">
</head>
<body>
    <div id="viewDiv"></div>
    <div id="showFilter">
      <button data-toggle="tooltip" data-placement="right" title="Fitur Filter">
        <i class="feather icon-filter"></i>
      </button>
    </div>
    <div id="filter" class="bg-light">
        <div class="container">
          <form>
            <div class="form-group">
              <label for="exampleFormControlSelect1">UPTD</label>
              <select class="form-control" id="exampleFormControlSelect1">
                <option value="">Semua</option>
                <option value="uptd1">UPTD 1</option>
                <option value="uptd2">UPTD 2</option>
                <option value="uptd3">UPTD 3</option>
                <option value="uptd4">UPTD 4</option>
                <option value="uptd5">UPTD 5</option>
                <option value="uptd6">UPTD 6</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">SPP</label>
              <select class="form-control" id="exampleFormControlSelect1">
                <option value="opt1">-</option>
                <option value="opt2">SPP KAB/KOTA SMI-1</option>
                <option value="opt3">SPP KAB SMI-2</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Kegiatan</label>
              <select class="form-control" id="exampleFormControlSelect1">
                <option value="opt1">Semua</option>
                <option value="opt2">Ruas Jalam</option>
                <option value="opt2">Jembatan</option>
                <option value="pembangunan">Pemeliharaan</option>
                <option value="pembangunan">Peningkatan</option>
                <option value="pembangunan">Pembangunan</option>
                <option value="peningkatan">Peningkatan</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Proyek Kontrak</label>
              <select class="form-control" id="exampleFormControlSelect1">
                <option value="opt1">On-Progress</option>
                <option value="opt2">Critical Contract</option>
                <option value="opt2">Off Progress</option>
                <option value="pembangunan">Finish</option>
              </select>
            </div>
          </form>
        </div>
    </div>
</body>
<script>
  // tonggle filter
  const hamburgerButtonElement = document.querySelector("#showFilter");
  const drawerElement = document.querySelector("#filter");
  const mainElement = document.querySelector("#viewDiv");
  
  hamburgerButtonElement.addEventListener("click", event => {
  drawerElement.classList.toggle("open");
  event.stopPropagation();
  });
  
  
  mainElement.addEventListener("click", event => {
  drawerElement.classList.remove("open");
  event.stopPropagation();
  })
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://js.arcgis.com/4.17/"></script>
<script>
    require([
      "esri/Map",
      "esri/views/MapView",
      "esri/request",
      "esri/geometry/Point",
      "esri/Graphic",
      "esri/layers/GraphicsLayer",
      "esri/layers/GroupLayer"
    ], function (Map, MapView, esriRequest, Point, Graphic, GraphicsLayer, GroupLayer) {
      const map = new Map({
        basemap: "hybrid"
      });

      const view = new MapView({
        container: "viewDiv",
        map: map,
        center: [107.6191, -6.9175], // longitude, latitude
        zoom: 9
      });

      const jembatanLayer = new GraphicsLayer();
      const progressLayer = new GraphicsLayer();
      const kemandoranLayer = new GraphicsLayer();
      const peningkatanLayer = new GraphicsLayer();
      const rehabilitasiLayer = new GraphicsLayer();
      const pembangunanLayer = new GraphicsLayer();

      // Jembatan
      const urlJembatan = "http://localhost:8000/api/jembatan";
      const requestJembatan = esriRequest(urlJembatan, {
        responseType: "json"
      }).then(function (response) {

        var json = response.data;
        var data = json.data;

        var symbol = {
            type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
            url: "http://localhost:8000/assets/images/marker/jembatan.png",
            width: "32px",
            height: "32px"
        };
        var popupTemplate = {
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

        data.forEach(item => {
            var point = new Point(item.LNG, item.LAT);
            jembatanLayer.graphics.add(new Graphic({
                geometry: point,
                symbol: symbol,
                attributes: item,
                popupTemplate: popupTemplate
            }));
        });

      }).catch(function (error) {
        console.log(error);
      });

      // Progress Mingguan
      const urlProgress = "http://localhost:8000/api/progress-mingguan";
      const requestProgress = esriRequest(urlProgress, {
        responseType: "json",
      }).then(function(response){
        var json = response.data;
        var data = json.data;

        var symbol = {
            type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
            url: "http://localhost:8000/assets/images/marker/pembangunan.png",
            width: "32px",
            height: "32px"
        };
        var popupTemplate = {
            title: "{NAMA_PAKET}",
            content: [{
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
            ]}
        ]};

        data.forEach(item => {
            var point = new Point(item.LNG, item.LAT);
            progressLayer.graphics.add(new Graphic({
                geometry: point,
                symbol: symbol,
                attributes: item,
                popupTemplate: popupTemplate
            }));
        });
      }).catch(function (error) {
        console.log(error);
      });

      // Kemandoran --> Pemeliharaan
      const urlKemandoran = "http://localhost:8000/api/kemandoran/";
      const requestKemandoran = esriRequest(urlProgress, {
        responseType: "json",
      }).then(function(response){
        var json = response.data;
        var data = json.data;

        var symbol = {
            type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
            url: "http://localhost:8000/assets/images/marker/pemeliharaan.png",
            width: "32px",
            height: "32px"
        };
        var popupTemplate = {
            title: "{RUAS_JALAN}",
            content: [{
            type: "fields",
            fieldInfos: [
                {
                  fieldName: "TANGGAL",
                  label: "Tanggal"
                },
                {
                  fieldName: "PANJANG",
                  label: "Panjang"
                },
                {
                  fieldName: "JENIS_PEKERJAAN",
                  label: "Jenis Pekerjaan"
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
                  fieldName: "NAMA_MANDOR",
                  label: "Nama Mandor"
                },
                {
                  fieldName: "PERALATAN",
                  label: "Peralatan"
                },
                {
                  fieldName: "KET",
                  label: "Keterangan"
                },
                {
                  fieldName: "UPTD",
                  label: "UPTD"
                }
            ]}
        ]};

        data.forEach(item => {
            var point = new Point(item.LNG, item.LAT);
            kemandoranLayer.graphics.add(new Graphic({
                geometry: point,
                symbol: symbol,
                attributes: item,
                popupTemplate: popupTemplate
            }));
        });
      }).catch(function (error) {
        console.log(error);
      });

      // Pembangunan --> Peningkatan
      const urlPeningkatan = "http://localhost:8000/api/pembangunan/category/pn";
      const requestPeningkatan = esriRequest(urlPeningkatan, {
        responseType: "json",
      }).then(function(response){
        var json = response.data;
        var data = json.data;

        var symbol = {
            type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
            url: "http://localhost:8000/assets/images/marker/peningkatan.png",
            width: "32px",
            height: "32px"
        };
        var popupTemplate = {
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

        data.forEach(item => {
            var point = new Point(item.LNG, item.LAT);
            peningkatanLayer.graphics.add(new Graphic({
                geometry: point,
                symbol: symbol,
                attributes: item,
                popupTemplate: popupTemplate
            }));
        });
      }).catch(function (error) {
        console.log(error);
      });

      // Pembangunan --> Rehabilitasi
      const urlRehabilitasi = "http://localhost:8000/api/pembangunan/category/rb";
      const requestRehabilitasi = esriRequest(urlRehabilitasi, {
        responseType: "json",
      }).then(function(response){
        var json = response.data;
        var data = json.data;

        var symbol = {
            type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
            url: "http://localhost:8000/assets/images/marker/rehabilitasi.png",
            width: "32px",
            height: "32px"
        };
        var popupTemplate = {
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


        data.forEach(item => {
            var point = new Point(item.LNG, item.LAT);
            rehabilitasiLayer.graphics.add(new Graphic({
                geometry: point,
                symbol: symbol,
                attributes: item,
                popupTemplate: popupTemplate
            }));
        });
      }).catch(function (error) {
        console.log(error);
      });

      // Pembangunan --> Pembangunan
      const urlPembangunan = "http://localhost:8000/api/pembangunan/category/pb";
      const requestPembangunan = esriRequest(urlPembangunan, {
        responseType: "json",
      }).then(function(response){
        var json = response.data;
        var data = json.data;

        var symbol = {
            type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
            url: "http://localhost:8000/assets/images/marker/pembangunan.png",
            width: "32px",
            height: "32px"
        };
        var popupTemplate = {
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


        data.forEach(item => {
            var point = new Point(item.LNG, item.LAT);
            pembangunanLayer.graphics.add(new Graphic({
                geometry: point,
                symbol: symbol,
                attributes: item,
                popupTemplate: popupTemplate
            }));
        });
      }).catch(function (error) {
        console.log(error);
      });

      const groupLayer = new GroupLayer();

      groupLayer.add(progressLayer);
      groupLayer.add(jembatanLayer);
      groupLayer.add(kemandoranLayer);
      groupLayer.add(rehabilitasiLayer);
      groupLayer.add(peningkatanLayer)
      groupLayer.add(pembangunanLayer);

      map.add(groupLayer);
    });
</script>

</html>
