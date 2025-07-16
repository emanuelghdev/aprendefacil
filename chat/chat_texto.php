<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Inicio</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
		<script src="../javascript/header_responsive.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/index.css">
        <link rel="stylesheet" type="text/css" href="../css/chat.css">
	</head>

	<body>
		<header>
			<div id="div-header">
				<div id="barra-lateral" class="barra-lateral">
					<a href="#" class="boton-cerrar" onclick="ocultar()"><button><h3>&#10008;</h3></button></a>
					<div id="contenido">
						<div id='perfil-login-reducido'></div>
						<a id='enlace-header-reducido' href='../profesores/acceso_profesores.php'><button><h3>Acceso de Profesores</h3></button></a>
					</div>
				</div>
					
				<div id="boton-barra-lateral">
					<a id="abrir" class="abrir-cerrar" href="javascript:void(0)" onclick="mostrar()"><button><h3>&#9776;</h3></button></a>
					<a id="cerrar" class="abrir-cerrar" href="javascript:void(0)" onclick="ocultar()" style='display: none;'></button><h3>&#9776;</h3></button></a>
				</div>

				<?php
					// Iniciar la sesión
					session_start();

					// Si hay una sesión activa, mostrar el nombre de usuario y la posibilidad de cerrar sesión
					if (isset($_SESSION['usuario'])) {
						// Acceder al nombre de usuario almacenado en la variable de sesión
						$username = $_SESSION['usuario'];
						$ruta_foto = $_SESSION['ruta_foto'];

						// Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
						// Si la sesión activa es la de el administrador añadimos una linea para ir al panel de administrador
						if(isset($_SESSION['admin'])){
							echo "<div id='perfil-login'>
							<a href='../profesores/modificacion_profesores.php'>
							<img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
							<h2>$username</h2></a></div>
							<div id='div-titulo'><img src='../multimedia/imagenes/chat.png' width='60' height='60' alt='Icono página inicial'><h1 id='tituloPrincipal'>Chat</h1></div>
							<a id='enlace-header' href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>";
						}
						else{
							echo "<div id='perfil-login'>
							<a href='../profesores/modificacion_profesores.php'>
							<img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
							<h2>$username</h2></a></div>
							<div id='div-titulo'><img src='../multimedia/imagenes/chat.png' width='60' height='60' alt='Icono página inicial'><h1 id='tituloPrincipal'>Chat</h1></div>
							<a id='enlace-header' href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>";
						}
					}
					else if(isset($_SESSION['sesion_alumno']) && $_SESSION['sesion_alumno'] == true){
						// Acceder al nombre de alumno almacenado en la variable de sesión
						$username = $_SESSION['nombre'] . " " . $_SESSION['apellidos'];
						$ruta_foto = $_SESSION['ruta_foto'];

						echo "<div id='perfil-login'>
						<a href='../alumnos/alumno.php'>
						<img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
						<h2>$username</h2></a></div>
						<div id='div-titulo'><img src='../multimedia/imagenes/chat.png' width='60' height='60' alt='Icono página inicial'><h1 id='tituloPrincipal'>Chat</h1></div>
						<a id='enlace-header' href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>";
					}
					else{
						echo "<div id='perfil-login'></div>
						<div id='div-titulo'><img src='../multimedia/imagenes/chat.png' width='60' height='60' alt='Icono página inicial'><h1 id='tituloPrincipal'>Chat</h1></div>
						<a id='enlace-header' href='../profesores/acceso_profesores.php'><button><h3>Acceso de Profesores</h3></button></a>";
					}
                    $chat = unserialize($_SESSION['chat'][$_GET['chat']])
				?>
			</div>	
		</header>

		<main>
			<a href="javascript:void(0);" onclick="volverPaginaAnterior()" class="boton-volver" aria-label="Volver a la página anterior" role="button">&#129152;</a>

			<script>
				function volverPaginaAnterior() {
					window.history.length > 1 ? window.history.go(-1) : window.location.href = document.referrer;
				}
			</script>
			<div id='chat-enclosure'>
                
                <div id='chat'>
                </div>

                <div id='scroll-buttons'>
                    <button id='scrollup'><b>⬆</b></button>
                    <button id='scrolldown'><b>⬇</b></button>
                </div>
            </div>
            <script>
                var chat = document.querySelector("#chat");
                var scrollup = document.querySelector("#scrollup");
                var scrolldown = document.querySelector("#scrolldown");

                scrollup.addEventListener("click", function() {
                    chat.scrollTop -= 30;
                });

                scrolldown.addEventListener("click", function() {
                    chat.scrollTop += 30;
                });
            </script>
        </main>
        <form id='message-div' action='../php/mandar_mensaje.php' method='POST'>
                <input class='hidden' id="input_chat_id" name="input_chat_id" type="text" value='<?php echo $chat['id'];?>'>
                <input class='hidden' id="input_sender" name="input_sender" type="text" value='<?php echo $username;?>'>
                <input class='hidden' id="input_senderimg" name="input_senderimg" type="text" value='<?php echo $ruta_foto;?>'>
                <input id="input_mensaje" name="input_mensaje" type="text" name="Campo de mensaje">
				<button id="Enviar" type="submit"><img src='../multimedia/imagenes/mandar.png' width='80' height='80' alt='Enviar'></button>
        </form>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script>
            var id = document.querySelector("#input_chat_id").value;
            setInterval(refreshMessages, 100);
            function refreshMessages() {
                $.ajax({
                type: "POST",
                url: 'log_texto.php',
                data: {"chat_id": id},
                success: function(data){
                    chat.innerHTML = data;
                }
                });
            }
        </script>
	</body>
</html>