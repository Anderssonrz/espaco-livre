<?php
// require_once("conexao-bd.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
    <!-- Título -->
    <?php
  $pageTitle = 'Espaço Livre - Encontre o Estacionamento Ideal';
  require_once 'components/head.php';
  
?>

<body>

  <!-- Navbar -->
  <?php require_once 'components/navbar.php'; ?>

  <!-- Seção Hero -->
  <section id="hero" class="pt-0" style="height: 100vh; background-image: url('assets/img/slide/map.jpg'); background-size: cover; background-position: center;">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-inner">
        <div class="carousel-item active" style="height: 100%; display: flex; align-items: center; padding-top: 15vh;">
          <div class="container text-center">
            <h1 class="display-4 text-back">Localize Vagas de Estacionamento</h1>
            <p class="lead text-back">Encontre e reserve o estacionamento perfeito para você.</p>
            <form id="search-form" class="row g-3 justify-content-center" action="busca.php" method="GET">
              <div class="col-md-8 col-lg-6">
                <input type="text" class="form-control" placeholder="Digite sua localização ou destino" name="localizacao" required aria-label="Buscar localização">
              </div>
              <div class="col-md-4 col-lg-2">
                <button type="submit" class="btn btn-primary btn-lg" aria-label="Buscar estacionamentos perto de você">Buscar</button>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="search-spinner" style="display:none;"></span>
              </div>
            </form>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev" aria-label="Anterior">
        <span class="carousel-control-prev-icon bi bi-chevron-left"></span>
      </a>
      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next" aria-label="Próximo">
        <span class="carousel-control-next-icon bi bi-chevron-right"></span>
      </a>
    </div>
  </section>

  <!-- Seção "Estacione Fácil em Jaraguá" -->
  <section id="estacionar-facil" class="relative bg-white text-center py-5" style="background-color: #f8f9fa;">
  <div class="container mx-auto px-4">
  <div class="max-w-2xl mx-auto">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-8 col-lg-6 text-center">
          <h2 class="text-4xl font-bold text-gray-800">Alugue e Ganhe com Vagas Livres</h2>
          <h3 class="text-xl mt-4 text-gray-600">
            Transforme espaços vazios em lucro. Descubra o poder de compartilhar vagas e ganhe mais hoje mesmo!
            Estacione com liberdade . Espaço Livre conecta pessoas a vagas reais, sem complicação.
            Espaços confiáveis, onde e quando precisar. Simplifique suas paradas e aproveite a cidade sem estresse.
            Viva a praticidade no cotidiano urbano. Confie, estacione e siga sua jornada com tranquilidade que merece.
          </h3>
        </div>
      </div>
    </div>



  <!-- Seção de Imagens e Benefícios -->
  <section id="estacionar-facil" class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
      <div class="text-center max-w-3xl mx-auto">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8">ESTACIONAMENTOS SIMPLES E SEGURO</h2>
        <div class="row g-4">
          <div class="col-md-3">
            <img src="../assets/img/slide/estacionamentogrande.jpg" alt="Reserva Fácil de Vagas" class="img-fluid" title="Estacionamento Simples e Seguro">
            <h4 class="text-lg font-semibold text-gray-700 mb-2">Reserva Fácil de Vagas</h4>
            <p class="text-gray-500">Encontre e reserve vagas de estacionamento em minutos, sem complicações.</p>
          </div>
          <div class="col-md-3">
            <img src="../assets/img/slide/gestora.jpg" alt="Gestão de Espaços Ocupados" class="img-fluid" title="Gestão de Espaços Ocupados">
            <h4 class="text-lg font-semibold text-gray-700 mb-2">Gestão de Espaços Ocupados</h4>
            <p class="text-gray-500">Controle total sobre suas vagas, maximizando o uso eficiente do espaço.</p>
          </div>
          <div class="col-md-3">
            <img src="../assets/img/slide/criança.jpg" alt="Pagamentos Seguros" class="img-fluid" title="Pagamentos Seguros e Simples">
            <h4 class="text-lg font-semibold text-gray-700 mb-2">Pagamentos Seguros e Simples</h4>
            <p class="text-gray-500">Facilite transações com nosso sistema de pagamentos, rápido e confiável.</p>
          </div>
          <div class="col-md-3">
            <img src="../img/slide/tablet.jpg" alt="Monitoramento em Tempo Real" class="img-fluid" title="Monitoramento em Tempo Real">
            <h4 class="text-lg font-semibold text-gray-700 mb-2">Monitoramento em Tempo Real</h4>
            <p class="text-gray-500"> Acompanhe todas as reservas e a disponibilidade das vagas em tempo real.</p>
          </div>
        </div>
      </div>
  </section>

  <!-- slides -->
  <section id="hero">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

      <div class="carousel-inner" role="listbox">

        <!-- Slide 1 -->
        <div class="carousel-item active" style="background-image: url(../assets/img/slide/celular.jpg)">
          <div class="carousel-container">
            <div class="container">
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item" style="background-image: url(../assets/img/slide/bike.png)">
          <div class="carousel-container">
            <div class="container">
            </div>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item" style="background-image: url(../assets/img/slide/ciclista.jpg)">
          <div class="carousel-container">
            <div class="container">

            </div>
          </div>
        </div>
        <!-- Slide 5 -->
        <div class="carousel-item" style="background-image: url(../assets/img/slide/onibus.jpg)">
          <div class="carousel-container">
            <div class="container">

            </div>
          </div>
        </div>
        <!-- Slide 5 -->
        <div class="carousel-item" style="background-image: url(../assets/img/slide/eletrico.jpg)">
          <div class="carousel-container">
            <div class="container">

            </div>
          </div>
        </div>

      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>
    </div>
  </section>

  <!-- Botões de Navegação (setas) -->
  <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Próximo</span>
  </button>
  </section>

  <!-- Estacionamento Fácil e Compartilhado -->
  <section id="compartilhado" class="py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h2 class="text-primary mb-4">Estacionamento Fácil e Compartilhado</h2>
          <h4 class="lead mb-4">
            Espaço Livre é uma inovadora plataforma de estacionamento compartilhado, localizada em Jaraguá do Sul, SC. Nossa missão é transformar a maneira como você estaciona, oferecendo soluções práticas e sustentáveis que atendem às suas necessidades diárias. Conectamos motoristas a vagas de estacionamento subutilizadas, promovendo eficiência e conveniência na sua rotina.
          </h4>

        </div>
        <div class="col-md-6">
          <img src="../assets/img/slide/estacionamentogrande.jpg" alt="Reserva Fácil de Vagas" class="img-fluid rounded shadow-lg" title="Estacionamento Simples e Seguro">
        </div>
      </div>
    </div>
  </section>


  <!-- Carrossel de Depoimentos -->
  <section id="feedbacks" class="py-5 bg-light">
    <div class="container text-center">
      <div id="feedbackCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicadores do Carrossel -->
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#feedbackCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#feedbackCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#feedbackCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <p>"Espaço Livre é a solução perfeita para estacionar em Jaraguá do Sul! A plataforma é fácil de usar, com opções convenientes e seguras. Adoro a flexibilidade e a economia que oferece. Simplesmente essencial para qualquer motorista na cidade!" - Mariana Costa</p>
          </div>
          <div class="carousel-item">
            <p>"A Espaço Livre revolucionou minha experiência de estacionamento em Jaraguá do Sul! A plataforma é intuitiva, segura e sempre oferece ótimas opções próximas dos meus compromissos. Estou muito satisfeito com a praticidade e economia que proporciona!" - Rafael Lemos</p>
          </div>
          <div class="carousel-item">
            <p>"Descobri a Espaço Livre e minha rotina de estacionamento nunca foi tão fácil! Com opções seguras e acessíveis em Jaraguá do Sul, sempre encontro vagas próximas aos meus destinos. Recomendo para todos que buscam praticidade e economia." - Lucas Silva</p>
          </div>
        </div>
        <!-- Controles do Carrossel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Próximo</span>
        </button>
      </div>
    </div>
  </section>



  <!-- Dúvidas Frequentes -->
  <section id="duvidas" class="py-5">
    <div class="container">
      <h2 class="text-center">Dúvidas Claras? Descubra Aqui</h2>
      <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
              O que é Espaço Livre?
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Espaço Livre é uma plataforma de estacionamento compartilhado que conecta motoristas a vagas disponíveis.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Como funciona a plataforma de estacionamento compartilhado?
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Os usuários podem procurar e reservar vagas disponíveis através do nosso aplicativo ou site, tornando o estacionamento mais fácil e conveniente.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Quais são as vantagens de usar Espaço Livre?
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Oferecemos economia de tempo e dinheiro, além de proporcionar maior comodidade ao encontrar vagas rapidamente em Jaraguá do Sul.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingFour">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
              É seguro compartilhar minha vaga de estacionamento?
            </button>
          </h2>
          <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Sim, garantimos uma transação segura com verificações de segurança para proteger tanto os proprietários quanto os motoristas.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingFive">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
              Como posso me cadastrar no Espaço Livre?
            </button>
          </h2>
          <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Para se cadastrar, basta baixar nosso aplicativo ou acessar nosso site e seguir as instruções para criar uma conta.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Rodapé -->
   <?php require_once 'components/footer.php'; ?>

  <!-- Scripts principais -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>

  <script>
    // Exemplo para mostrar o spinner enquanto o formulário está sendo enviado
    document.querySelector('#search-form').addEventListener('submit', function() {
      document.getElementById('search-spinner').style.display = 'inline-block';
    });

    document.addEventListener("DOMContentLoaded", function() {
      const lazyImages = document.querySelectorAll("img.lazy");
      const lazyLoad = (image) => {
        image.src = image.dataset.src;
        image.classList.add("loaded");
      };

      const imgOptions = {
        threshold: 0,
        rootMargin: "0px 0px 100px 0px"
      };
      const imgObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            lazyLoad(entry.target);
            imgObserver.unobserve(entry.target);
          }
        });
      }, imgOptions);

      lazyImages.forEach((img) => {
        imgObserver.observe(img);
      });
    });
  </script>
</body>

</html>