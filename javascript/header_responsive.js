
//*****************************************************************************************************//
//************************ Funciones para hacer el header responsive **********************************//
function mostrar() {
    document.getElementById("barra-lateral").style.width = "100%";
}

function ocultar() {
    document.getElementById("barra-lateral").style.width = "0";
}

document.addEventListener("DOMContentLoaded", function () {
    // Inicializamos el estado de la pantalla
    actualizarBarraLateral();

    function actualizarBarraLateral(){
        // Copiamos la información de los elementos del header a los elementos dentro de la barra lateral 
        document.getElementById("perfil-login-reducido").innerHTML = document.getElementById("perfil-login").innerHTML;
        document.getElementById("enlace-header-reducido").innerHTML = document.getElementById("enlace-header").innerHTML;
        document.getElementById("enlace-header-reducido").href = document.getElementById("enlace-header").href;
    }

    // Actualizamos la barra lateral al cambiar el tamaño de la ventana
    window.addEventListener("resize", function () {
        actualizarBarraLateral();
    });
});
//*****************************************************************************************************//
//*****************************************************************************************************//