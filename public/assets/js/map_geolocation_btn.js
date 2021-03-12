// Geolocations
const getLocation = ({ idLat, idLong }) => {
    const btnGeolocation = $("#btn_geoLocation");
    btnGeolocation.html('<i class="fa fa-spinner fa-spin""></i>');
    let location;

    const success = (pos) => {
        const crd = pos.coords;
        console.log(crd);

        if (
            $(`#${idLat}`).val() === crd.latitude.toString() &&
            $(`#${idLong}`).val() === crd.longitude.toString()
        ) {
            navigator.geolocation.clearWatch(location);
            btnGeolocation.html('<i class="ti-location-pin"></i>');
        }
        $(`#${idLat}`).val(crd.latitude).keyup();
        $(`#${idLong}`).val(crd.longitude).keyup();
    };

    const error = (err) => {
        console.log(err);
        // alert('Terjadi kesalahan saat mendapatkan lokasi');
    };

    const options = {
        enableHighAccuracy: true,
        maximumAge: 0,
    };

    location = navigator.geolocation.watchPosition(success, error, options);
};

$(document).ready(() => {
    if (!navigator.geolocation) $("#btn_geoLocation").remove();
});
