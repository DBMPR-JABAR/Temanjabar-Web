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
            ZoomViewModel
        ) {
            const { useState } = React;
            const StatusJalan = ({ view, track }) => {
                console.log(view, track);
                const [coords, setCoords] = useState({
                    latitude: null,
                    longitude: null,
                });

                React.useEffect(() => {
                    track.on("track", async (trackEvent) => {
                        const coordsTemp = trackEvent.position.coords;
                        setCoords({
                            latitude: coordsTemp.latitude,
                            longitude: coordsTemp.longitude,
                        });
                        // console.log(coords.latitude);
                    });
                }, []);
                console.log(coords);
                return (
                    <div className="p-2 card w-30">
                        <p>Latitude: {coords.latitude ? coords.latitude : 'inisialisasi..'}</p>
                        <p>Longitude: {coords.longitude ? coords.longitude : 'inisialisasi..'}</p>
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
            const statusJalanContainer = document.createElement("div");
            view.ui.add([
                {
                    component: statusJalanContainer,
                    position: "top-right",
                },
                {
                    component: toggle,
                    position: "bottom-left",
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
            ]);
            ReactDOM.render(
                <StatusJalan view={view} track={track} />,
                statusJalanContainer
            );

            let coords = {
                latitude,
                longitude,
            };

            view.when(function () {
                track.start();
                track.on("track", async (trackEvent) => {
                    const coordsTemp = trackEvent.position.coords;
                    coords.latitude = coordsTemp.latitude;
                    coords.longitude = coordsTemp.longitude;
                    $("#latitude").text(coordsTemp.latitude);
                    $("#longitude").text(coordsTemp.longitude);
                });
                getData();
            });

            const getData = () => {
                const url = new URL(baseUrl + "/status_jalan/api"),
                    params = {
                        ...coords,
                        radius: 100,
                    };
                Object.keys(params).forEach((key) =>
                    url.searchParams.append(key, params[key])
                );
                fetch(url)
                    .then((response) => response.json())
                    .then((data) => {
                        console.log(data.pemeliharaan);
                        let html = "";
                        data.pemeliharaan.forEach((pemeliharaan) => {
                            html += `
                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                  <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${pemeliharaan.paket}</h5>
                                    <small>${pemeliharaan.distance} M</small>
                                  </div>
                                  <p class="mb-1">${pemeliharaan.ruas_jalan}</p>
                                  <small>${pemeliharaan.tanggal}</small>
                                </a>`;
                        });
                        const pekerjaanContainer = document.getElementById(
                            "pekerjaan_list_container"
                        );
                        pekerjaanContainer.innerHTML = html;
                    });
            };
        });
    });
    console.log(geoServerUrl, baseUrl);
});
