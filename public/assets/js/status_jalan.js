$(document).ready(function () {
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
            Swiper
        ) {
            console.log("test", Swiper);
            const { useState, useEffect, useRef } = React;
            const Pemeliharaan = ({ view, track, pemeliharaanProps }) => {
                const [pemeliharaan, setPemeliharaan] =
                    useState(pemeliharaanProps);
                const swiperRef = useRef(null);
                useEffect(() => {
                    const swiper = new Swiper(swiperRef.current, {
                        speed: 4000,
                        autoplay: {
                            delay: 3000,
                        },
                        direction: "horizontal",
                        loop: true,
                        spaceBetween: 10,
                        slidesPerView: 1,
                    });
                }, [pemeliharaan]);

                return (
                    <div
                        className="card small"
                        style={{ width: 18 + "rem", maxHeight: 20 + "rem" }}
                    >
                        <div className="card-body">
                            <h6 className="card-subtitle mb-1 text-muted small">
                                Pekerjaan
                            </h6>
                            <p className="card-text small p-2 mb-0">
                                Daftar lokasi pekerjaan DBMPR terdekat
                            </p>{" "}
                            <div
                                ref={swiperRef}
                                className="list-group small swiper-container"
                            >
                                <div className="swiper-wrapper">
                                    {pemeliharaan &&
                                        pemeliharaan.map((data) => (
                                            <a
                                                key={data.id_pek}
                                                href="#"
                                                className="list-group-item list-group-item-action flex-column align-items-start swiper-slide"
                                            >
                                                <div className="d-flex w-100 justify-content-between">
                                                    <h5 className="mb-1 small">
                                                        {data.paket}
                                                    </h5>
                                                    <small>
                                                        {data.tanggal}
                                                    </small>
                                                </div>
                                                <p className="mb-1">
                                                    {data.ruas_jalan}
                                                </p>
                                                <small>
                                                    Donec id elit non mi porta.
                                                </small>
                                            </a>
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

                useEffect(() => {
                    console.log(statusJalan);
                }, [statusJalan]);

                return (
                    <div className="p-2 card small">
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

            const toggle = new BasemapToggle({
                view,
                nextBasemap: "hybrid",
            });
            const compass = new Compass({
                view,
            });
            const track = new Track({
                view,
            });
            const fullscreen = new Fullscreen({
                view,
            });
            const statusJalanWidgetContainer = document.createElement("div");
            const pemeliharaanWidgetContainer = document.createElement("div");
            view.ui.add([
                {
                    component: pemeliharaanWidgetContainer,
                    position: "bottom-trailing",
                },
                {
                    component: statusJalanWidgetContainer,
                    position: "top-right",
                },
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
                            console.log("test", data.pemeliharaan);
                            if (data.pemeliharaan.length > 0) {
                                console.log("tests", data.pemeliharaan);
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

            view.when(function () {
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
        });
    });
});
