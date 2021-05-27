$(document).ready(function() {
    $('#map_container').ready(() => {
        require([
            "esri/Map",
            "esri/views/MapView",
            "esri/Graphic",
            "esri/widgets/BasemapToggle",
            "esri/widgets/Compass",
            "esri/widgets/Track",
            "esri/widgets/Fullscreen"
        ], function(Map, MapView, BasemapToggle, Compass, Track, Fullscreen, Graphic) {

            const map = new Map({
                basemap: "osm"
            });

            const view = new MapView({
                container: "maps_container",
                map: map,
                center: [
                    107.6191, -6.9175
                ],
                zoom: 10,
                sliderPosition: "top-right"
            });

            const toggle = new BasemapToggle({
                view,
                nextBasemap: "hybrid"
            });
            const compass = new Compass({
                view
            });
            const track = new Track({
                view
            });
            const fullscreen = new Fullscreen({
                view
            });

            view.ui.add([{
                component: toggle,
                position: "bottom-left"
            }, {
                component: compass,
                position: "top-left"
            }, {
                component: fullscreen,
                position: "top-left"
            }, {
                component: track,
                position: "top-left"
            }]);

            let coords = {
                latitude,
                longitude
            };

            view.when(function() {
                track.start();
                track.on("track", async(trackEvent) => {
                    const coordsTemp = trackEvent.position.coords;
                    coords.latitude = coordsTemp.latitude
                    coords.longitude = coordsTemp.longitude
                    $('#latitude').text(coordsTemp.latitude)
                    $('#longitude').text(coordsTemp.longitude)
                })
                getData();
            });

            const getData = () => {
                const url = new URL(baseUrl + '/status_jalan/api'),
                    params = {...coords, radius: 100 }
                Object.keys(params).forEach(key => url.searchParams.append(key, params[key]))
                fetch(url)
                    .then((response) => response.json())
                    .then((data) => {
                        console.log(data.pemeliharaan)
                        let html = ''
                        data.pemeliharaan.forEach(pemeliharaan => {
                            html += `
                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                  <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${pemeliharaan.paket}</h5>
                                    <small>${pemeliharaan.distance} M</small>
                                  </div>
                                  <p class="mb-1">${pemeliharaan.ruas_jalan}</p>
                                  <small>${pemeliharaan.tanggal}</small>
                                </a>`
                        })
                        const pekerjaanContainer = document.getElementById('pekerjaan_list_container')
                        pekerjaanContainer.innerHTML = html
                    })
            }
        });
    });
    console.log(geoServerUrl, baseUrl)
});
