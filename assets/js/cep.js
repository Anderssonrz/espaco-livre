document.addEventListener('DOMContentLoaded', function () {
    const cepInput = document.getElementById('cep');
    const ruaInput = document.getElementById('endereco');
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    const estadoSelect = document.getElementById('id_uf'); // Seu select de estado

    if (cepInput) {
        cepInput.addEventListener('blur', function () { // Quando o campo CEP perde o foco
            const cep = this.value.replace(/\D/g, ''); // Remove não-dígitos

            if (cep.length === 8) {
                // Mostra um feedback visual de carregamento (opcional)
                // Ex: cepInput.classList.add('loading');

                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Falha na requisição do CEP: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // cepInput.classList.remove('loading'); // Remove feedback de carregamento
                        if (!data.erro) {
                            if (ruaInput) ruaInput.value = data.logradouro || '';
                            if (bairroInput) bairroInput.value = data.bairro || '';
                            if (cidadeInput) cidadeInput.value = data.localidade || '';

                            if (estadoSelect && data.uf) {
                                let achouEstado = false;
                                for (let i = 0; i < estadoSelect.options.length; i++) {
                                    // Usando o atributo data-uf que adicionamos aos options
                                    if (estadoSelect.options[i].dataset.uf === data.uf) {
                                        estadoSelect.value = estadoSelect.options[i].value;
                                        achouEstado = true;
                                        break;
                                    }
                                }
                                if (!achouEstado) {
                                    console.warn('UF (' + data.uf + ') retornada pela API de CEP não encontrada no select de estados.');
                                }
                            }
                            // Focar no próximo campo relevante, por exemplo, número
                            const numeroInput = document.getElementById('numero');
                            if (numeroInput) numeroInput.focus();

                        } else {
                            // Limpar campos se o CEP não for encontrado ou tiver erro, exceto o próprio CEP
                            if (ruaInput) ruaInput.value = '';
                            if (bairroInput) bairroInput.value = '';
                            if (cidadeInput) cidadeInput.value = '';
                            if (estadoSelect) estadoSelect.value = ''; // Limpa a seleção
                            // alert('CEP não encontrado.'); // Considere um feedback menos intrusivo
                            console.warn('CEP não encontrado pela API ViaCEP.');
                        }
                    })
                    .catch(error => {
                        // cepInput.classList.remove('loading'); // Remove feedback de carregamento
                        console.error('Erro ao buscar CEP:', error);
                        // alert('Não foi possível buscar o CEP. Verifique sua conexão ou tente novamente.');
                    });
            } else if (cep.length > 0 && cep.length < 8) {
                console.warn('CEP incompleto.');
                // Poderia adicionar um feedback visual para CEP incompleto
            }
        });
    }
});

(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
})()

// jQuery Mask (garanta que jQuery e jQuery Mask Plugin estejam carregados)
$(document).ready(function () {
    if (typeof $.fn.mask === 'function') {
        $('#telefone').mask('(00) 00000-0000');
        $('#CPF').mask('000.000.000-00', {
            reverse: true
        });
        $('#cep').mask('00000-000');
        $('#preco').mask('#.##0,00', {
            reverse: true,
            placeholder: "0,00"
        });
        // Se tiver outros campos para mascarar, adicione aqui. Ex:
        // $('#telefone_contato').mask('(00) 00000-0000');
    } else {
        console.warn('jQuery Mask Plugin não está carregado.');
    }
});
