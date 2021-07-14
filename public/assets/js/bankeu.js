$("#mapLatLong")
    .ready(() => {
        require(["esri/Map",
            "esri/views/MapView",
            "esri/Graphic",
            "esri/views/draw/Draw",
            "esri/geometry/geometryEngine",
            "esri/widgets/BasemapToggle",
            "esri/geometry/SpatialReference",
            "esri/geometry/support/webMercatorUtils"
        ], function(
            Map,
            MapView,
            Graphic,
            Draw,
            geometryEngine,
            BasemapToggle,
            SpatialReference,
            webMercatorUtils
        ) {

            const map = new Map({
                basemap: "osm",
            });

            const view = new MapView({
                container: "mapLatLong",
                map,
                center: [107.6191, -6.9175],
                zoom: 9,
                // spatialReference: {
                //     wkid: 4326
                // }
                // spatialReference: {
                //     wkid: 4326
                // }

            });


            const toggle = new BasemapToggle({
                view,
                nextBasemap: "hybrid",
            });

            view.ui.add(toggle, 'top-right');



            const draw = new Draw({
                view: view
            });

            let gambarManual
            const drawMode = () => {
                    gambarManual = document.createElement("div")
                    gambarManual.className = 'esri-widget esri-widget--button esri-interactive'
                    gambarManual.title = "Draw polyline"
                    gambarManual.innerHTML = '<span class="esri-icon-polyline"></span>'

                    view.ui.add(gambarManual, "top-left");
                    gambarManual.onclick = () => {
                        view.graphics.removeAll();
                        const action = draw.create("polyline");
                        view.focus();
                        action.on(
                            [
                                "vertex-add",
                                "vertex-remove",
                                "cursor-update",
                                "redo",
                                "undo",
                                "draw-complete"
                            ],
                            updateVertices
                        );
                    };
                }
                // drawMode();

            const geoJson = document.getElementById('geo_json')

            const updateVertices = (event) => {

                if (event.vertices.length > 1) {
                    const result = createGraphic(event);
                    if (result.selfIntersects) {
                        event.preventDefault();
                    }
                }
            }

            const createGraphic = (event) => {
                const vertices = event.vertices;
                view.graphics.removeAll();

                const graphic = new Graphic({
                    geometry: {
                        type: "polyline",
                        paths: vertices,
                        spatialReference: view.spatialReference
                    },
                    symbol: {
                        type: "simple-line",
                        color: [255, 0, 0],
                        width: 4,
                        cap: "round",
                        join: "round"
                    }
                });

                const { paths } = webMercatorUtils.webMercatorToGeographic(graphic.geometry)
                geoJson.value = JSON.stringify(paths)
                const intersectingSegment = getIntersectingSegment(graphic.geometry);

                if (intersectingSegment) {
                    view.graphics.addMany([graphic, intersectingSegment]);
                } else {
                    view.graphics.add(graphic);
                }

                return {
                    selfIntersects: intersectingSegment
                };
            }

            const isSelfIntersecting = (polyline) => {
                if (polyline.paths[0].length < 3) {
                    return false;
                }
                const line = polyline.clone();

                const lastSegment = getLastSegment(polyline);
                line.removePoint(0, line.paths[0].length - 1);

                return geometryEngine.crosses(lastSegment, line);
            }

            const getIntersectingSegment = (polyline) => {
                if (isSelfIntersecting(polyline)) {
                    return new Graphic({
                        geometry: getLastSegment(polyline),
                        symbol: {
                            type: "simple-line",
                            style: "short-dot",
                            width: 3.5,
                            color: "yellow"
                        }
                    });
                }
                return null;
            }

            const getLastSegment = (polyline) => {
                const line = polyline.clone();
                const lastXYPoint = line.removePoint(0, line.paths[0].length - 1);
                const existingLineFinalPoint = line.getPoint(
                    0,
                    line.paths[0].length - 1
                );

                return {
                    type: "polyline",
                    spatialReference: view.spatialReference,
                    hasZ: false,
                    paths: [
                        [
                            [existingLineFinalPoint.x, existingLineFinalPoint.y],
                            [lastXYPoint.x, lastXYPoint.y]
                        ]
                    ]
                };
            }

            const addPolyLine = (paths) => {
                const graphic = new Graphic({
                    geometry: {
                        type: "polyline",
                        paths,
                    },
                    symbol: {
                        type: "simple-line",
                        color: [255, 0, 0],
                        width: 4,
                        cap: "round",
                        join: "round"
                    }
                });

                view.graphics.removeAll();
                view.graphics.add(graphic)
                view.goTo({
                    target: graphic.geometry,
                    tilt: 70,
                    zoom: 13,
                }, {
                    duration: 1500,
                    easing: "in-out-expo",
                })
            }

            const onChangeRuasJalan = async(event) => {
                try { view.ui.remove(gambarManual) } catch (e) { console.log(e) };
                let geo_id = event.target.value;
                console.log(geo_id)
                const namaLokasi = document.getElementById('nama_lokasi')
                if (geo_id != -1) {
                    $("#nama_lokasi").hide()
                    $("#nama_lokasi_value").prop('required', false);
                } else {
                    drawMode();
                    $("#nama_lokasi").show()
                    $("#nama_lokasi_value").prop('required', true);
                    if (exitsData !== null) {
                        if (exitsData.geo_id != -1) {
                            geo_id = exitsData.geo_id
                        } else {
                            const paths = JSON.parse(exitsData.geo_json)
                            addPolyLine(paths)
                            drawMode()
                            console.log(exitsData.nama_lokasi)
                            $("#nama_lokasi_value").val(exitsData.nama_lokasi)
                        }
                    } else {
                        $("#nama_lokasi").show()
                    }

                }
                if (geo_id != -1) {
                    const response = await fetch(`${url}/${geo_id}`);
                    const ruasJalan = await response.json();
                    console.log([ruasJalan.coordinates[0]]);
                    addPolyLine([ruasJalan.coordinates])
                }

            };

            const inputRuasJalan = document.getElementById("ruas_jalan");
            inputRuasJalan.onchange = (event) => onChangeRuasJalan(event);


            view.when(() => {
                if (exitsData !== null) {
                    onChangeRuasJalan({ target: { value: exitsData.geo_id } })
                } else {
                    onChangeRuasJalan({ target: { value: -1 } })
                }
            })
        });
    });







// old
// let tempGraphic = [];

// if ($("#lat0").val() != undefined && $("#long0").val() != undefined) {
//     addTitik(0, $("#lat0").val(), $("#long0").val(), "blue");
// }
// if ($("#lat1").val() != undefined && $("#long1").val() != undefined) {
//     addTitik(1, $("#lat1").val(), $("#long1").val(), "green");
// }

// let mouseclick = 0;

// view.on("click", function(event) {
//     const lat = event.mapPoint.latitude;
//     const long = event.mapPoint.longitude;

//     // Genap = Titik Awal
//     if (mouseclick % 2 == 0) {
//         addTitik(0, lat, long, "blue");
//         $("#lat0").val(lat);
//         $("#long0").val(long);
//     } else {
//         addTitik(1, lat, long, "green");
//         $("#lat1").val(lat);
//         $("#long1").val(long);
//     }
//     mouseclick++;
// });

// $("#lat0, #long0").keyup(function() {
//     const lat = $("#lat0").val();
//     const long = $("#long0").val();
//     addTitik(0, lat, long, "blue");
// });
// $("#lat1, #long1").keyup(function() {
//     const lat = $("#lat1").val();
//     const long = $("#long1").val();
//     addTitik(1, lat, long, "green");
// });

// function addTitik(point, lat, long, color) {
//     if (
//         $("#lat" + point).val() != "" &&
//         $("#long" + point).val() != ""
//     ) {
//         view.graphics.remove(tempGraphic[point]);
//     }

//     const graphic = new Graphic({
//         geometry: {
//             type: "point",
//             longitude: long,
//             latitude: lat,
//         },
//         symbol: {
//             type: "picture-marker",
//             url: `http://esri.github.io/quickstart-map-js/images/${color}-pin.png`,
//             width: "14px",
//             height: "24px",
//         },
//     });
//     tempGraphic[point] = graphic;

//     view.graphics.add(graphic);
// }