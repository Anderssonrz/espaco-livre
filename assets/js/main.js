
// Função para inicializar o mapa
function initMap() {
    // Coordenadas do estacionamento (exemplo)
    const location = { lat: 40.7128, lng: -74.0059 };  // Localização do City Hall, NYC

    // Criar o mapa
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 16,
        center: location,
        mapTypeId: "roadmap",
    });

    // Adicionar um marcador no mapa
    const marker = new google.maps.Marker({
        position: location,
        map: map,
        title: "Estacionamento - City Hall",
    });

    // Informação adicional que aparece ao clicar no marcador
    const infoWindow = new google.maps.InfoWindow({
        content: "<strong>Estacionamento - City Hall</strong><br>260 E Broadway, NY 10007",
    });

    // Evento de clique no marcador
    marker.addListener("click", () => {
        infoWindow.open(map, marker);
    });
}

// Garantir que o mapa seja inicializado após o carregamento do script
window.initMap = initMap;
