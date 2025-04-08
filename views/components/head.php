<!-- head.php -->
<head>
  <!-- Meta Tags de SEO -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Encontre e reserve o estacionamento ideal com Espaço Livre - Fácil, rápido e seguro.">
  <meta name="keywords" content="aluguel de estacionamento, ganhar com vagas livres, transformar espaço vazio em lucro, compartilhar vagas de estacionamento, alugar vaga de estacionamento, airBNB de estacionamento, Jaraguá do Sul estacionamento, Espaço Livre estacionamento, estacionamento lucrativo, ganhar dinheiro com vagas livres, aluguel de vagas em Jaraguá do Sul, plataforma de aluguel de estacionamento, ganhar dinheiro com estacionamento, estacionamento compartilhado, Espaço Livre SC, plataforma de estacionamento Jaraguá do Sul">
  <meta name="author" content="Espaço Livre">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://seusite.com">

  <!-- Open Graph -->
  <meta property="og:title" content="Espaço Livre - Encontre seu Estacionamento">
  <meta property="og:description" content="Reserve sua vaga de estacionamento em poucos cliques com o melhor custo-benefício.">
  <meta property="og:image" content="assets/img/slide/map.jpg">
  <meta property="og:url" content="https://seusite.com">

  <!-- Twitter -->
  <meta name="twitter:title" content="Espaço Livre - Encontre seu Estacionamento">
  <meta name="twitter:description" content="Reserve sua vaga de estacionamento em poucos cliques com o melhor custo-benefício.">
  <meta name="twitter:card" content="summary_large_image">

  <meta http-equiv="Content-Language" content="pt-BR">

  <!-- Titulo dinamico -->
  <title><?php echo isset($pageTitle) ? $pageTitle : 'Espaço Livre'; ?></title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Ícones Bootstrap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">

  <!-- CSS personalizado -->
  <link rel="stylesheet" href="assets/css/main.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Abel&family=Bebas+Neue&display=swap" rel="stylesheet">

  <!-- Transição suave para hover -->
  <style>
    .nav-link,
    .btn,
    footer a {
      transition: color 0.3s, background-color 0.3s;
    }

    .btn:hover,
    .nav-link:hover {
      background-color: #0069d9;
      transform: scale(1.05);
    }

    .back-to-top:hover {
      color: #007bff;
    }

    .lazy {
      display: none;
    }

    img.lazy.loaded {
      display: block;
      transition: opacity 0.5s ease-in-out;
    }
  </style>
</head>
