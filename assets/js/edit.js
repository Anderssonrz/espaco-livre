// Script para alternar entre visualização e edição do perfil
    const displaySection = document.getElementById('perfil-display-section');
    const editFormSection = document.getElementById('perfil-edit-form-section');
    const btnShowEditForm = document.getElementById('btnAbrirFormEditarPerfil');
    const btnCancelEdit = document.getElementById('btnCancelarEdicaoPerfil');
    const formEditarPerfil = document.getElementById('formEditarPerfilReal'); // ID do form

    if (btnShowEditForm && displaySection && editFormSection) {
        btnShowEditForm.addEventListener('click', function() {
            displaySection.style.display = 'none';
            editFormSection.style.display = 'block';
        });
    }

    if (btnCancelEdit && displaySection && editFormSection) {
        btnCancelEdit.addEventListener('click', function() {
            editFormSection.style.display = 'none';
            displaySection.style.display = 'block';
            
            // Opcional: Reseta o formulário para os valores originais carregados pelo PHP
            if (formEditarPerfil) {
                formEditarPerfil.reset();
                // Remove classes de validação do Bootstrap se o formulário foi tentado e cancelado
                formEditarPerfil.classList.remove('was-validated');
            }
        });
    }

    // Ajuste para aplicar máscaras nos novos IDs do formulário de edição
    // Isso pode ficar dentro do seu $(document).ready() existente
    if (typeof $.fn.mask === 'function') {
        $('#edit-telefone').mask('(00) 00000-0000');
        $('#edit-cpf').mask('000.000.000-00', { 
            reverse: true });
    }