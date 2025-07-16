
//**********************************************************//
//**********************************************************//
function eliminarElemento(elementoID) {
    var elemento = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if(elemento){
        elemento.style.display = "none";
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function recuperarElemento(elementoID, estilo="block") {
    var elemento = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if(elemento){
        elemento.style.display = estilo;
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function rellenarSelect(elementoID, seleccion) {
    var elemento = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if(elemento){
        elemento.value = seleccion;
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function obtenerValoresFieldset(elementoID) {
    var elemento = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if (elemento) {
        // Obtener todos los elementos de entrada dentro del fieldset
        var elementos = elemento.querySelectorAll('input[type="checkbox"]');

        // Cadena de texto para almacenar los valores seleccionados
        var valoresSeleccionados = '';

        // Iterar sobre cada elemento y verificar si está marcado
        elementos.forEach(function(elemento) {
        if (elemento.checked) {
            // Agregar el valor del elemento seguido de una coma y un espacio
            valoresSeleccionados += elemento.value + ', ';
        }
        });

        // Eliminar la última coma y espacio si no hay elementos seleccionados
        if (valoresSeleccionados.length > 0) {
            valoresSeleccionados = valoresSeleccionados.slice(0, -2);
        }

        return valoresSeleccionados;
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function obtenerValorRadio(elementoID) {
    var elemento = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if (elemento) {
        // Obtener todos los elementos de entrada dentro del fieldset
        var elementos = elemento.querySelectorAll('input[type="radio"]');

        // Iterar sobre cada elemento y verificar si está marcado
        elementos.forEach(function(elemento) {
            if (elemento.checked) {
                // Agregar el valor del elemento
                valorSeleccionado = elemento.value;
            }
        });

        return valorSeleccionado;
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function rellenarFieldset(elementoID, seleccion) {
    var elemento = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if (elemento) {
        // Convertimos la cadena de seleccion en un array
        var input = seleccion.split(', ');

        // Iteramos sobre las casillas de verificación en el fieldset
        var checkboxes = elemento.querySelectorAll('input[type="checkbox"]');

        // Recorremos todos los checkbox
        checkboxes.forEach(function (checkbox) {
            // Comprobamos si el valor de la casilla está en el array input
            if (input.includes(checkbox.value)) {
                checkbox.checked = true;
            }
        });
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function rellenarRadio(elementoID, seleccion) {
    var elemento = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if (elemento) {
        // Convertimos la cadena de seleccion en un array
        var input = seleccion;

        // Iteramos sobre las casillas de verificación en el fieldset
        var radios = elemento.querySelectorAll('input[type="radio"]');

        // Recorremos todos los radios
        radios.forEach(function (radio) {
            // Comprobamos si el valor de la casilla está en el array input
            if (input == radio.value) {
                radio.checked = true;
            }
        });
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function habilitarFieldset(elementoID) {
    var fieldset = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if(fieldset){
        // Iteramos sobre las casillas de verificación en el fieldset
        var checkboxes = fieldset.querySelectorAll('input[type="checkbox"]');

        // Recorremos todos los checkbox
        for (var j = 0; j < checkboxes.length; j++) {
            checkboxes[j].removeAttribute('disabled');
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function deshabilitarFieldset(elementoID) {
    var fieldset = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if(fieldset){
        // Iteramos sobre las casillas de verificación en el fieldset
        var checkboxes = fieldset.querySelectorAll('input[type="checkbox"]');

        // Recorremos todos los checkbox
        for (var j = 0; j < checkboxes.length; j++) {
            checkboxes[j].setAttribute('disabled', 'disabled');
        }
    }
}
//**********************************************************//

//**********************************************************//
//**********************************************************//
function habilitarRadio(elementoID) {
    var fieldset = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if(fieldset){
        // Iteramos sobre las casillas de verificación en el fieldset
        var radios = fieldset.querySelectorAll('input[type="radio"]');

        // Recorremos todos los radios
        for (var j = 0; j < radios.length; j++) {
            radios[j].removeAttribute('disabled');
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function deshabilitarRadio(elementoID) {
    var fieldset = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if(fieldset){
        // Iteramos sobre las casillas de verificación en el fieldset
        var radios = fieldset.querySelectorAll('input[type="radio"]');

        // Recorremos todos los radios
        for (var j = 0; j < radios.length; j++) {
            radios[j].setAttribute('disabled', 'disabled');
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function habilitarPasos(numPasosID, pasoID) {
    var paso = document.getElementById(pasoID);

    // Comprobamos que al menos un paso existe
    if(paso){
        var numPasos = document.getElementById(numPasosID).value;

        for (var i = 1; i <= numPasos; i++) {
            if(document.getElementById("paso_descripcion_" + i)){
                document.getElementById("paso_descripcion_" + i).removeAttribute('disabled');
                document.getElementById("paso_video_" + i).removeAttribute('disabled');
                document.getElementById("paso_foto_" + i).removeAttribute('disabled');
                document.getElementById("paso_audio_" + i).removeAttribute('disabled');
                document.getElementById("eliminar_paso_" + i).removeAttribute('disabled');
            }
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function deshabilitarPasos(numPasosID, pasoID) {
    var paso = document.getElementById(pasoID);

    // Comprobamos que al menos un paso existe
    if(paso){
        var numPasos = document.getElementById(numPasosID).value;
        
        for (var i = 1; i <= numPasos; i++) {
            if(document.getElementById("paso_descripcion_" + i)){
                document.getElementById("paso_descripcion_" + i).setAttribute('disabled', 'disabled');
                document.getElementById("paso_video_" + i).setAttribute('disabled', 'disabled');
                document.getElementById("paso_foto_" + i).setAttribute('disabled', 'disabled');
                document.getElementById("paso_audio_" + i).setAttribute('disabled', 'disabled');
                document.getElementById("eliminar_paso_" + i).setAttribute('disabled', 'disabled');
            }
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function eliminarElementoPaso(elementoID, numPasosID) {
    var elementoNumPasos = document.getElementById(numPasosID);

    // Comprobamos que el elemento existe
    if(elementoNumPasos){
        var numPasos = document.getElementById(numPasosID).value;

        for(var i = 1; i <= numPasos; i++){
            if(document.getElementById(elementoID + i)){
                document.getElementById(elementoID + i).style.display = "none";
            }
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function recuperarElementoPaso(elementoID, numPasosID, estilo="block") {
    var elementoNumPasos = document.getElementById(numPasosID);
    var contadorPasos = 0;

    // Comprobamos que el elemento existe
    if(elementoNumPasos){
        var numPasos = document.getElementById(numPasosID).value;

        // Recorremos todos los pasos para ver si es el último que queda o no
        for(var i = 1; i <= numPasos; i++){
            if(document.getElementById(elementoID + i)){
                contadorPasos++;
            }
        }

        // Iteramos ahora para recuperar el elemento del paso
        if(contadorPasos > 1){
            for(var i = 1; i <= numPasos; i++){
                if(document.getElementById(elementoID + i)){
                    document.getElementById(elementoID + i).style.display = estilo;
                }
            }
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function habilitarPictogramas(pictogramasID) {
    var campo = document.getElementById(pictogramasID);

    // Comprobamos que al menos el campo existe
    if(campo){
        var numPictogramas = 3;

        for (var i = 1; i <= numPictogramas; i++) {
            if(document.getElementById("pictograma_" + i)){
                document.getElementById("pictograma_" + i).removeAttribute('disabled');
            }
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function deshabilitarPictogramas(pictogramasID) {
    var campo = document.getElementById(pictogramasID);

    // Comprobamos que al menos el campo existe
    if(campo){
        var numPictogramas = 3;
        
        for (var i = 1; i <= numPictogramas; i++) {
            if(document.getElementById("pictograma_" + i)){
                document.getElementById("pictograma_" + i).setAttribute('disabled', 'disabled');
            }
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function habilitarPulsadores(pulsadoresID) {
    var campo = document.getElementById(pulsadoresID);

    // Comprobamos que al menos el campo existe
    if(campo){
        if(document.getElementById("pictograma_pulsadores")){
            document.getElementById("pictograma_pulsadores").removeAttribute('disabled');
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function deshabilitarPulsadores(pulsadoresID) {
    var campo = document.getElementById(pulsadoresID);

    // Comprobamos que al menos el campo existe
    if(campo){
        if(document.getElementById("pictograma_pulsadores")){
            document.getElementById("pictogramapictograma_pulsadores").setAttribute('disabled', 'disabled');
        }
    }
}
//**********************************************************//
