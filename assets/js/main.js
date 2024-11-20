// Variável para armazenar a última posição de rolagem e a navbar
let lastScrollTop = 0; 
const navbar = document.getElementById('navbar');

// Evento de rolagem para ocultar ou mostrar a navbar
window.addEventListener('scroll', () => {
  const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

  if (currentScroll > lastScrollTop) {
    // Rolagem para baixo - esconder a navbar
    navbar.classList.add('hidden');
  } else {
    // Rolagem para cima - mostrar a navbar
    navbar.classList.remove('hidden');
  }

  // Previne valores negativos de rolagem
  lastScrollTop = Math.max(currentScroll, 0);
});

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
