//exemplo de variavel para colocar no modo escuro a pagina

const themeToggleButton = document.getElementById('theme-toggle');

const currentTheme = localStorage.getItem('theme');
if (currentTheme === 'dark') {
    document.body.classList.add('dark-mode');
}

themeToggleButton.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');

    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
});
document.getElementById("placa").addEventListener("input", function (e) {
    let value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    if (value.length > 3) value = value.slice(0, 3) + '-' + value.slice(3);
    e.target.value = value;
});
document.querySelector("form").addEventListener("submit", function(event) {
    event.preventDefault();
    alert("Veículo cadastrado com sucesso!");
});



