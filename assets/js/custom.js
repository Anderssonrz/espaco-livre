const loginForm = document.getElementById("login-usuario-form");
const msgAlertErroLogin = document.getElementById("msgAlertErroLogin");
const loginModal = new bootstrap.Modal(document.getElementById("loginModal"));

loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    if (document.getElementById("email").value === "") {
        msgAlertErroLogin.innerHTML = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo usuário!</div>";
    } else if (document.getElementById("senha").value === "") {
        msgAlertErroLogin.innerHTML = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo senha!</div>";
    } else {
        const dadosForm = new FormData(loginForm);

        const dados = await fetch("validar.php", {
            method: "POST",
            body: dadosForm
        });

        const resposta = await dados.json();

        if (resposta['erro']) {
            msgAlertErroLogin.innerHTML = resposta['msg']
        } else {
            document.getElementById("dados-usuario").innerHTML = "Bem vindo" + resposta['dados'].nome + "<br><a href='sair.php'>Sair</a><br>";
            loginForm.reset();
            loginModal.hide();
        }
    }
});

// Seu script custom.js pode conter a lógica para o login via AJAX
document.addEventListener('DOMContentLoaded', function () {
    const btnLogin = document.getElementById('btnLogin');
    const loginForm = document.getElementById('login-usuario-form');
    const msgAlertErroLogin = document.getElementById('msgAlertErroLogin');

    if (btnLogin && loginForm && msgAlertErroLogin) {
        btnLogin.addEventListener('click', async (e) => {
            e.preventDefault();

            const dadosForm = new FormData(loginForm);

            const response = await fetch("validar_login.php", { // Crie este arquivo para validar o login
                method: "POST",
                body: dadosForm,
            });

            const data = await response.json();

            if (data.erro) {
                msgAlertErroLogin.innerHTML = `<div class="alert alert-danger">${data.msg}</div>`;
            } else {
                // Login bem-sucedido, redirecionar ou atualizar a página
                window.location.href = "index.php"; // Redireciona para a página inicial
            }
        });
    }
});

  function toggleDropdown(event) {
    event.preventDefault();
    const dropdown = event.currentTarget.parentElement;
    const menu = dropdown.querySelector(".dropdown-content");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
  }

  // Fecha o dropdown ao clicar fora
  window.addEventListener('click', function (e) {
    const dropdowns = document.querySelectorAll('.dropdown-content');
    dropdowns.forEach(menu => {
      if (!menu.parentElement.contains(e.target)) {
        menu.style.display = 'none';
      }
    });
  });

