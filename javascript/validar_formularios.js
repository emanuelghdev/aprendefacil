
//*****************************************************************************************************//
//*****************************************************************************************************//
function validarFormularioRegistroProfesor(event, tipo) {
    // Obtenemos los nombres de cada campo del formulario
    var nombreNombre = 'nombre' + tipo;
    var nombreApellidos = 'apellidos' + tipo;
    var nombreRutaFoto = 'ruta_foto' + tipo;
    var nombreAula = 'aula' + tipo;
    var nombreUsuario = 'usuario' + tipo;
    var nombrePassword = 'password' + tipo;
    var nombreConfirmarPassword = 'password-confirm' + tipo;

    // Obtenemos los valores de los campos del formulario
    var nombre = document.getElementById(nombreNombre).value;
    var apellidos = document.getElementById(nombreApellidos).value;
    var rutaFoto = document.getElementById(nombreRutaFoto).value;
    var aula = document.getElementById(nombreAula).value;
    var usuario = document.getElementById(nombreUsuario).value;
    var password = document.getElementById(nombrePassword).value;
    var confirmarPassword = document.getElementById(nombreConfirmarPassword).value;

    // Hacemos estas asignaciones para que se ejecuten enteramente cada funcion validar
    var nombreValido = validarNombreYApellidos(nombre, nombreNombre, tipo);		            // Validamos el nombre
    var apellidosValido = validarNombreYApellidos(apellidos, nombreApellidos, tipo);		// Validamos los apellidos
    var rutaFotoValido = validarRutaFoto(rutaFoto, nombreRutaFoto, tipo);		            // Validamos la ruta de la imagen
    var aulaValido = validarAula(aula, nombreAula, tipo);		                            // Validamos el aula
    var usuarioValido = validarUsuario(usuario, nombreUsuario, tipo);		                // Validamos el nombre de usuario
    var passwordValido = validarPassword(password, nombrePassword, tipo);	                // Validamos la contraseña
    var confirmarPasswordValido = validarConfirmacionPassword(confirmarPassword, nombreConfirmarPassword, password, tipo);	                // Validamos la confirmación de la contraseña

    // Comprobamos si es valido todo el formulario, si no lo es no se envían los datos
    if(nombreValido && apellidosValido && rutaFotoValido && aulaValido && usuarioValido && passwordValido && confirmarPasswordValido){
        return true;
    }
    else{
        // Evitamos que los datos se envíen
        event.preventDefault();
        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarFormularioRegistroAlumno(event, tipo) {
    // Obtenemos los nombres de cada campo del formulario
    var nombreNombre = 'nombre' + tipo;
    var nombreApellidos = 'apellidos' + tipo;
    var nombreAula = 'aula' + tipo;
    var nombreRutaFoto = 'ruta_foto' + tipo;
    var nombrePassword = 'password' + tipo;
    var nombreConfirmarPassword = 'password-confirm' + tipo;
    var fieldsetPerfil = 'fieldset-perfil_visualizacion' + tipo;
    var fieldsetTipo = 'fieldset-tipo_password' + tipo;
    var nombrePictograma1 = 'pictograma_1' + tipo;
    var nombrePictograma2 = 'pictograma_2' + tipo;
    var nombrePictograma3 = 'pictograma_3' + tipo;
    var nombrePictogramaPulsadores = 'pictograma_pulsadores' + tipo;


    // Obtenemos los valores de los campos del formulario
    var nombre = document.getElementById(nombreNombre).value;
    var apellidos = document.getElementById(nombreApellidos).value;
    var aula = document.getElementById(nombreAula).value;
    var rutaFoto = document.getElementById(nombreRutaFoto).value;
    var password = document.getElementById(nombrePassword).value;
    var confirmarPassword = document.getElementById(nombreConfirmarPassword).value;
    var pictograma1 = document.getElementById(nombrePictograma1).value;
    var pictograma2 = document.getElementById(nombrePictograma2).value;
    var pictograma3 = document.getElementById(nombrePictograma3).value;
    var pictogramaPulsadores = document.getElementById(nombrePictogramaPulsadores).value;
    

    // Hacemos estas asignaciones para que se ejecuten enteramente cada funcion validar
    var nombreValido = validarNombreYApellidos(nombre, nombreNombre, tipo);		            // Validamos el nombre
    var apellidosValido = validarNombreYApellidos(apellidos, nombreApellidos, tipo);		// Validamos los apellidos
    var aulaValido = validarAula(aula, nombreAula, tipo);		                            // Validamos el aula
    var rutaFotoValido = validarRutaFoto(rutaFoto, nombreRutaFoto, tipo);		            // Validamos la ruta de la imagen
    var fieldsetPerfilValido = validarFieldset(fieldsetPerfil);                             // Validamos el perfil de visualizacion
    var fieldsetTipoValido = validarRadio(fieldsetTipo);	                                // Validamos el tipo de contraseña

    // Manejamos que la contraseña pueda o no seguir los parametros de validacion al tener el alumno
    // una contraseña tipo pictogramas, y viceversa al tener una contraseña tipo texto
    var valorPassword = obtenerValorRadio(fieldsetTipo);

    // Si el tipo de contraseña no es texto
    if(valorPassword != "texto"){
        passwordValido = true;
        confirmarPasswordValido = true;
    }
    else{
        var passwordValido = validarPassword(password, nombrePassword, tipo);	                // Validamos la contraseña
        var confirmarPasswordValido = validarConfirmacionPassword(confirmarPassword, nombreConfirmarPassword, password, tipo);	                // Validamos la confirmación de la contraseña
    }

    // Si el tipo de contraseña no es pictogramas
    if(valorPassword != "pictograma"){
        pictograma1Valido = true;
        pictograma2Valido = true;
        pictograma3Valido = true;
    }
    else{
        var pictograma1Valido = validarRutaFoto(pictograma1, nombrePictograma1, tipo);	        // Validamos el primer pictograma
        var pictograma2Valido = validarRutaFoto(pictograma2, nombrePictograma2, tipo);	        // Validamos el segundo pictograma
        var pictograma3Valido = validarRutaFoto(pictograma3, nombrePictograma3, tipo);	        // Validamos el tercer pictograma
    }

    // Si el tipo de contraseña no es pulsadores
    if(valorPassword != "pulsadores"){
        pictogramaPulsadoresValido = true;
    }
    else{
        var pictogramaPulsadoresValido = validarRutaFoto(pictogramaPulsadores, nombrePictogramaPulsadores, tipo);	        // Validamos el pictograma para pulsadores
    }
    

    // Comprobamos si es valido todo el formulario, si no lo es no se envían los datos
    if(nombreValido && apellidosValido && rutaFotoValido && aulaValido && passwordValido && confirmarPasswordValido
                    && fieldsetPerfilValido && fieldsetTipoValido && pictograma1Valido && pictograma2Valido && pictograma3Valido 
                    && pictogramaPulsadoresValido){
        return true;
    }
    else{
        // Evitamos que los datos se envíen
        event.preventDefault();
        return false;
    }
}
//*****************************************************************************************************//

//*****************************************************************************************************//
//*****************************************************************************************************//
function validarFormularioRegistroTarea(event, tipo) {
    // Obtenemos los nombres de cada campo del formulario
    var nombreTitulo = 'titulo' + tipo;
    var nombreRutaIcono = 'ruta_icono' + tipo;
    var nombreRutaDocumento = 'ruta_documento' + tipo;

    // Obtenemos los valores de los campos del formulario
    var titulo = document.getElementById(nombreTitulo).value;
    var rutaIcono = document.getElementById(nombreRutaIcono).value;
    var rutaDocumento = document.getElementById(nombreRutaDocumento).value;

    // Hacemos estas asignaciones para que se ejecuten enteramente cada funcion validar
    var tituloValido = validarTexto(titulo, nombreTitulo, tipo);		                        // Validamos el titulo
    var rutaIconoValido = validarRutaFoto(rutaIcono, nombreRutaIcono, tipo);		            // Validamos la ruta del documento
    var rutaDocumentoValido = validarRutaDoc(rutaDocumento, nombreRutaDocumento, tipo);		    // Validamos la ruta del documento

    var numPasos = parseInt(document.getElementById("numero_pasos").value);

    var descripcionValido = new Array(numPasos);
    var videoValido = new Array(numPasos);
    var fotoValido = new Array(numPasos);
    var audioValido = new Array(numPasos);
   
    // Valida cada paso
    for (var i = 1; i <= numPasos; i++) {
        // Comprobamos que el paso existe
        if(document.getElementById("paso_descripcion_" + i)){
            // Obtenemos los nombres de cada campo del paso
            var nombreDescripcion = "paso_descripcion_" + i;
            var nombreVideo = "paso_video_" + i;
            var nombreFoto = "paso_foto_" + i;
            var nombreAudio = "paso_audio_" + i;

            // Obtenemos los valores de los campos del paso
            var descripcion = document.getElementById(nombreDescripcion).value;
            var video = document.getElementById(nombreVideo).value;   
            var foto = document.getElementById(nombreFoto).value;   
            var audio = document.getElementById(nombreAudio).value;   

            // Hacemos estas asignaciones para que se ejecuten enteramente cada funcion validar
            descripcionValido[i] = validarTexto(descripcion, nombreDescripcion, tipo);	            // Validamos la descripcion
            videoValido[i] = validarRutaVideo(video, nombreVideo, tipo);	                        // Validamos la ruta del video
            fotoValido[i] = validarRutaFoto(foto, nombreFoto, tipo);	                            // Validamos la ruta de la foto
            audioValido[i] = validarRutaAudio(audio, nombreAudio, tipo);	                        // Validamos la ruta del audio
            }
    }

    // Comprobamos si es valido todo el formulario, si no lo es no se envían los datos
    if(tituloValido && rutaIconoValido && rutaDocumentoValido &&
                                          descripcionValido.every(function(valor) { return valor === true; }) &&
                                          videoValido.every(function(valor) { return valor === true; }) &&
                                          fotoValido.every(function(valor) { return valor === true; }) &&
                                          audioValido.every(function(valor) { return valor === true; })){
        return true;
    }
    else{
        // Evitamos que los datos se envíen
        event.preventDefault();
        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarFormularioLoginProfesor(event, tipo) {
    // Obtenemos los nombres de cada campo del formulario
    var nombreUsuario = 'usuario' + tipo;
    var nombrePassword = 'password' + tipo;

    // Obtenemos los valores de los campos del formulario
    var usuario = document.getElementById(nombreUsuario).value;
    var password = document.getElementById(nombrePassword).value;

    // Hacemos estas asignaciones para que se ejecuten enteramente cada funcion validar
    var usuarioValido = validarUsuario(usuario, nombreUsuario, tipo);		    // Validamos el nombre como nombre de usuario
    var passwordValido = validarPassword(password, nombrePassword, tipo);		// Validamos la contraseña

    // Comprobamos si es valido todo el formulario, si no lo es no se envían los datos
    if(usuarioValido && passwordValido){
        return true;
    }
    else{
        // Evitamos que los datos se envíen
        event.preventDefault();
        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarFormularioLoginAlumno(event, tipo) {
    // Obtenemos los nombres de cada campo del formulario
    var nombrePassword = 'password' + tipo;

    // Obtenemos los valores de los campos del formulario
    var password = document.getElementById(nombrePassword).value;

    // Hacemos estas asignaciones para que se ejecuten enteramente cada funcion validar
    var passwordValido = validarPasswordAlumno(password, nombrePassword, tipo);		// Validamos la contraseña

    // Comprobamos si es valido todo el formulario, si no lo es no se envían los datos
    if(passwordValido){
        return true;
    }
    else{
        // Evitamos que los datos se envíen
        event.preventDefault();
        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarNombreYApellidos(nombreApellidos, nombreNombreApellidos, tipo) {
    // Usamos la expresión regular /^(?=.*[a-zA-ZáÁéÉíÍóÓúÚüÜ])[\sa-zA-ZáÁéÉíÍóÓúÚüÜ]+$/
    // para verificar que el nombre contenga únicamente letras en minúscula y mayúscula con
    // y sin tilde, espacios y la letra "ü" con diéresis. Además, nos aseguramos de que si hay
    // un espacio, al menos contenga una letra y que haya entre 4 y 100 caracteres.
    if(/^(?=.*[a-zA-ZáÁéÉíÍóÓúÚüÜñÑ])[\sa-zA-ZáÁéÉíÍóÓúÚüÜñÑ]{4,100}$/.test(nombreApellidos)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreNombreApellidos).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreNombreApellidos + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y recuperamos el mensaje de error
        document.getElementById(nombreNombreApellidos).style.borderColor= "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreNombreApellidos + "-incorrecto");

        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarUsuario(usuario, nombreUsuario, tipo) {
    // Usamos la expresión regular /^[\w\-]+$/ para verificar que el nombre de usuario solo
    // contenga letras, números, guiones y guiones bajos. Además verificamos que tenga entre 4 y 30 caracteres
    if(/^[\w\-]{4,30}$/.test(usuario)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreUsuario).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreUsuario + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y recuperamos el mensaje de error
        document.getElementById(nombreUsuario).style.borderColor= "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreUsuario + "-incorrecto");

        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarAula(aula, nombreAula, tipo) {
    // Usamos la expresión regular /^[a-zA-Z0-9áéíóúüÁÉÍÓÚÜñÑ]{1,30}$/ para verificar que la aula solo
    // contiene caracteres alfanuméricos incluyendo letras (tanto minúsculas como mayúsculas) con acentos,
    // la letra "ñ", números, espacios en blanco y el caracter "º". Además, nos aseguramos de que
    // haya entre 1 y 30 caracteres.
    if(/^[a-zA-Z0-9áéíóúüÁÉÍÓÚÜñÑº\s]{1,30}$/.test(aula)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreAula).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreAula + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y recuperamos el mensaje de error
        document.getElementById(nombreAula).style.borderColor= "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreAula + "-incorrecto");

        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarPassword(password, nombrePassword, tipo) {
    // Usamos la expresión regular /^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ0-9-_!@#$%^&*]{4,}$/
    // para verificar que la contraseña esté compuesta por una combinación de letras (con y sin acentos),
    // números y algunos caracteres especiales. Además, verificamos que tenga 4 o más caracteres (maximo 100)
    // Si no se cumplen estas condiciones no se envía el formulario e informamos al usuario de lo que está pasando
    if(/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ0-9-_!@#$%^&*]{4,100}$/.test(password)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombrePassword).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombrePassword + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y recuperamos el mensaje de error
        document.getElementById(nombrePassword).style.borderColor = "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombrePassword + "-incorrecto");
        
        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarPasswordAlumno(password, nombrePassword, tipo) {
    // Usamos la expresión regular /^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ0-9-_!@#$%^&*]{4,}$/
    // para verificar que la contraseña esté compuesta por una combinación de letras (con y sin acentos),
    // números y algunos caracteres especiales. Además, verificamos que tenga 4 o más caracteres (maximo 100)
    // Si no se cumplen estas condiciones no se envía el formulario e informamos al usuario de lo que está pasando
    if(/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ0-9-_!@#$%^&*]{4,100}$/.test(password)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById('password-login').style.borderColor = "rgba(173, 255, 47, 0.7)";
        document.getElementById('-login-incorrecto').textContent = "";

        return true;
    }
    else{
        // Cambiamos el color del borde del campo rellenado y recuperamos el mensaje de error
        document.getElementById('password-login').style.borderColor = "rgba(255, 0, 0, 0.7)";
        document.getElementById('-login-incorrecto').textContent = "La contraseña no es la correcta. Por favor, inténtalo de nuevo.";
        
        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarConfirmacionPassword(confirmarPassword, nombreConfirmarPassword, password, tipo) {
    // Comprobamos si la contraseña es igual a la confirmación de la contraseña
    if(confirmarPassword == password){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreConfirmarPassword).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreConfirmarPassword + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y recuperamos el mensaje de error
        document.getElementById(nombreConfirmarPassword).style.borderColor = "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreConfirmarPassword + "-incorrecto");
        
        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarFieldset(nombreFieldset) {
    var fieldset = document.getElementById(nombreFieldset);
    var checkboxes = fieldset.querySelectorAll('input[type="checkbox"]');

    // Recorremos todos los checkboxes
    for (var i = 0; i < checkboxes.length; i++) {
        // Comprobamos que al menos un checkbox esté seleccionado
        if (checkboxes[i].checked) {
             // Cambiamos el color del borde del campo rellenado
            document.getElementById(nombreFieldset).style.borderColor= "rgba(173, 255, 47, 0.7)";
            eliminarElemento(nombreFieldset + "-incorrecto");
            return true;
        }
    }

    // Cambiamos el color del borde del campo rellenado
    document.getElementById(nombreFieldset).style.borderColor = "rgba(255, 0, 0, 0.7)";
    recuperarElemento(nombreFieldset + "-incorrecto");

    // Ningún checkbox está seleccionado
    return false;
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarRadio(nombreFieldset) {
    var fieldset = document.getElementById(nombreFieldset);
    var radios = fieldset.querySelectorAll('input[type="radio"]');

    // Recorremos todos los radios
    for (var i = 0; i < radios.length; i++) {
        // Comprobamos que al menos un checkbox esté seleccionado
        if (radios[i].checked) {
            // Cambiamos el color del borde del campo rellenado
            document.getElementById(nombreFieldset).style.borderColor= "rgba(173, 255, 47, 0.7)";
            eliminarElemento(nombreFieldset + "-incorrecto");
            return true;
        }
    }

    // Cambiamos el color del borde del campo rellenado
    document.getElementById(nombreFieldset).style.borderColor = "rgba(255, 0, 0, 0.7)";
    recuperarElemento(nombreFieldset + "-incorrecto");

    // Ningún radio está seleccionado
    return false;
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarTexto(texto, nombreTexto, tipo, max=200) {
    // Usamos la expresión regular /^[a-zA-ZáéíóúüÁÉÍÓÚÜ0-9_-]+$/ para verificar que el texto correspondiente
    // solo contenga letras (tildes y dieresis incluida), números, guiones y signos de puntuación.
    // Además, verificamos que tenga minimo 1 caracter y como máximo 200
    var regex = new RegExp("^[a-zA-ZåïáéíóúüÁÉÍÓÚÜñÑ&0-9 _'\".,;:…!()¿?¡<>\\[\\]{}\\-]{1," + max + "}$");

    if(regex.test(texto)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreTexto).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreTexto + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreTexto).style.borderColor= "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreTexto + "-incorrecto");

        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarRutaFoto(rutaFoto, nombreRutaFoto, tipo) {
    // Usamos la expresión regular /^[^\n\r\s]{1,100}(\.jpg|\.jpeg|\.png|\.gif|\.bmp)$/i para
    // verificar si la cadena de entrada termina con una de las extensiones de archivo de imagen comunes
    // (sin distinción entre mayúsculas y minúsculas). Además, verifica que tenga menos de 100 caracteres.
    if(/^[^\n\r\s]{1,100}(\.jpg|\.jpeg|\.png|\.gif|\.bmp)$|^$/i.test(rutaFoto)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreRutaFoto).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreRutaFoto + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y recuperamos el mensaje de error
        document.getElementById(nombreRutaFoto).style.borderColor= "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreRutaFoto + "-incorrecto");

        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarRutaVideo(rutaVideo, nombreRutaVideo, tipo) {
    // Usamos la expresión regular /^[^\n\r\s]{1,100}(\.mp4|\.avi|\.mov|\.mkv|\.flv)$/i para
    // verificar si la cadena de entrada termina con una de las extensiones de archivo de video comunes
    // (sin distinción entre mayúsculas y minúsculas). Además, verifica que tenga menos de 100 caracteres.
    if(/^[^\n\r\s]{1,100}(\.mp4|\.avi|\.mov|\.mkv|\.flv)$|^$/i.test(rutaVideo)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreRutaVideo).style.borderColor = "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreRutaVideo + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y recuperamos el mensaje de error
        document.getElementById(nombreRutaVideo).style.borderColor = "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreRutaVideo + "-incorrecto");

        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarRutaAudio(rutaAudio, nombreRutaAudio, tipo) {
    // Usamos la expresión regular /^[^\n\r\s]{1,100}(\.mp3|\.wav|\.ogg|\.flac|\.aac)$/i para
    // verificar si la cadena de entrada termina con una de las extensiones de archivo de audio comunes
    // (sin distinción entre mayúsculas y minúsculas). Además, verifica que tenga menos de 100 caracteres.
    if(/^[^\n\r\s]{1,100}(\.mp3|\.wav|\.ogg|\.flac|\.aac)$|^$/i.test(rutaAudio)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreRutaAudio).style.borderColor = "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreRutaAudio + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y recuperamos el mensaje de error
        document.getElementById(nombreRutaAudio).style.borderColor = "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreRutaAudio + "-incorrecto");

        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarRutaDoc(rutaDoc, nombreRutaDoc, tipo) {
    // Usamos la expresión regular /^(?:[^\n\r]+(\.(pdf|docx?|xlsx?|pptx?|rtf|txt|od[tps]|md|indd|ai|psd|dwg|tex|qxp)))?$/
    // para comprobar que esté vacío o contenga un nombre de archivo con una extensión específica propia
    // de un documento. Además, verifica que el nombre del archivo tenga menos de 100 caracteres.
    if(/^(?:[^\n\r]+(\.(pdf|docx?|xlsx?|pptx?|rtf|txt|od[tps]|md|indd|ai|psd|dwg|tex|qxp)))?$/.test(rutaDoc)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreRutaDoc).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreRutaDoc + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras hsaber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y recuperamos el mensaje de error
        document.getElementById(nombreRutaDoc).style.borderColor= "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreRutaDoc + "-incorrecto");

        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function habilitarEdicion() {
    var inputs = document.querySelectorAll('input[name="nombre"], input[name="apellidos"], input[name="aula"], input[name="ruta_foto"],' +
                                           'input[name="usuario"], input[name="password"], input[name="password-confirm"],' +
                                           'input[name="curso"], input[name="perfil_visualizacion"], input[type="submit"],' +
                                           'input[name="titulo"], input[name="ruta_documento"], input[name="ruta_icono"],'+ 
                                           'input[name="tipo_password"]');

    // Permitimos que se puedan editar
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].removeAttribute('disabled');
    }

    // Habilitamos las casillas de verificación dentro de los fieldsets
    habilitarFieldset('fieldset-perfil_visualizacion');
    habilitarRadio('fieldset-tipo_password');

    // Habilitamos los pasos
    habilitarPasos('numero_pasos', 'paso');
    habilitarPictogramas('campo-pictogramas');
    habilitarPulsadores('campo-pulsadores');

    // Eliminamos el botón para editar los datos
    eliminarElemento('boton-editar');

    // Recuperamos el botón para cerrar la edición, el de añadir pasos
    // y el necesario para enviar los datos
    recuperarElemento('boton-cerrarEdicion');
    recuperarElemento('añadir_paso');
    recuperarElementoPaso('eliminar_paso_', 'numero_pasos');
    recuperarElemento('boton-enviar', 'inline-block');

    // Iluminamos con un box shadow el formulario
    document.getElementById('formulario-modificar').style.boxShadow = '0px 0px 10px rgb(8 1 99 / 40%)';
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function deshabilitarEdicion() {
    var inputs = document.querySelectorAll('input[name="nombre"], input[name="apellidos"], input[name="aula"], input[name="ruta_foto"],' +
                                           'input[name="usuario"], input[name="password"], input[name="password-confirm"],' +
                                           'input[name="curso"], input[name="perfil_visualizacion"], input[type="submit"],' +
                                           'input[name="titulo"], input[name="ruta_documento"], input[name="ruta_icono"],' + 
                                           'input[name="tipo_password"]');
  
    // Evitamos que se puedan editar
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].setAttribute('disabled', 'disabled');
    }

    // Deshabilitamos las casillas de verificación dentro de los fieldsets
    deshabilitarFieldset('fieldset-perfil_visualizacion');
    deshabilitarRadio('fieldset-tipo_password');

    // Deshabilitamos los pasos y los pictogramas
    deshabilitarPasos('numero_pasos', 'paso');
    deshabilitarPictogramas('campo-pictogramas');
    deshabilitarPulsadores('campo-pulsadores');

    // Eliminamos el botón para cerrar la edicion, el de añadir pasos
    // y el necesario para enviar los datos
    eliminarElemento('boton-cerrarEdicion');
    eliminarElemento('añadir_paso');
    eliminarElementoPaso('eliminar_paso_', 'numero_pasos');
    eliminarElemento('boton-enviar');

    // Recuperamos el botón para editar los datos
    recuperarElemento('boton-editar');

    // Devolvemos al box shadow original al formulario
    document.getElementById('formulario-modificar').style.removeProperty("box-shadow");
}
//*****************************************************************************************************//
  
  