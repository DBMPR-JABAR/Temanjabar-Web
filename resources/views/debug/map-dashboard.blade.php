<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>ArcGIS API for JavaScript Tutorials: Create a JavaScript starter app</title>
    <style>
        html,
        body,
        #viewDiv {
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%;
        }
    </style>
    <link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">
</head>
<body>
    <div id="viewDiv"></div>
</body>
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
        zoom: 8
      });

      const jembatanLayer = new GraphicsLayer();
      const progressLayer = new GraphicsLayer();

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

      const groupLayer = new GroupLayer();

      groupLayer.add(progressLayer);
      groupLayer.add(jembatanLayer);

      map.add(groupLayer);
    });
</script>
</html>
