<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Perfil de tarea</title>
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
				<h1 id='tituloPrincipal'>Modificar Tarea</h1></div>
				<a id='enlace-header' href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
			</div>
		</header>

		<main>
			<?php 	
				require_once('../php/tareas.class.php');

				// Acceder a los datos de las tareas almacenadas en la variable de sesión
				// Usamos $_GET porque en este caso el indice de las tareas no compromete
				// al sistema ni a la seguridad y privacidad del mismo
				$tarea = unserialize($_SESSION['tarea'][$_GET['indice']]);

				$titulo = $tarea['titulo'];
				$ruta_documento = $tarea['ruta_documento'];
				$ruta_icono = $tarea['ruta_icono'];
				$numPasos = $tarea['numero_pasos'];
				$_SESSION['id_tarea'] = $tarea['id'];
				$i = 1;

				// Obtenemos todos los pasos de la tarea con ese titulo y el mismo numero de pasos
				$tmp = new Tareas();
				$pasosTarea = $tmp->obtenerPasosDeTarea($titulo, $numPasos);

				// Accedemos a los datos de cada paso y multimedia
				foreach ($pasosTarea as $paso) {
					$paso_descripcion[$i] = $paso["descripcion"];
					$paso_video[$i] = $paso["video"];
					$paso_foto[$i] = $paso["foto"];
					$paso_audio[$i] = $paso["audio"]; 

					$i++;
				}
			?>

			<a href="javascript:void(0);" onclick="volverPaginaAnterior()" class="boton-volver" aria-label="Volver a la asignación de tareas" role="button">&#129152;</a>

			<script>
				function volverPaginaAnterior() {
					window.history.length > 1 ? window.history.go(-1) : window.location.href = document.referrer;
				}
			</script>

			<article id="tituloSecundario">
				<img src='../multimedia/imagenes/icono_tarea.png' width='30' height='30' alt='Icono tarea'>
				<h2><?php echo $titulo; ?></h2>
			</article>
			<form onsubmit="return validarFormularioRegistroTarea(event, '')" action="../php/modificar_tarea.php" method="POST" class="formulario" id="formulario-modificar">
				<button type="button" onclick="habilitarEdicion()" id="boton-editar">Editar Tarea</button>
				<button type="button" onclick="deshabilitarEdicion()" id="boton-cerrarEdicion" style="display: none;">Cerrar &#10008;</button>
				
				<article class="campo">
					<label for="titulo" class="titulo-campo">T&iacute;tulo:</label>
					<input type="text" id="titulo" name="titulo" value="<?php echo $titulo?>" placeholder="Introduce el t&iacute;tulo de la tarea" required disabled>
					<p id="titulo-incorrecto" style="display:none;">El t&iacute;tulo no puede estar vac&iacute;o ni contener más de 200 caracteres. Tampoco puede contener caracteres especiales que no sean signos de puntuaci&oacute;n</p>
				</article>

				<article class="campo">
					<label for="ruta_icono" class="titulo-campo">Icono asociado:</label>
					<input type="text" id="ruta_icono" name="ruta_icono" value="<?php echo $ruta_icono?>" placeholder="Introduce el nombre de archivo completo de la imagen" required disabled>
					<p id="ruta_icono-incorrecto" style="display:none;">El icono debe corresponder a un archivo v&aacute;lido</p>
				</article>
				
				<article class="campo">
					<label for="ruta_documento" class="titulo-campo">Documento asociado:</label>
					<input type="text" id="ruta_documento" name="ruta_documento" value="<?php echo $ruta_documento?>" placeholder="Introduce el nombre de archivo completo del documento" disabled>
					<p id="ruta_documento-incorrecto" style="display:none;">El documento debe corresponder a un archivo v&aacute;lido</p>
				</article>

				<section id="paso">
				</section>

				<script>
					var contadorPasos = <?php echo json_encode($numPasos); ?>;
					var pasoDescripcion = <?php echo json_encode($paso_descripcion); ?>;
					var pasoVideo = <?php echo json_encode($paso_video); ?>;
					var pasoFoto = <?php echo json_encode($paso_foto); ?>;
					var pasoAudio = <?php echo json_encode($paso_audio); ?>;

					// Código JavaScript para mostrar los pasos agregados dinámicamente
					for(var i = 1; i <= contadorPasos; i++){
						var pasoDiv = document.createElement("div");
						pasoDiv.classList.add("elementos_paso");

						pasoDiv.innerHTML = `
							<h2 id='titulo_paso_${i}'>Paso ${i}:</h2>

							<article class="campo">
								<label for="paso_descripcion_${i}" class="titulo-campo">Descripción:</label>
								<textarea id="paso_descripcion_${i}" name="paso_descripcion_${i}" placeholder="Introduce la descripci&oacute;n completa del paso" required disabled>${pasoDescripcion[i]}</textarea>
								<p id="paso_descripcion_${i}-incorrecto" style="display:none;">La descripci&oacute;n no puede estar vac&iacute;a ni contener más de 200 caracteres. Tampoco puede contener caracteres especiales que no sean signos de puntuaci&oacute;n</p>
							</article>

							<article class="campo">
								<label for="paso_video_${i}" class="titulo-campo">V&iacute;deo:</label>
								<input type="text" id="paso_video_${i}" name="paso_video_${i}" value="${pasoVideo[i]}" placeholder="Introduce el nombre de archivo completo del v&iacute;deo" disabled>
								<p id="paso_video_${i}-incorrecto" style="display:none;">El v&iacute;deo del paso debe corresponder a un archivo de v&iacute;deo v&aacute;lido</p>
							</article>

							<article class="campo">
								<label for="paso_foto_${i}" class="titulo-campo">Foto:</label>
								<input type="text" id="paso_foto_${i}" name="paso_foto_${i}" value="${pasoFoto[i]}" placeholder="Introduce el nombre de archivo completo de la imagen" disabled>
								<p id="paso_foto_${i}-incorrecto" style="display:none;">La fotograf&iacute;a del paso debe corresponder a un archivo de imagen v&aacute;lido</p>
							</article>

							<article class="campo">
								<label for="paso_audio_${i}" class="titulo-campo">Audio:</label>
								<input type="text" id="paso_audio_${i}" name="paso_audio_${i}" value="${pasoAudio[i]}" placeholder="Introduce el nombre de archivo completo del audio" disabled>
								<p id="paso_audio_${i}-incorrecto" style="display:none;">El audio del paso debe corresponder a un archivo de sonido v&aacute;lido</p>
							</article>

							<article class="enviar" id="quitar-paso">
								<button type="button" id="eliminar_paso_${i}" class="eliminar_paso_${i}" onclick="eliminarPaso(this)" style="display:none;" disabled>Eliminar Paso</button>
							</article>
						`;

						document.getElementById("paso").appendChild(pasoDiv);
					}
				</script>

				<input type="number" id="numero_pasos" name="numero_pasos" value=<?php echo $numPasos?> style="display:none;">

				<article class="enviar">
					<button type="button" name="añadir_paso" id="añadir_paso" style="display:none;">Añadir Paso</button>
				</article>

				<script>
					var contadorPasos = <?php echo json_encode($numPasos); ?>;
					var contadorPasosTitulo = contadorPasos;	

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

							<article class="enviar">
								<button type="button" id="eliminar_paso_${contadorPasos}" class="eliminar_paso_${contadorPasos}" onclick="eliminarPaso(this)">Eliminar Paso</button>
							</article>
						`;

						document.getElementById("paso").appendChild(pasoDiv);

						// Actualiza el valor del campo numero_pasos
						document.getElementById("numero_pasos").value = contadorPasos;

						// Comprobamos si hay al menos otro paso
						if(contadorPasosTitulo > 1){
							recuperarElementoPaso('eliminar_paso_', 'numero_pasos');	
						}
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
					<input type="submit" id="boton-enviar" value="Guardar cambios" style="display:none;" disabled>
				</article>
			</form>
		</main>

		<footer>
		</footer>
	</body>
</html>