// --- Início do código para a página 'account.php' ---

// Aguarda o DOM (a estrutura da página) estar completamente carregado para executar o código
document.addEventListener('DOMContentLoaded', function () {
    
    // --- Seletores para os elementos da página de perfil ---
    // Cada constante pega uma 'div' ou 'button' pelo seu ID único.
    const displaySection = document.getElementById('perfil-display-section');
    const editProfileFormSection = document.getElementById('perfil-edit-form-section');
    const editPasswordFormSection = document.getElementById('senha-edit-form-section');

    const btnShowProfileForm = document.getElementById('btnAbrirFormEditarPerfil');
    const btnShowPasswordForm = document.getElementById('btnAbrirFormEditarSenha');

    const btnCancelProfileEdit = document.getElementById('btnCancelarEdicaoPerfil');
    const btnCancelPasswordEdit = document.getElementById('btnCancelarEdicaoSenha');

    // --- Função para gerenciar qual seção está visível ---
    // Esta função centraliza a lógica para evitar repetição de código.
    function showSection(sectionToShow) {
        // Esconde todas as seções primeiro
        if (displaySection) displaySection.style.display = 'none';
        if (editProfileFormSection) editProfileFormSection.style.display = 'none';
        if (editPasswordFormSection) editPasswordFormSection.style.display = 'none';
        
        // Mostra apenas a seção desejada que foi passada como parâmetro
        if (sectionToShow) sectionToShow.style.display = 'block';
    }

    // --- Eventos de Clique para os Botões ---

    // Evento do botão "Editar Perfil"
    if (btnShowProfileForm) {
        btnShowProfileForm.addEventListener('click', function () {
            showSection(editProfileFormSection); // Mostra o formulário de edição de perfil
        });
    }

    // Evento do botão "Alterar Senha"
    if (btnShowPasswordForm) {
        btnShowPasswordForm.addEventListener('click', function () {
            showSection(editPasswordFormSection); // Mostra o formulário de edição de senha
        });
    }

    // Evento do botão "Cancelar" do formulário de perfil
    if (btnCancelProfileEdit) {
        btnCancelProfileEdit.addEventListener('click', function () {
            showSection(displaySection); // Volta para a seção de visualização
            const form = document.getElementById('formEditarPerfilReal');
            if (form) {
                form.reset(); // Limpa quaisquer alterações não salvas
                form.classList.remove('was-validated'); // Remove feedback de validação do Bootstrap
            }
        });
    }

    // Evento do botão "Cancelar" do formulário de senha
    if (btnCancelPasswordEdit) {
        btnCancelPasswordEdit.addEventListener('click', function () {
            showSection(displaySection); // Volta para a seção de visualização
            const form = document.getElementById('formAlterarSenhaReal');
            if (form) {
                form.reset(); // Limpa os campos de senha
                form.classList.remove('was-validated');
            }
        });
    }
});


// --- Código que depende de jQuery (como as máscaras) ---
// É uma boa prática manter isso dentro de um bloco ready() do jQuery
// para garantir que a biblioteca jQuery já foi carregada.
$(document).ready(function() {
    // Verifica se a função 'mask' do plugin jQuery Mask está disponível
    if (typeof $.fn.mask === 'function') {
        // Aplica máscaras aos campos do formulário de edição de perfil
        $('#edit-telefone').mask('(00) 00000-0000');
        $('#edit-cpf').mask('000.000.000-00', { reverse: true });
    } else {
        console.warn('Plugin jQuery Mask não está carregado.');
    }
});