const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

document.addEventListener('DOMContentLoaded', function () {
  const loginForm = document.getElementById('login-usuario-form');
  const msgAlertErroLogin = document.getElementById('msgAlertErroLogin');

  loginForm.addEventListener('submit', async function (e) {
    e.preventDefault();

    const dadosForm = new FormData(loginForm);

    const response = await fetch('validar_login.php', {
      method: 'POST',
      body: dadosForm
    });

    const data = await response.json();

    if (data.erro) {
      msgAlertErroLogin.innerHTML = `<div class="alert alert-danger">${data.msg}</div>`;
    } else {
      window.location.href = 'buscaVagas.php'; // Redireciona se login for válido
    }
  });
});
