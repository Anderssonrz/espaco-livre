let map;
let marker;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -26.4807, lng: -49.077 },
        zoom: 8,
        scrollwheel: true,
    });

    marker = new google.maps.Marker({
        position: { lat: -26.4807, lng: -49.077 },
        map: map,
        draggable: true,
    });

    marker.addListener("position_changed", function () {
        let lat = marker.getPosition().lat();
        let lng = marker.getPosition().lng();
        document.getElementById("lat").value = lat;
        document.getElementById("lng").value = lng;
    });

    map.addListener("click", function (event) {
        marker.setPosition(event.latLng);
    });
}

window.initMap = initMap; // Torna a função acessível para o callback da API

// Carrega a API do Google Maps
let script = document.createElement('script');
script.src = `https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap`; //coloque sua KEY
script.async = true;
document.head.appendChild(script);