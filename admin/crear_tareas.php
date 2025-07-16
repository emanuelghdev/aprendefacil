<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Crear Tareas</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
		<script src="../javascript/header_responsive.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/formularios.css">
	</head>
	<body>
		<header>
			<div id="div-header">
				<div id="barra-lateral" class="barra-lateral">
					<a href="#" class="boton-cerrar" onclick="ocultar()"><button><h3>&#10008;</h3></button></a>
					<div id="contenido">
						<div id='perfil-login-reducido'></div>
						<a id='enlace-header-reducido' href='profesores/acceso_profesores.php'><button><h3>Acceso de Profesores</h3></button></a>
					</div>
				</div>
					
				<div id="boton-barra-lateral">
					<a id="abrir" class="abrir-cerrar" href="javascript:void(0)" onclick="mostrar()"><button><h3>&#9776;</h3></button></a>
					<a id="cerrar" class="abrir-cerrar" href="javascript:void(0)" onclick="ocultar()" style='display: none;'></button><h3>&#9776;</h3></button></a>
				</div>
				<?php
					// Iniciar la sesión
					session_start();

					// Si hay una sesión activa de administrador, mostrar el nombre de usuario y la posibilidad de cerrar sesión
					if (isset($_SESSION['admin'])) {

						// Acceder al nombre de usuario almacenado en la variable de sesión
						$username = $_SESSION['usuario'];
						$ruta_foto = $_SESSION['ruta_foto'];

						// Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
						echo "<div id='perfil-login'>
							<a href='../profesores/modificacion_profesores.php'>
								<div><img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'></div>
								<div><h2>$username</h2></div>
							</a>
						</div>";
					}
					else{		// Si no hay ninguna sesión de administrador activa
						header("Location: ../index.php");
					}
				?>
				<div id="div-titulo"><img src='../multimedia/imagenes/icono_admin.png' width='60' height='60' alt='Icono administrador'>
				<h1 id='tituloPrincipal'>Registrar Tarea</h1></div>
				<a id='enlace-header' href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
			</div>
		</header>

		<main>
			<a href="../admin/admin_tareas.php" class="boton-volver" aria-label="Volver a la gestión de tareas" role="button">&#129152;</a>

			<form onsubmit="return validarFormularioRegistroTarea(event, '')" action="../php/registrar_tarea.php" method="POST" class="formulario">
				<article id="tituloSecundario">
					<img src='../multimedia/imagenes/icono_tarea.png' width='30' height='30' alt='Icono tarea'>
					<h2>Nueva Tarea</h2>
				</article>

				<article class="campo">
					<label for="titulo" class="titulo-campo">T&iacute;tulo:</label>
					<input type="text" id="titulo" name="titulo" placeholder="Introduce el t&iacute;tulo de la tarea" required>
					<p id="titulo-incorrecto" style="display:none;">El t&iacute;tulo no puede estar vac&iacute;o ni contener más de 200 caracteres. Tampoco puede contener caracteres especiales que no sean signos de puntuaci&oacute;n</p>
				</article>

				<article class="campo">
					<label for="ruta_icono" class="titulo-campo">Icono asociado:</label>
					<input type="file" id="ruta_icono" name="ruta_icono" accept="image/*" required>
				</article>
				
				<article class="campo">
					<label for="ruta_documento" class="titulo-campo">Documento asociado:</label>
					<input type="file" id="ruta_documento" name="ruta_documento">
					<p id="ruta_documento-incorrecto" style="display:none;">El documento debe corresponder a un archivo v&aacute;lido</p>
				</article>

				<section id="paso">
					<div class="elementos_paso">
						<h2 id='titulo_paso_1'>Paso 1:</h2>
						<article class="campo">
							<label for="paso_descripcion_1" class="titulo-campo">Descripci&oacute;n:</label>
							<textarea id="paso_descripcion_1" name="paso_descripcion_1" placeholder="Introduce la descripci&oacute;n completa del paso" required></textarea>
							<p id="paso_descripcion_1-incorrecto" style="display:none;">La descripci&oacute;n no puede estar vac&iacute;a ni contener más de 200 caracteres. Tampoco puede contener caracteres especiales que no sean signos de puntuaci&oacute;n</p>
						</article>

						<article class="campo">
							<label for="paso_video_1" class="titulo-campo">V&iacute;deo:</label>
							<input type="file" id="paso_video_1" name="paso_video_1" accept="video/*">
						</article>

						<article class="campo">
							<label for="paso_foto_1" class="titulo-campo">Foto:</label>
							<input type="file" id="paso_foto_1" name="paso_foto_1" accept="image/*">
						</article>

						<article class="campo">
							<label for="paso_audio_1" class="titulo-campo">Audio:</label>
							<input type="file" id="paso_audio_1" name="paso_audio_1" accept="audio/*">
						</article>

						<article class="enviar" id="quitar-paso">
							<button type="button" id="eliminar_paso_1" class="eliminar_paso_1" onclick="eliminarPaso(this)" style="display:none;">Eliminar Paso</button>
						</article>
					</div>
				</section>

				<input type="number" id="numero_pasos" name="numero_pasos" value="1" style="display:none;">

				<article class="enviar" id="enviar-paso">
					<button type="button" id="añadir_paso">Añadir Paso</button>
				</article>

				<script>
					var contadorPasos = 1;				// Cuenta los pasos totales añadidos, aunque hayan sido borrados después
					var contadorPasosTitulo = 1;		// Cuenta únicamente los pasos que no se han borrado

					// Código JavaScript para agregar pasos dinámicamente
					document.getElementById("añadir_paso").addEventListener("click", function() {
						contadorPasos++;
						contadorPasosTitulo++;
						var pasoDiv = document.createElement("div");
						pasoDiv.classList.add("elementos_paso");

						pasoDiv.innerHTML = `
							<h2 id='titulo_paso_${contadorPasos}'>Paso ${contadorPasosTitulo}:</h2>

							<article class="campo">
								<label for="paso_descripcion_${contadorPasos}" class="titulo-campo">Descripción:</label>
								<textarea id="paso_descripcion_${contadorPasos}" name="paso_descripcion_${contadorPasos}" placeholder="Introduce la descripci&oacute;n completa del paso" required></textarea>
								<p id="paso_descripcion_${contadorPasos}-incorrecto" style="display:none;">La descripci&oacute;n no puede estar vac&iacute;a ni contener más de 200 caracteres. Tampoco puede contener caracteres especiales que no sean signos de puntuaci&oacute;n</p>
							</article>

							<article class="campo">
								<label for="paso_video_${contadorPasos}" class="titulo-campo">Vídeo:</label>
								<input type="file" id="paso_video_${contadorPasos}" name="paso_video_${contadorPasos}" accept="video/*">
							</article>

							<article class="campo">
								<label for="paso_foto_${contadorPasos}" class="titulo-campo">Foto:</label>
								<input type="file" id="paso_foto_${contadorPasos}" name="paso_foto_${contadorPasos}" accept="image/*">
							</article>

							<article class="campo">
								<label for="paso_audio_${contadorPasos}" class="titulo-campo">Audio:</label>
								<input type="file" id="paso_audio_${contadorPasos}" name="paso_audio_${contadorPasos}" accept="audio/*">
							</article>

							<article class="enviar" id="quitar-paso">
								<button type="button" id="eliminar_paso_${contadorPasos}" class="eliminar_paso_${contadorPasos}" onclick="eliminarPaso(this)">Eliminar Paso</button>
							</article>
						`;

						document.getElementById("paso").appendChild(pasoDiv);

						// Actualizamos el valor del campo numero_pasos
						document.getElementById("numero_pasos").value = contadorPasos;

						// Comprobamos si hay al menos otro paso
						recuperarElementoPaso('eliminar_paso_', 'numero_pasos');	
						
					});

					// Código JavaScript para eliminar pasos dinámicamente
					function eliminarPaso(button) {
						// Encontramos el elemento padre del botón (un div que contiene todos los campos de un paso)
						var pasoDiv = button.parentElement.parentElement;
						
						// Eliminamos el paso del DOM
						pasoDiv.remove();

						// Actualizamos visualmente los numeros de los pasos
						contadorPasosTitulo--;
						var orden = 1;

						// Corregimos los números de los pasos activos recorriendolos todos
						for(var i=1; i<=contadorPasos; i++){
							if(document.getElementById("titulo_paso_" + i) != null){
								document.getElementById("titulo_paso_" + i).textContent  = "Paso " + orden + ":"; 
								orden++;
							}
						}

						// Comprobamos que haya al menos otro paso
						if(contadorPasosTitulo < 2){
							eliminarElementoPaso('eliminar_paso_', 'numero_pasos');	
						}
					}
				</script>
				
				<article class="enviar">
					<input type="submit" value="Registrar Tarea">
				</article>
			</form>
		</main>

		<footer>
		</footer>
	</body>
</html>