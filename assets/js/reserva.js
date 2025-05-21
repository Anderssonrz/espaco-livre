document.addEventListener('DOMContentLoaded', () => {
    const botoesReservar = document.querySelectorAll('.botao-reservar'); 

    botoesReservar.forEach(botao => {
        botao.addEventListener('click', async (Event) => {
            const vagaId = Event.target.dataset.vagaId; 
            
            // Supondo que você tenha uma forma de obter o ID do usuário logado
            const usuarioId = obterUsuarioLogadoId();

            if (!usuarioId) {
                alert('Você precisa estar logado para reservar uma vaga.');
                return;
            }

            try { 
            const response = await fetch('/api/reservas', { // Sua rota de backend para reservas
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // Adicione aqui o token de autenticação, se necessário
                },
                body: JSON.stringify({ vaga_id: vagaId, usuario_id: usuarioId }),                
            });

            const data = await response.json();

            if (response.ok) {
                alert(data.message || 'Vaga reservada com sucesso!');
                // Atualize a interface para refletir a reserva (desabilitar o botão, mudar o status, etc.)
                Event.target.disabled = true;
                Event.target.textContent = 'Reservado';
            } else {
                alert(data.error || 'Não foi possével reservar a vaga.');
            }
            } catch (error) {
                console.error('Erro ao reservar vaga:', error);
                alert('Ocorreu um erro ao tentar reservar a vaga.');
            }
        });
    });


//Função fictícia para obter o ID do usuário logado (você precisará implementar isso)
function obterUsuarioLogadoId() {
    //Lógica para obter o ID do usuário da sua sessão, cookie, local storage, etc.
    //Por exemplo:
    return localStorage.getItem('usuarioId');
    return 123; // Retorno fixo para exemplo
  }

});