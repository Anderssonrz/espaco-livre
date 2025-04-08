<?php
// Pega a localização da URL (query string)
$localizacao = isset($_GET['localizacao']) ? $_GET['localizacao'] : '';
$radius = isset($_GET['radius']) ? $_GET['radius'] : 5000; // Raio padrão de 5km
$type = isset($_GET['type']) ? $_GET['type'] : 'parking'; // Tipo de estacionamento

// Inicializa variáveis de resposta
$lat = $lng = null;
$formatted_address = '';

// Verifica se a localização foi fornecida
if ($localizacao) {
    // Geocodifica a localização utilizando a API do Google Maps
    $encoded_location = urlencode($localizacao);
    $google_api_key = 'YOUR_GOOGLE_API_KEY';  // Substitua pela sua chave da API do Google
    $geocode_url = "https://maps.googleapis.com/maps/api/geocode/json?address=$encoded_location&key=$google_api_key";
    $geocode_data = file_get_contents($geocode_url);
    $geocode_json = json_decode($geocode_data, true);

    // Verifica se a resposta tem resultados
    if ($geocode_json['status'] == 'OK') {
        $lat = $geocode_json['results'][0]['geometry']['location']['lat'];
        $lng = $geocode_json['results'][0]['geometry']['location']['lng'];
        $formatted_address = $geocode_json['results'][0]['formatted_address'];
    } else {
        // Se não encontrar a localização, exibe uma mensagem de erro
        $formatted_address = 'Localização não encontrada, por favor verifique o endereço.';
    }
} else {
    // Se a localização não for informada, exibe uma mensagem
    $formatted_address = 'Nenhuma localização foi fornecida';
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Espaço Livre</title>
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <!-- CSS personalizado -->
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <!-- Bootstrap JS Bundle (incluso o Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Google Maps API -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_API_KEY&libraries=places,directions&callback=initMap" async defer></script>

  <style>
    #map {
      height: 400px;
      width: 100%;
    }
    
        .filter-form {
          margin: 20px 0;
        }
        
        .results-list {
          margin-top: 20px;
        }

        .result-item {
          border: 1px solid #ddd;
          padding: 10px;
          margin-bottom: 10px;
        }
        
        .result-item p {
          margin: 0;
        }
        
        .route-button {
          margin-top: 10px;
          background-color: #007bff;
          color: white;
          padding: 5px 15px;
          cursor: pointer;
        }
        
        /* Melhoria na interface */
        .btn-primary:hover {
          background-color: #0056b3;
        }
        
        .result-item:hover {
          background-color: #f8f9fa;
          cursor: pointer;
        }
        
        /* Estilo para mensagens de erro */
        .error-message {
          color: red;
          font-size: 16px;
          margin-top: 20px;
        }
    </style>
</head>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">Espaço<br>Livre</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="#hero">Sobre</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#user">Suporte</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-primary text-black" href="login.php">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<body>
  <div class="container">
    <h1>Resultado da Busca</h1>
    <p>Localização: <?php echo htmlspecialchars($formatted_address); ?></p>

    <!-- Filtro de Raio e Tipo de Estacionamento -->
    <form class="filter-form" action="busca.php" method="GET">
      <label for="radius">Raio de Busca: </label>
            <select id="radius" name="radius">
                <option value="1000" <?php echo ($radius == 1000 ? 'selected' : ''); ?>>1 km</option>
                <option value="3000" <?php echo ($radius == 3000 ? 'selected' : ''); ?>>3 km</option>
                <option value="5000" <?php echo ($radius == 5000 ? 'selected' : ''); ?>>5 km</option>
                <option value="10000" <?php echo ($radius == 10000 ? 'selected' : ''); ?>>10 km</option>
            </select>
            <label for="type">Tipo de Estacionamento: </label>
            <select id="type" name="type">
                <option value="parking" <?php echo ($type == 'parking' ? 'selected' : ''); ?>>Estacionamento</option>
                <option value="restaurant" <?php echo ($type == 'restaurant' ? 'selected' : ''); ?>>Restaurante</option>
                <option value="gym" <?php echo ($type == 'gym' ? 'selected' : ''); ?>>Academia</option>
            </select>
            <button type="submit" class="btn btn-primary">Aplicar Filtro</button>
        </form>

        <!-- Mapa -->
        <div id="map"></div>

        <!-- Lista de Estacionamentos -->
        <div class="results-list" id="results-list"></div>

        <!-- Mensagem de erro se não houver resultados -->
        <div id="error-message" class="error-message" style="display:none;">
            Nenhum estacionamento encontrado nas proximidades.
        </div>

        <script>
            let map, service, infowindow;
            let resultsList = document.getElementById('results-list');
            let errorMessage = document.getElementById('error-message');

            // Função para inicializar o mapa
            function initMap() {
                const location = { lat: <?php echo $lat ? $lat : -23.550520; ?>, lng: <?php echo $lng ? $lng : -46.633308; ?> };

                map = new google.maps.Map(document.getElementById('map'), {
                    center: location,
                    zoom: 14
                });

                infowindow = new google.maps.InfoWindow();

                service = new google.maps.places.PlacesService(map);
                service.nearbySearch({
                    location: location,
                    radius: <?php echo $radius; ?>,
                    type: '<?php echo $type; ?>'
                }, function(results, status) {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        resultsList.innerHTML = '';
                        results.forEach(function(place) {
                            const marker = new google.maps.Marker({
                                position: place.geometry.location,
                                map: map
                            });

                            google.maps.event.addListener(marker, 'click', function() {
                                infowindow.setContent(place.name);
                                infowindow.open(map, this);
                            });

                            // Adiciona os resultados à lista
                            const listItem = document.createElement('div');
                            listItem.classList.add('result-item');
                            listItem.innerHTML = `
                                <h5>${place.name}</h5>
                                <p>${place.vicinity}</p>
                                <button class="route-button" onclick="showDirections(${place.geometry.location.lat()}, ${place.geometry.location.lng()})">Traçar Rota</button>
                            `;
                            resultsList.appendChild(listItem);
                        });
                    } else {
                        errorMessage.style.display = 'block';
                    }
                });
            }

            // Função para traçar a rota
            function showDirections(destLat, destLng) {
                const directionsService = new google.maps.DirectionsService();
                const directionsRenderer = new google.maps.DirectionsRenderer();
                directionsRenderer.setMap(map);

                const request = {
                    origin: { lat: <?php echo $lat ? $lat : -23.550520; ?>, lng: <?php echo $lng ? $lng : -46.633308; ?> },
                    destination: { lat: destLat, lng: destLng },
                    travelMode: google.maps.TravelMode.DRIVING
                };

                directionsService.route(request, function(result, status) {
                    if (status === google.maps.DirectionsStatus.OK) {
                        directionsRenderer.setDirections(result);
                    } else {
                        alert('Não foi possível traçar a rota. Tente novamente.');
                    }
                });
            }

            window.onload = initMap;
        </script>
    </div>
</body>

</html>
