$(document).ready(function () {
    const authKey = "9bea4cef-904d-4e00-adb2-6e1cf67b24ae";
    $("#map_container").ready(() => {
        require([
            "esri/Map",
            "esri/views/MapView",
            "esri/widgets/BasemapToggle",
            "esri/widgets/Compass",
            "esri/widgets/Track",
            "esri/widgets/Fullscreen",
            "esri/Graphic",
            "react",
            "react-dom",
            "esri/core/watchUtils",
            "esri/widgets/Zoom/ZoomViewModel",
            "swiper",
            "esri/layers/FeatureLayer",
            "esri/widgets/Legend",
            "esri/geometry/Point",
            "esri/layers/GroupLayer",
            "esri/widgets/LayerList",
            "esri/widgets/Expand",
            "esri/widgets/Search",
        ], function (
            Map,
            MapView,
            BasemapToggle,
            Compass,
            Track,
            Fullscreen,
            Graphic,
            React,
            ReactDOM,
            watchUtils,
            ZoomViewModel,
            Swiper,
            FeatureLayer,
            Legend,
            Point,
            GroupLayer,
            LayerList,
            Expand,
            Search
        ) {
            const { useState, useEffect, useRef } = React;
            const Pemeliharaan = ({ view, track, pemeliharaanProps }) => {
                const [pemeliharaan, setPemeliharaan] =
                    useState(pemeliharaanProps);

                const swiperRef = useRef(null);
                useEffect(() => {
                    const swiper = new Swiper(swiperRef.current, {
                        speed: 4000,
                        // autoplay: {
                        //     delay: 5000,
                        // },
                        direction: "horizontal",
                        loop: true,
                        spaceBetween: 10,
                        slidesPerView: 1,
                    });
                }, [pemeliharaan]);

                const onClick = (e, { idPek }) => {
                    e.preventDefault();
                    goToPemeliharaan({ idPek });
                    sideCanvas.hide();
                };

                return (
                    <div
                        className="card mx-3 mt-3"
                        style={{
                            maxHeight: 20 + "rem",
                            display: "relative",
                        }}
                    >
                        <div className="card-body">
                            <h6 className="card-subtitle mb-1 text-muted">
                                Pekerjaan
                            </h6>
                            <p className="card-text p-2 mb-0">
                                Daftar lokasi pekerjaan BMPR terdekat
                            </p>{" "}
                            <div
                                ref={swiperRef}
                                className="list-group swiper-container"
                            >
                                <div className="swiper-wrapper p-0 m-0">
                                    {pemeliharaan &&
                                        pemeliharaan.map((data) => (
                                            <div
                                                onClick={(e) =>
                                                    onClick(e, {
                                                        idPek: data.id_pek,
                                                    })
                                                }
                                                key={data.id_pek}
                                                className="list-group-item list-group-item-action align-items-start swiper-slide mt-1"
                                                // style={{ maxWidth: 85 + "%", margin:'auto' }}
                                            >
                                                <div className="d-flex justify-content-between">
                                                    <h5 className="mb-1">
                                                        {data.paket}
                                                    </h5>
                                                    <small>
                                                        {data.tanggal}
                                                    </small>
                                                </div>
                                                <p className="mb-1">
                                                    {data.ruas_jalan}
                                                </p>
                                                <small>{data.lokasi}</small>
                                            </div>
                                        ))}
                                </div>
                            </div>
                        </div>
                    </div>
                );
            };

            const StatusJalan = ({ view, track, statusJalanProps }) => {
                const [coords, setCoords] = useState({
                    latitude: statusJalanProps.coords.latitude,
                    longitude: statusJalanProps.coords.longitude,
                });
                const [statusJalan, setStatusJalan] =
                    useState(statusJalanProps);

                return (
                    <div className="card mx-3 px-2">
                        <h6 className="card-subtitle text-mutedl py-2">
                            Ruas Jalan BMPR terdekat
                        </h6>
                        <ul className="list-group list-group-flush">
                            {statusJalan.ruas_jalan && (
                                <>
                                    <li className="list-group-item p-1">
                                        Ruas Jalan:{" "}
                                        {
                                            statusJalan.ruas_jalan[0]
                                                .nama_ruas_jalan
                                        }
                                    </li>
                                    <li className="list-group-item p-1">
                                        Kabupaten Kota:{" "}
                                        {statusJalan.ruas_jalan[0].kab_kota}
                                    </li>
                                </>
                            )}
                            {coords.latitude && (
                                <>
                                    <li className="list-group-item p-1">
                                        Latitude: {coords.latitude}
                                    </li>
                                    <li className="list-group-item p-1">
                                        Longitude: {coords.longitude}
                                    </li>
                                </>
                            )}
                        </ul>
                    </div>
                );
            };

            const map = new Map({
                basemap: "osm",
            });

            const view = new MapView({
                container: "maps_container",
                map: map,
                center: [107.6191, -6.9175],
                zoom: 10,
                ui: {
                    components: ["attribution"],
                },
                sliderPosition: "top-right",
            });

            const pemeliharaanLayer = new FeatureLayer({
                title: "Pekerjaan",
                fields: [
                    {
                        name: "ObjectID",
                        alias: "ObjectID",
                        type: "oid",
                    },
                    {
                        name: "ID_PEK",
                        alias: "IdPek",
                        type: "oid",
                    },
                    {
                        name: "RUAS_JALAN",
                        alias: "RuasJalan",
                        type: "string",
                    },
                    {
                        name: "LOKASI",
                        alias: "Lokasi",
                        type: "string",
                    },
                    {
                        name: "PAKET",
                        alias: "Paket",
                        type: "string",
                    },
                    {
                        name: "JUMLAH_PEKERJA",
                        alias: "JumlahPekerja",
                        type: "integer",
                    },
                ],
                objectIdField: "ObjectID",
                geometryType: "point",
                spatialReference: { wkid: 4326 },
                source: [],
                renderer: {
                    type: "simple",
                    symbol: {
                        type: "text",
                        color: "#f00",
                        text: "\ue62e",
                        font: {
                            size: 20,
                            family: "CalciteWebCoreIcons",
                        },
                    },
                },
                popupTemplate: {
                    title: "{Paket} {RuasJalan}",
                    content: [
                        {
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "LOKASI",
                                    label: "Lokasi",
                                },
                                {
                                    fieldName: "RUAS_JALAN",
                                    label: "Ruas Jalan",
                                },
                                {
                                    fieldName: "JUMLAH_PEKERJA",
                                    label: "Jumlah Pekerja",
                                },
                            ],
                        },
                    ],
                },
            });

            map.add(pemeliharaanLayer);
            const toggle = new BasemapToggle({
                view,
                nextBasemap: "hybrid",
            });
            const compass = new Compass({ view });
            const track = new Track({ view });
            const fullscreen = new Fullscreen({ view });
            // const legend = new Legend({ view });

            const layerList = new Expand({
                content: new LayerList({
                    view,
                    id: "layerList",
                }),
                view,
                expanded: false,
                expandIconClass: "esri-icon-layers",
                expandTooltip: "Layer Aktif",
            });

            const statusJalanWidgetContainer =
                document.getElementById("status_jalan");
            const pemeliharaanWidgetContainer =
                document.getElementById("pemeliharaan_jalan");

            const buttonToggleSidePanel = document.createElement("div");
            const sideCanvasElement = document.getElementById("sideCanvas");
            const sideCanvas = new bootstrap.Offcanvas(sideCanvasElement);
            const ButtonToggleLeftSideCanvas = () => {
                const [canvasElement, setCanvasElement] =
                    useState(sideCanvasElement);
                const [canvas, setCanvas] = useState(sideCanvas);
                const [show, setShow] = useState(() => canvas._isShown);

                const toggleCanvas = () => {
                    canvas._isShown
                        ? (canvas.hide(), setShow(false))
                        : (canvas.show(), setShow(true));
                };

                useEffect(() => {
                    canvasElement.addEventListener(
                        "hide.bs.offcanvas",
                        (event) => {
                            setShow(false);
                        }
                    );
                }, [canvasElement]);

                return (
                    <>
                        <div
                            aria-expanded="false"
                            className="esri-widget--button"
                            role="button"
                            tabIndex="0"
                            title="Informasi Pekerjaan BMPR terdekat"
                            onClick={toggleCanvas}
                        >
                            <span
                                aria-hidden="true"
                                className={
                                    show
                                        ? "esri-collapse__icon esri-icon-close"
                                        : "esri-collapse__icon esri-icon-notice-round"
                                }
                            ></span>
                            <span className="esri-icon-font-fallback-text">
                                Informasi Pekerjaan BMPR terdekat
                            </span>
                        </div>
                    </>
                );
            };

            view.ui.add([
                {
                    component: buttonToggleSidePanel,
                    position: "top-right",
                },
                {
                    component: layerList,
                    position: "top-left",
                },
                // {
                //     component: statusJalanWidget,
                //     position: "top-right",
                // },
                // {
                //     component: pemeliharaanWidgetContainer,
                //     position: "bottom-right",
                // },
                {
                    component: compass,
                    position: "top-left",
                },
                {
                    component: fullscreen,
                    position: "top-left",
                },
                {
                    component: track,
                    position: "top-left",
                },
                {
                    component: toggle,
                    position: "top-left",
                },
            ]);

            const applyEditsToLayer = ({ edits }) => {
                pemeliharaanLayer
                    .applyEdits(edits)
                    .then(function (results) {
                        // if (results.deleteFeatureResults.length > 0) {
                        //     console.log(
                        //         results.deleteFeatureResults.length,
                        //         "features have been removed"
                        //     );
                        // }
                        if (results.addFeatureResults.length > 0) {
                            const objectIds = [];
                            results.addFeatureResults.forEach(function (item) {
                                objectIds.push(item.objectId);
                            });
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            };
            const addFeatures = ({ dataPemeliharaan }) => {
                const dataTemp = [];
                dataPemeliharaan.forEach((data) => {
                    dataTemp.push({
                        ID_PEK: data.id_pek,
                        LATITUDE: data.lat,
                        LONGITUDE: data.lng,
                        PAKET: data.paket,
                        LOKASI: data.lokasi,
                        RUAS_JALAN: data.ruas_jalan,
                        JUMLAH_PEKERJA: data.jumlah_pekerja,
                    });
                });
                const graphics = [];
                let graphic;
                for (let i = 0; i < dataTemp.length; i++) {
                    graphic = new Graphic({
                        geometry: new Point({
                            longitude: dataTemp[i].LONGITUDE,
                            latitude: dataTemp[i].LATITUDE,
                        }),
                        attributes: dataTemp[i],
                    });
                    graphics.push(graphic);
                }

                const addEdits = {
                    addFeatures: graphics,
                };

                pemeliharaanLayer
                    .queryFeatures()
                    .then((results) => {
                        const deleteEdits = {
                            deleteFeatures: results.features,
                        };
                        applyEditsToLayer({ edits: deleteEdits });
                    })
                    .then(() => applyEditsToLayer({ edits: addEdits }));
            };

            const getData = ({ radius, latitude, longitude }) => {
                const url = new URL(baseUrl + "/status_jalan/api"),
                    params = {
                        latitude,
                        longitude,
                        radius,
                    };
                Object.keys(params).forEach((key) =>
                    url.searchParams.append(key, params[key])
                );

                fetch(url)
                    .then((response) => response.json())
                    .then((data) => {
                        ReactDOM.render(
                            <StatusJalan
                                view={view}
                                track={track}
                                statusJalanProps={data}
                            />,
                            statusJalanWidgetContainer
                        );
                        if (data.pemeliharaan) {
                            if (data.pemeliharaan.length > 0) {
                                addFeatures({
                                    dataPemeliharaan: data.pemeliharaan,
                                });
                                ReactDOM.render(
                                    <Pemeliharaan
                                        view={view}
                                        track={track}
                                        pemeliharaanProps={data.pemeliharaan}
                                    />,
                                    pemeliharaanWidgetContainer
                                );
                            }
                        }
                    });
            };

            view.when(() => {
                ReactDOM.render(
                    <ButtonToggleLeftSideCanvas />,
                    buttonToggleSidePanel
                );
                track.start();
                track.on("track", async (trackEvent) => {
                    const coordsTemp = trackEvent.position.coords;
                    getData({
                        radius: 1000,
                        latitude: coordsTemp.latitude,
                        longitude: coordsTemp.longitude,
                    });
                });
            });

            const goToPemeliharaan = ({ idPek }) => {
                let highlightSelect;
                view.whenLayerView(pemeliharaanLayer).then((layerView) => {
                    const pemeliharaanQueryStations =
                        pemeliharaanLayer.createQuery({
                            geometry: view.extent,
                            returnGeometry: true,
                        });
                    pemeliharaanQueryStations.where = `ID_PEK = '${idPek}'`;
                    pemeliharaanLayer
                        .queryFeatures(pemeliharaanQueryStations)
                        .then((results) => {
                            if (highlightSelect) highlightSelect.remove();
                            const feature = results.features[0];
                            highlightSelect = layerView.highlight(
                                feature.attributes["ObjectID"]
                            );

                            view.goTo(
                                {
                                    target: feature.geometry,
                                    tilt: 70,
                                    zoom: 20,
                                },
                                {
                                    duration: 1500,
                                    easing: "in-out-expo",
                                }
                            )
                                .then(() => {
                                    view.popup.open({
                                        features: [feature],
                                        location: feature.geometry.centroid,
                                    });
                                })
                                .catch((error) => {
                                    if (error.name != "AbortError") {
                                        console.error(error);
                                    }
                                });
                        });
                });
            };

            const provinceRoadsLayer = new FeatureLayer({
                url:
                    geoServerUrl +
                    "/geoserver/gsr/services/temanjabar/FeatureServer/0/",
                customParameters: {
                    ak: authKey,
                },
                title: "Ruas Jalan Provinsi",
                id: "provinceRoads",
                outFields: ["*"],
                renderer: {
                    type: "simple",
                    symbol: {
                        type: "simple-line",
                        color: "green",
                        width: "2px",
                        style: "solid",
                    },
                },
                popupTemplate: {
                    title: "{nm_ruas}",
                    content: [
                        {
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "IDruas",
                                    label: "Kode Ruas",
                                },
                                {
                                    fieldName: "expression/pemilik",
                                },
                                {
                                    fieldName: "LAT_AWAL",
                                    label: "Latitude 0",
                                },
                                {
                                    fieldName: "LONG_AWAL",
                                    label: "Longitude 0",
                                },
                                {
                                    fieldName: "LAT_AKHIR",
                                    label: "Latitude 1",
                                },
                                {
                                    fieldName: "LONG_AKHIR",
                                    label: "Longitude 1",
                                },
                                {
                                    fieldName: "kab_kota",
                                    label: "Kab/Kota",
                                },
                                {
                                    fieldName: "wil_uptd",
                                    label: "UPTD",
                                },
                                {
                                    fieldName: "nm_sppjj",
                                    label: "SUP",
                                },
                                {
                                    fieldName: "expression/pjg_km",
                                },
                            ],
                        },
                    ],
                    expressionInfos: [
                        {
                            name: "pjg_km",
                            title: "Panjang Ruas (KM)",
                            expression: "Round($feature.pjg_ruas_m / 1000, 2)",
                        },
                        {
                            name: "pemilik",
                            title: "Pengelola Jalan",
                            expression: `return "DBMPR Jawa Barat"`,
                        },
                    ],
                },
            });

            const nationalRoadsLayer = new FeatureLayer({
                url:
                    geoServerUrl +
                    "/geoserver/gsr/services/temanjabar/FeatureServer/2/",
                customParameters: {
                    ak: authKey,
                },
                title: "Ruas Jalan Nasional",
                renderer: {
                    type: "simple",
                    symbol: {
                        type: "simple-line",
                        color: "red",
                        width: "2px",
                        style: "solid",
                    },
                },
                popupTemplate: {
                    title: "{NAMA_SK}",
                    content: [
                        {
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "NO_RUAS",
                                    label: "Nomor Ruas",
                                },
                                {
                                    fieldName: "expression/pemilik",
                                },
                                {
                                    fieldName: "PJG_SK",
                                    label: "Panjang (KM)",
                                },
                                {
                                    fieldName: "KLS_JALAN",
                                    label: "Kelas Jalan",
                                },
                                {
                                    fieldName: "LINTAS",
                                    label: "Lintas",
                                },
                                {
                                    fieldName: "TAHUN",
                                    label: "Tahun",
                                },
                            ],
                        },
                    ],
                    expressionInfos: [
                        {
                            name: "pemilik",
                            title: "Pengelola Jalan",
                            expression: `return "Kementrian PUPR"`,
                        },
                    ],
                },
            });

            const tollRoadsOperationsLayer = new FeatureLayer({
                url:
                    geoServerUrl +
                    "/geoserver/gsr/services/temanjabar/FeatureServer/3/",
                customParameters: {
                    ak: authKey,
                },
                title: "Ruas Jalan Tol (Operasional)",
                popupTemplate: {
                    title: "{NAMA}",
                    content: [
                        {
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "PANJANG",
                                    label: "Panjang",
                                },
                                {
                                    fieldName: "PENGELOLA",
                                    label: "Pengelola",
                                },
                                {
                                    fieldName: "STATUS",
                                    label: "Status",
                                },
                                {
                                    fieldName: "Kabupaten",
                                    label: "Kabupaten",
                                },
                                {
                                    fieldName: "Propinsi",
                                    label: "Propinsi",
                                },
                            ],
                        },
                    ],
                },
                renderer: {
                    type: "simple",
                    symbol: {
                        type: "simple-line",
                        color: "yellow",
                        width: "2px",
                        style: "solid",
                    },
                },
            });

            const tollRoadsConstructionsLayer = new FeatureLayer({
                url:
                    geoServerUrl +
                    "/geoserver/gsr/services/temanjabar/FeatureServer/4/",
                customParameters: {
                    ak: authKey,
                },
                title: "Ruas Jalan Tol (Konstruksi)",
                popupTemplate: {
                    title: "{Nama}",
                    content: [
                        {
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "panjang",
                                    label: "Panjang",
                                },
                                {
                                    fieldName: "pengelola",
                                    label: "Pengelola",
                                },
                                {
                                    fieldName: "kabupaten",
                                    label: "Kabupaten",
                                },
                                {
                                    fieldName: "propinsi",
                                    label: "Propinsi",
                                },
                                {
                                    fieldName: "keterangan",
                                    label: "Keterangan",
                                },
                            ],
                        },
                    ],
                },
                renderer: {
                    type: "simple",
                    symbol: {
                        type: "simple-line",
                        color: "purple",
                        width: "2px",
                        style: "solid",
                    },
                },
            });

            let highlightSelectGoToFeature = null;
            const goToFeature = ({ feature, layer }) => {
                view.whenLayerView(layer).then((layerView) => {
                    if (highlightSelectGoToFeature) {
                        highlightSelectGoToFeature.remove();
                    }

                    highlightSelectGoToFeature = layerView.highlight(feature);

                    view.goTo(
                        {
                            target: feature.geometry,
                            tilt: 70,
                            zoom: 13,
                        },
                        {
                            duration: 1500,
                            easing: "in-out-expo",
                        }
                    ).then(() => {
                        view.popup.open({
                            features: [feature],
                            location: feature.geometry.centroid,
                        });
                    });
                });
            };

            const SearchRouteRoads = (props) => {
                const [value, setValue] = useState("Cari");
                const { lists } = props;
                console.log("teste", lists);
                const [itemLists, setItemLists] = useState(
                    lists.map((data) => {
                        return {
                            label: data.attributes.nm_ruas,
                            id: data.attributes.gid,
                        };
                    })
                );
                const [itemListFilter, setItemListFilter] = useState(itemLists);
                const onChange = (value) => {
                    setItemListFilter(
                        itemLists.filter(
                            (data) =>
                                data.label
                                    .toLowerCase()
                                    .indexOf(value.toLowerCase()) > -1
                        )
                    );
                    console.log(itemListFilter);
                    setValue(value);
                };
                console.log(itemLists);
                return (
                    <div className="card mx-3 p-2 mb-3">
                        <h6 className="card-subtitle text-mutedl py-2">
                            Cari Ruas Jalan
                        </h6>
                        <div className="input-group">
                            <Autocomplete
                                getItemValue={(item) => item.label}
                                items={itemListFilter}
                                className="form-outline"
                                renderItem={(item, isHighlighted) => (
                                    <div
                                        style={{ zIndex: 999 }}
                                        key={item.id}
                                        style={{
                                            background: isHighlighted
                                                ? "lightgray"
                                                : "white",
                                        }}
                                    >
                                        {item.label}
                                    </div>
                                )}
                                value={value}
                                onChange={(e) => onChange(e.target.value)}
                                onSelect={(val) => setValue(val)}
                            />
                            <button type="button" className="btn btn-primary">
                                <i className="esri-icon-search"></i>
                            </button>
                        </div>
                    </div>
                );
            };

            const routeData = [];
            const callBackAfterAddRoads = ({ routeGroupLayer }) => {
                view.whenLayerView(routeGroupLayer).then((layerView) => {
                    provinceRoadsLayer
                        .queryFeatures()
                        .then((result) => {
                            routeData.PROVINCE_DATA = result.features;
                            routeData.PROVINCE_DATA.LAYER_VIEW = layerView;
                            goToFeature({
                                feature: routeData.PROVINCE_DATA[0],
                                layer: provinceRoadsLayer,
                            });
                        })
                        .then(() => {
                            const searchContainer =
                                document.getElementById("cari_ruas_jalan");
                            // ReactDOM.render(
                            //     <SearchRouteRoads
                            //         lists={routeData.PROVINCE_DATA}
                            //     />,
                            //     searchContainer
                            // );
                        });
                });
            };

            const addRoads = () => {
                const routeGroupLayer = new GroupLayer({
                    title: "Ruas Jalan",
                    id: "Roads",
                });
                routeGroupLayer.add(provinceRoadsLayer, 0);
                routeGroupLayer.add(nationalRoadsLayer, 1);
                routeGroupLayer.add(tollRoadsOperationsLayer, 2);
                routeGroupLayer.add(tollRoadsConstructionsLayer, 3);
                map.add(routeGroupLayer);
                callBackAfterAddRoads({ routeGroupLayer });
            };
            addRoads();

            const searchWidget = new Search({
                view: view,
                allPlaceholder: "District or Senator",
                includeDefaultSources: false,
                sources: [
                    {
                        layer: provinceRoadsLayer,
                        searchFields: ["nm_ruas"],
                        displayField: "nm_ruas",
                        exactMatch: false,
                        outFields: ["nm_ruas"],
                        name: "Ruas Jalan Provinsi",
                        placeholder: "example: ---",
                    },
                    {
                        layer: nationalRoadsLayer,
                        searchFields: ["nm_ruas"],
                        suggestionTemplate: "{nm_ruas}",
                        exactMatch: false,
                        outFields: ["*"],
                        placeholder: "example: ---",
                        name: "Jalan Raya Nasional",
                        zoomScale: 500000,
                        resultSymbol: {
                            type: "picture-marker",
                            url: "https://developers.arcgis.com/javascript/latest/sample-code/widgets-search-multiplesource/live/images/senate.png",
                            height: 36,
                            width: 36,
                        },
                    },
                    // {
                    //     name: "ArcGIS World Geocoding Service",
                    //     placeholder: "example: Nuuk, GRL",
                    //     apiKey: "AAPKd6517aa887304b5891f6b959ea426015CLWBA2qIMPI4-vgwnS0B8RGRBVMArpJu0IN2BUL-G6GZ_aa8NF-r_JvSnsWp_A2M",
                    //     singleLineFieldName: "SingleLine",
                    //     locator: new Locator({
                    //         url: "https://geocode-api.arcgis.com/arcgis/rest/services/World/GeocodeServer",
                    //     }),
                    // },
                ],
            });

            // Add the search widget to the top left corner of the view
            view.ui.add(searchWidget, {
                position: "bottom-right",
            });
        });
    });
});
