document.addEventListener('DOMContentLoaded', function () {
    var priceSlider = document.getElementById('price-slider');
    var minPriceInput = document.getElementById('min-price-input');
    var maxPriceInput = document.getElementById('max-price-input');
    var minValueDisplay = document.getElementById('slider-min-value-display');
    var maxValueDisplay = document.getElementById('slider-max-value-display');

    // Define os valores globais para o slider (você pode ajustar)
    var SLIDER_MIN_VAL = 0;
    var SLIDER_MAX_VAL = 1000; // Corresponde ao max dos seus inputs number
    var SLIDER_STEP = 10;     // Corresponde ao step dos seus inputs number

    // Pega os valores iniciais dos inputs (que foram definidos pelo PHP)
    var initialMin = parseFloat(minPriceInput.value) || SLIDER_MIN_VAL;
    var initialMax = parseFloat(maxPriceInput.value) || SLIDER_MAX_VAL / 2; // Ex: 500 se max for 1000

    noUiSlider.create(priceSlider, {
        start: [initialMin, initialMax], // Posições iniciais das alças [min, max]
        connect: true,          // Colore a barra entre as alças
        step: SLIDER_STEP,
        range: {
            'min': SLIDER_MIN_VAL,
            'max': SLIDER_MAX_VAL
        },
        format: { // Para garantir que os valores sejam tratados como inteiros (ou floats se precisar)
            to: function (value) {
                return parseInt(value);
            },
            from: function (value) {
                return parseInt(value);
            }
        },
        // Para acessibilidade e tooltips (opcional, mas recomendado)
        pips: { // Mostra marcações e valores na barra (opcional)
             mode: 'positions',
             values: [0, 25, 50, 75, 100],
             density: 4,
             format: {
                 to: function(value) { return '$' + value; }
             }
        }
    });

    // Evento 'update': Chamado sempre que o slider muda (arrastando ou programaticamente)
    priceSlider.noUiSlider.on('update', function (values, handle) {
        var value = values[handle];
        if (handle === 0) { // Alça da esquerda (valor mínimo)
            minPriceInput.value = value;
            if(minValueDisplay) minValueDisplay.textContent = '$' + value;
        } else { // Alça da direita (valor máximo)
            maxPriceInput.value = value;
            if(maxValueDisplay) maxValueDisplay.textContent = '$' + value;
        }
    });

    // Evento 'change': Chamado quando o usuário solta a alça do slider
    // Ideal para não sobrecarregar se você fosse fazer algo a cada 'update'
    // priceSlider.noUiSlider.on('change', function(values, handle){
    //    console.log("Slider mudou para: ", values);
    //    // Aqui você poderia, por exemplo, disparar a submissão do formulário automaticamente
    // });


    // Sincronizar o slider se o input numérico de MÍNIMO for alterado manualmente
    minPriceInput.addEventListener('change', function () {
        // Garante que o valor mínimo não ultrapasse o máximo atual do slider
        var currentMax = parseFloat(priceSlider.noUiSlider.get()[1]);
        var newMin = parseFloat(this.value);
        if (newMin > currentMax) {
            newMin = currentMax; // Ou ajuste o máximo também, dependendo da UX desejada
            this.value = newMin;
        }
        priceSlider.noUiSlider.set([newMin, null]);
    });

    // Sincronizar o slider se o input numérico de MÁXIMO for alterado manualmente
    maxPriceInput.addEventListener('change', function () {
        // Garante que o valor máximo não seja menor que o mínimo atual do slider
        var currentMin = parseFloat(priceSlider.noUiSlider.get()[0]);
        var newMax = parseFloat(this.value);
        if (newMax < currentMin) {
            newMax = currentMin; // Ou ajuste o mínimo também
            this.value = newMax;
        }
        priceSlider.noUiSlider.set([null, newMax]);
    });
});