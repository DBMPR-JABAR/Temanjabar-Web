<html>
    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="initial-scale=1, maximum-scale=1, user-scalable=no"
        />
        <title>Jalur Lebaran 2022</title>
        <link
            rel="stylesheet"
            href="https://js.arcgis.com/4.23/esri/themes/light/main.css"
        />
        <script src="https://js.arcgis.com/4.23/"></script>
        <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"
        ></script>

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
    </head>
    <body>
        <div id="viewDiv"></div>

        <script>
            const pathsJalurBawah = [];
            const pathsJalurAtas = [];
            const pathsJalurTengah = [];
            const pathsJalurTengah2 = [];

            $(document).ready(async () => {
                await fecthData();

                initMap();
            });

            const fecthData = () => {
                $.get(
                    "https://geo.temanjabar.net/geoserver/gsr/services/temanjabar/FeatureServer/18/query?f=json&outFields=*&spatialRel=esriSpatialRelIntersects&ak=9bea4cef-904d-4e00-adb2-6e1cf67b24ae",
                    () => {
                        console.log("success");
                    }
                )
                    .done(function (data) {
                        data.features.map((item) => {
                            item.geometry.paths[0].map((x) => {
                                pathsJalurBawah.push(x);
                            });
                        });
                    })
                    .catch((err) => {
                        console.log(err);
                    });
                $.get(
                    "https://geo.temanjabar.net/geoserver/gsr/services/temanjabar/FeatureServer/19/query?f=json&outFields=*&spatialRel=esriSpatialRelIntersects&ak=9bea4cef-904d-4e00-adb2-6e1cf67b24ae",
                    () => {
                        console.log("success");
                    }
                )
                    .done(function (data) {
                        data.features.map((item) => {
                            item.geometry.paths[0].map((x) => {
                                pathsJalurAtas.push(x);
                            });
                        });
                    })
                    .catch((err) => {
                        console.log(err);
                    });
                $.get(
                    "https://geo.temanjabar.net/geoserver/gsr/services/temanjabar/FeatureServer/20/query?f=json&outFields=*&spatialRel=esriSpatialRelIntersects&ak=9bea4cef-904d-4e00-adb2-6e1cf67b24ae",
                    () => {
                        console.log("success");
                    }
                )
                    .done(function (data) {
                        data.features.map((item) => {
                            item.geometry.paths[0].map((x) => {
                                pathsJalurTengah.push(x);
                            });
                            item.geometry.paths[1].map((x) => {
                                pathsJalurTengah2.push(x);
                            });
                        });
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            };
            function CreatePoint(lat, long, icon, name, desc) {
                this.point = {
                    type: "point",
                    longitude: long,
                    latitude: lat,
                };
                this.icon = {
                    type: "picture-marker",
                    url: icon,
                    width: "25px",
                    height: "45px",
                };
                this.attributes = {
                    name: name,
                    desc: desc,
                };
            }
            const arrPointLocation = [
                [-6.269999877121336, 107.26599012715761], //1 0
                [-6.291788838068766, 107.78322837657987], //2 1
                [-6.352005263529846, 108.10373646944174], // 3 2
                [-6.69835433387674, 108.55435431441458], //4 3
                [-6.476739728839751, 108.39558156451588], //5 4
                [-6.557086768676116, 107.83847128980116], // 6 5
                [-6.84127348528055, 107.48114107966775], // 7 pertama 6
                [-6.694662929646531, 106.96806140163143], //7 kedua 7
                [-6.835268160984563, 107.93023642473977], // 8 8
                [-6.73952424790597, 108.22943463380932], //9 9
                [-6.465334018947025, 107.06749064511875], //10 10
                [-7.164292819407282, 108.15289561840937], //11 pertama 11
                [-7.5451074504273725, 108.69379131444373], // 11 kedua 12
                [-7.121032745921966, 107.42497074326816], //12 13
                [-6.901354450942911, 106.8276386449612], //13 14
                [-7.015919264482259, 108.36566597250749], //14 15
                [-7.13131863365379, 106.62216934002693], //15 16
                [-7.408751438124379, 107.01378339015683], //16 17
                [-7.604037588298084, 107.64683589118455], //17 18
                [-7.77049604474206, 108.43338380339858], // 18 19
            ];

            const nameAndDesc = [
                {
                    name: "Jalan Lintas Utara",
                    desc: "Bekasi - Karawan ( Jalan Nasional )", //0
                },
                {
                    name: "Jalan Lintas Utara",
                    desc: "Karawang - Cikampek - Pamanukan ( Jalan Nasional )", // 1
                },
                {
                    name: "Jalan Lintas Utara",
                    desc: "Pamanukan - Lohbener - Palimanan", // 2
                },
                {
                    name: "Jalan Lintas Utara",
                    desc: "Lohbener - Indramayu - Cirebon ( Jalan Nasional )", // 3
                },
                {
                    name: "Jalan Lintas Utara",
                    desc: "Jatinangor - Karangampel ( Jalan Nasional )", // 4
                },
                {
                    name: "Jalan Lintas Tengah",
                    desc: "Sadang - Subang - Cikamurang - Cijelag ( Jalan Nasional )", // 5
                },
                {
                    name: "Jalan Lintas Tengah",
                    desc: "Ciawi/Bogor - Puncak - Cipanas - Cianjur - Bandung ( Jalan Nasional )", // 6
                },
                {
                    name: "Jalan Lintas Tengah",
                    desc: "Ciawi/Bogor - Puncak - Cipanas - Cianjur - Bandung ( Jalan Nasional )", // 7
                },
                {
                    name: "Jalan Lintas Tengah",
                    desc: "Bandung - Sumedang - Cijelag ( Jalan Nasional )", // 8
                },
                {
                    name: "Jalan Lintas Tengah",
                    desc: "Cijelag - Kadipaten - Palimanan - Cirebon ( Jalan Nasional )", // 9
                },
                {
                    name: "Jalan Lintas Tengah",
                    desc: "Cileungsi - Cibeet - Cibogo - Silajambe ( Jalan Nasional )", // 10
                },
                {
                    name: "Jalan Lintas Tengah",
                    desc: "Bandung - Nagreg - Tasikmalaya - Ciamis - Banjar - Pangandaran - Cirebon ( Jalan Provinsi )", // 11
                },
                {
                    name: "Jalan Lintas Tengah",
                    desc: "Bandung - Nagreg - Tasikmalaya - Ciamis - Banjar - Pangandaran - Cirebon ( Jalan Provinsi )", // 11
                },
                {
                    name: "Jalan Lintas Tengah",
                    desc: "Cikampek - Padalarang - Bandung - Ciwidey - Naringgul - Cidaun ( Jalan Nasiaonal Penghubung Lintas )",
                },
                {
                    name: "Jalan Lintas Tengah",
                    desc: "Bogor - Sukabumi - Cianjur ( Jalan Nasional )",
                },
                {
                    name: "Jalan Lintas Tengah",
                    desc: "Cirebon - Kuningan - Ciamis",
                },
                {
                    name: "Jalan Lintas Bawah",
                    desc: "Bts. Banten - Pelabuhan Ratu - Jampang Kulon - Tegalbuleud ( Jalan Nasional )",
                },
                {
                    name: "Jalan Lintas Bawah",
                    desc: "Tegalbuleud - Sindangbarang - Cidaun ( Jalan Nasional )",
                },
                {
                    name: "Jalan Lintas Bawah",
                    desc: "Cidaun - Pamengpeuk - Cipatujah ( Jalan Nasional )",
                },
                {
                    name: "Jalan Lintas Bawah",
                    desc: "Cipatujah - Kalapagenep - Pangandaran ( Jalan Nasional )",
                },
            ];
            const icon =
                "https://www.mapcustomizer.com/markers/51120e9b/png/default/";
        </script>
        <script>
            function initMap() {
                require([
                    "esri/config",
                    "esri/Map",
                    "esri/views/MapView",
                    "esri/widgets/BasemapToggle",
                    "esri/widgets/BasemapGallery",
                    "esri/Graphic",
                    "esri/layers/GraphicsLayer",
                ], function (
                    esriConfig,
                    Map,
                    MapView,
                    BasemapToggle,
                    BasemapGallery,
                    Graphic,
                    GraphicsLayer
                ) {
                    esriConfig.apiKey =
                        "AAPK2021e3c0ade243ac91fc03c5cc16af553UoLz7PP3cuznJsJw2hQOU6G-m47W2PWSfHujOs9JYI-UmZOtUw7TvgwWHUSIDPI";

                    const map = new Map({
                        basemap: "arcgis-imagery", // Basemap layer service
                    });
                    const dbmpr = [107.61, -6.921];
                    const view = new MapView({
                        map: map,
                        center: [107.619125, -6.917464], // Longitude, latitude
                        zoom: 9.5, // Zoom level
                        container: "viewDiv", // Div element
                    });
                    const basemapToggle = new BasemapToggle({
                        view: view,
                        nextBasemap: "hybrid",
                    });
                    view.ui.add(basemapToggle, "bottom-right");
                    // INIT END

                    const graphicsLayer = new GraphicsLayer();
                    map.add(graphicsLayer);

                    const polyline = {
                        type: "polyline",
                        paths: pathsJalurBawah,
                    };

                    const polylineGraphic = new Graphic({
                        geometry: polyline,
                        symbol: {
                            type: "simple-line",
                            color: [28, 230, 88],
                            width: 2,
                        },
                    });

                    graphicsLayer.add(polylineGraphic);

                    const polyline2 = {
                        type: "polyline",
                        paths: pathsJalurAtas,
                    };

                    const polylineGraphic2 = new Graphic({
                        geometry: polyline2,
                        symbol: {
                            type: "simple-line",
                            color: [247, 174, 15],
                            width: 2,
                        },
                    });

                    graphicsLayer.add(polylineGraphic2);

                    const polyline3 = {
                        type: "polyline",
                        paths: [...pathsJalurTengah, ...pathsJalurTengah2],
                    };

                    const polylineGraphic3 = new Graphic({
                        geometry: polyline3,
                        symbol: {
                            type: "simple-line",
                            color: [82, 14, 230],
                            width: 2,
                        },
                    });

                    graphicsLayer.add(polylineGraphic3);
                    var realIndex = 1;
                    const pointLocation = arrPointLocation.map(
                        (point, index) => {
                            if (index === 6 || index === 7) {
                                return {
                                    type: "point",
                                    x: point[1],
                                    y: point[0],
                                    name: nameAndDesc[index].name,
                                    desc: nameAndDesc[index].desc,
                                    icon: icon + 7,
                                };
                            } else if (index === 11 || index === 12) {
                                return {
                                    type: "point",
                                    x: point[1],
                                    y: point[0],
                                    name: nameAndDesc[index].name,
                                    desc: nameAndDesc[index].desc,
                                    icon: icon + 11,
                                };
                            } else {
                                return {
                                    type: "point",
                                    x: point[1],
                                    y: point[0],
                                    name: nameAndDesc[index].name,
                                    desc: nameAndDesc[index].desc,
                                    icon: icon + (index + 1),
                                };
                            }
                        }
                    );

                    const pointGraphic = pointLocation.map((point, index) => {
                        return new Graphic({
                            geometry: point,
                            symbol: {
                                type: "picture-marker",
                                url: point.icon,
                                width: "25px",
                                height: "45px",
                            },
                            popupTemplate: {
                                title: point.name,
                                content: point.desc,
                            },
                        });
                    });

                    graphicsLayer.addMany(pointGraphic);
                });
            }
        </script>
    </body>
</html>
