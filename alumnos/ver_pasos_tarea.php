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
		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/base.css">
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/tarea.css">
		<style>
			body {
				zoom: 0.95;
			}
		</style>
	</head>

	<body class="pagina-tareas">
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
					require_once('../php/tareas.class.php');
					
					// Iniciar la sesión
					session_start();

					// Si hay una sesión activa de usuario, mostrar el nombre de usuario y la posibilidad de cerrar sesión
					if (isset($_SESSION['sesion_alumno']) && $_SESSION['sesion_alumno'] == true) { 
						// Acceder al nombre de usuario almacenado en la variable de sesión
						$username = $_SESSION['nombre'];
						$ruta_foto = $_SESSION['ruta_foto'];
						$alumno_id = $_SESSION['id_alumno'];
						$perfil_visualizacion = explode(', ', $_SESSION['perfil_visualizacion']);

						// Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
						echo "<div id='perfil-login'>
							<a href='../alumnos/alumno.php'>
								<div><img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'></div>
								<div><h2>$username</h2></div>
							</a>
						</div>";
					} else { 		// Si no hay ninguna sesión de usuario activa
						header("Location: ../index.php");
					}

					$seccion_actual = isset($_GET['section']) ? $_GET['section'] : 'imagenes';

					// Obtener el tarea_id de la URL
					$tarea_id = isset($_GET['tarea_id']) ? $_GET['tarea_id'] : null;

					// Validar si el tarea_id está presente
					if (!$tarea_id) {
						echo "Error: Tarea no especificada.";
						exit;
					}

					// Obtener información detallada de la tarea
					$tarea_info = Tareas::obtenerTarea($tarea_id);

					// Verificar si se encontró información de la tarea
					if ($tarea_info) {
						// Acceder a la información de la tarea
						$titulo_tarea = $tarea_info['titulo'];
						$total_pasos = $tarea_info['numero_pasos'];
						$ruta_foto_tarea = $tarea_info['ruta_icono'];
						$id_chat_texto = $tarea_info['chat_text_id'];
						$id_chat_imagen = $tarea_info['chat_pict_id'];
					}

					// Obtener el número de pasos completados para el alumno y la tarea actuales
					$numero_pasos_completados = Tareas::obtenerPasosCompletados($tarea_id, $alumno_id);

					// Obtener el paso actual
					$paso_actual = isset($_GET['paso']) ? $_GET['paso'] : 1;

					// Obtener información detallada del paso actual
					$pasosTarea = Tareas::obtenerPasosDeTarea($titulo_tarea, $total_pasos);

					// Inicializar variables para el paso actual
					$paso_descripcion = "";
					$paso_video = "";
					$paso_foto = "";
					$paso_audio = "";

					// Acceder a los datos del paso actual
					foreach ($pasosTarea as $paso) {
						if ($paso['orden'] == $paso_actual) {
							$paso_descripcion = $paso["descripcion"];
							$paso_video = $paso["video"];
							$paso_foto = $paso["foto"];
							$paso_audio = $paso["audio"];
							break; // Salir del bucle una vez que se encuentra el paso actual
						}
					}


					if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["marcar_paso"])) {

						// Determina si estamos marcando o desmarcando el paso
						$marcar_paso = $_POST["marcar_paso"] === 'marcar';

						// Actualiza el número de pasos completados según la acción
						if (!$marcar_paso) {
							$numero_pasos_completados++;
						} else {
							$numero_pasos_completados--;
							// Asegúrate de que el número de pasos completados no sea negativo
							$numero_pasos_completados = max(0, $numero_pasos_completados);
						}

						// Actualiza el número de pasos completados en la base de datos
						Tareas::actualizarPasosCompletados($tarea_id, $alumno_id, $numero_pasos_completados);

						// Devuelve el nuevo número de pasos completados como respuesta a la solicitud AJAX
						echo $numero_pasos_completados;

						// Verificar si todos los pasos están completados
						if ($numero_pasos_completados == $total_pasos) {
							// Desasignar al alumno de la tarea
							$resultado_desasignacion = Tareas::DesasignarAlumnosTarea($alumno_id, $tarea_id);

							// Verificar el resultado de la desasignación
							if ($resultado_desasignacion) {
								// Redirigir a la página de alumnos.php
								header("Location: ../alumnos/alumnos.php");
								exit;
							} else {
								// Manejar el caso en que la desasignación falla
								echo "Error al desasignar la tarea del alumno.";
								exit;
							}
						}

						// Termina el script para evitar enviar la página HTML completa
						exit();
					}
				?>

				<div id='div-titulo'>
					<img src='../multimedia/imagenes/<?php echo $ruta_foto_tarea; ?>' width='60' height='60' alt='Icono página inicial'>
					<h1 id='tituloPrincipal'>Paso <?= $paso_actual; ?></h1>
				</div>
				<a id="enlace-header"  class="enlace-chats" href=<?php
					include('../php/chats.class.php');
					$tmp = new Chats();
					$_SESSION['chat'][0] = serialize($tmp->obtenerChatconId($id_chat_texto));
					$_SESSION['chat'][1] = serialize($tmp->obtenerChatconId($id_chat_imagen));
					if ($_SESSION['tipo_password'] == "texto") {
						echo'../chat/chat_texto.php?chat=0';
					} else {
						echo'../chat/chat_imagen.php?chat=1';
					}
				?>
				><button><img src="../multimedia/imagenes/chat.png" width="60"></button></a>
			</div>
		</header>

		<main>
			<div class="botones">

					<a href='../alumnos/alumno.php' class='boton-pantalla' id='casa' >
						<button>
							<img src='../multimedia/imagenes/icono_casa.png' width="50px" height="50px" alt='Casa'>
						</button>
					</a>

				<?php if (in_array('texto', $perfil_visualizacion)) : ?>
					<a href='#' class='boton-pantalla' onclick="showMedia('texto')">
						<button>
							<img src='../multimedia/imagenes/icono_imagen.png' width="50px" height="50px" alt='Imagen'>
						</button>
					</a>
				<?php endif; ?>
				
				<?php if (in_array('video', $perfil_visualizacion)) : ?>
					<a href='#' class='boton-pantalla' onclick="showMedia('video')">
						<button>
							<img src='../multimedia/imagenes/icono_video.png' width="50px" height="50px" alt='Video'>
						</button>
					</a>
				<?php endif; ?>

				<?php if (in_array('audio', $perfil_visualizacion)) : ?>
					<a href='#' class='boton-pantalla' onclick="showMedia('audio')">
						<button>
							<img src='../multimedia/imagenes/icono_audio.png' width="50px" height="50px" alt='Audio'>
						</button>
					</a>
				<?php endif; ?>

            </div>

			<div class="imagen-tarea">
				<?php if ($paso_actual > 1) : ?>
					<button class="boton-paso" id='prevTareas' aria-label="Ir a paso anterior" onclick="goToPreviousStep()">&#129152;</button>
				<?php endif; ?>

				<?php
					// Mostrar la foto del paso actual
					echo "<img class='media-element texto' src='../multimedia/imagenes/$paso_foto'  alt='Foto del paso actual'>";

					echo "<video class='media-element video' autoplay controls >
							<source src='../multimedia/videos/$paso_video' type='video/mp4'>
							Tu navegador no soporta el elemento de video.
						</video>";


					echo "<audio class='media-element audio' autoplay controls>
							<source src='../multimedia/audios/$paso_audio' type='audio/mp3'>
							Tu navegador no soporta el elemento de audio.
						</audio>";
				?>

				<?php if ($paso_actual < $total_pasos) : ?>
					<button class="boton-paso" id='posTareas' aria-label="Ir a paso siguiente" onclick="goToNextStep()">&#129154;</button>
				<?php endif; ?>
			</div>



		</main>

        <footer>
			<!-- Mostrar el texto referente a ese paso -->
			<?php echo "<p>$paso_descripcion</p>";	
			?>
			
			
			<div id="completado-button" class="custom-button" onclick="toggleCircle()">
				<button>
					<img src="../multimedia/imagenes/icono_tick.png" alt="Tick">
					<div id="circle"></div>
				</button>
			</div>

			<audio id="bienHechoAudio" src="../multimedia/sonidos/bien_hecho.mp3"></audio>




        </footer>

		
	</body>


	<script>
		// Obtener el botón de paso completado
		var botonCompletado = document.getElementById('completado-button');

		// Manejar el clic del botón completado
		botonCompletado.addEventListener('click', function() {
            // Determinar la acción según el estado actual del botón
            var accion = botonCompletado.classList.contains('active') ? 'desmarcar' : 'marcar';
			
            // Enviar la acción al servidor a través de una solicitud AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'ver_pasos_tarea.php?tarea_id=<?php echo $tarea_id; ?>&paso=<?php echo $paso_actual; ?>', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
					// La solicitud fue exitosa, procesa la respuesta
					var nuevoNumeroPasosCompletados = parseInt(xhr.responseText, 10);
					console.log('Nueva respuesta del servidor:', xhr.responseText);

					// Aquí puedes realizar cualquier acción necesaria con el nuevo número de pasos completados
					console.log('Nuevo número de pasos completados:', nuevoNumeroPasosCompletados);
					
					// Verificar si todos los pasos están completados después de la ejecución actual
					if (nuevoNumeroPasosCompletados == $totalPasos) {
						// Redirigir a la página de alumnos.php (lado del cliente)
						window.location.href = '../alumnos/alumnos.php';
						return; // Terminar la función para evitar ejecutar el código restante
					}

				} else {
					// Hubo un error en la solicitud, muestra el mensaje de error
					console.error('Error en la solicitud. Código de estado:', xhr.status);
            	}
            };
            xhr.send('marcar_paso=' + accion);
        });


		// Desactivar el botón si el paso actual no se ha completado
		if (<?php echo $paso_actual; ?> > <?php echo $numero_pasos_completados; ?> + 1) {
			botonCompletado.style.display = 'none';
		}

		// Verificar si el paso actual es menor o igual al número de pasos completados
		if (<?php echo $paso_actual; ?> <= <?php echo $numero_pasos_completados; ?>) {
			// Agregar la clase 'active' para mostrar el botón como marcado
			botonCompletado.classList.add('active');
		}

		document.addEventListener('DOMContentLoaded', function () {
    var initialMedia = getUrlParameter('media');
    var profilePriority = <?php echo json_encode($perfil_visualizacion); ?>;

    // Ordenar por prioridad
    profilePriority.sort(function (a, b) {
        return ['video', 'audio', 'texto'].indexOf(a) - ['video', 'audio', 'texto'].indexOf(b);
    });

    var preferredMedia = initialMedia || profilePriority.find(function (type) {
        return ['video', 'audio', 'texto'].includes(type);
    });

    showMedia(preferredMedia);

    // Reproducir automáticamente el video si el tipo de medio inicial es video
    if (preferredMedia === 'video') {
        var videoElement = document.querySelector('.media-element.video');

        // Verificar si el video se ha cargado correctamente antes de intentar reproducirlo automáticamente
        if (videoElement) {
            console.log('Video element found:', videoElement);
            videoElement.addEventListener('loadedmetadata', function () {
                console.log('Video metadata loaded. Starting playback.');
                videoElement.play();
            });

            videoElement.addEventListener('error', function (event) {
                console.error('Error loading video:', event.message);
            });
        } else {
            console.error('Video element not found.');
        }
    }

    // Obtener el número de pasos completados desde PHP
    var numeroPasosCompletados = <?php echo $numero_pasos_completados; ?>;

    // Obtener el número total de pasos desde PHP
    var totalPasos = <?php echo $total_pasos; ?>;

// Verificar si hay pasos completados y redirigir al último paso
if (numeroPasosCompletados > 0 && numeroPasosCompletados < totalPasos) {
    var ultimoPaso = numeroPasosCompletados + 1; // Siguiente paso después del último completado

    // Verificar si ya estamos en la página del último paso antes de redirigir
    var paginaActual = <?php echo $paso_actual; ?>;
    
    // Verificar si la redirección es debida a las flechas izquierda o derecha
    var esRedireccionFlechas = (document.referrer.includes('ver_pasos_tarea.php?tarea_id=') && paginaActual !== ultimoPaso);

    if (paginaActual !== ultimoPaso && !esRedireccionFlechas) {
        // Agregar un mensaje a la consola para indicar la redirección
        console.log('Redirigiendo a la página del último paso:', ultimoPaso);

        // Redirigir a la página del último paso
        window.location.href = 'ver_pasos_tarea.php?tarea_id=<?php echo $tarea_id; ?>&paso=' + ultimoPaso;
    }
}




});


	function showMedia(type) {
		// Ocultar todos los elementos multimedia
		var mediaElements = document.querySelectorAll('.media-element');
		mediaElements.forEach(function (element) {
			element.style.display = 'none';

			// Pausar y reiniciar la reproducción si es un elemento de audio o video
			if (element.tagName === 'AUDIO' || element.tagName === 'VIDEO') {
				element.pause();
				element.currentTime = 0; // Reiniciar la reproducción desde el principio
			}
		});

		// Mostrar el elemento correspondiente al tipo seleccionado
		var selectedMedia = document.querySelector('.' + type);
		if (selectedMedia) {
			selectedMedia.style.display = 'block';

			// Iniciar la reproducción automáticamente desde el principio si es un elemento de audio o video
			if (type === 'audio' || type === 'video') {
				selectedMedia.play();
			}
		}
	}





		// Función para obtener el valor de un parámetro de la URL
		function getUrlParameter(name) {
			name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
			var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
			var results = regex.exec(location.search);
			return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
		}







		function goToNextStep() {
			// Obtener el tipo de multimedia actual
			var currentMediaType = getCurrentMediaType();

			// Detener y reiniciar la reproducción si es un elemento de audio o video
			var currentMediaElement = document.querySelector('.' + currentMediaType);
			if (currentMediaElement && (currentMediaType === 'audio' || currentMediaType === 'video')) {
				currentMediaElement.pause();
				currentMediaElement.currentTime = 0; // Reiniciar la reproducción desde el principio
			}

			// Redirigir a la siguiente página con el tipo de multimedia actual
			window.location.href = 'ver_pasos_tarea.php?tarea_id=<?php echo $tarea_id; ?>&paso=<?php echo $paso_actual + 1; ?>&media=' + currentMediaType;
		}

		function goToPreviousStep() {
			// Obtener el tipo de multimedia actual
			var currentMediaType = getCurrentMediaType();

			// Detener y reiniciar la reproducción si es un elemento de audio o video
			var currentMediaElement = document.querySelector('.' + currentMediaType);
			if (currentMediaElement && (currentMediaType === 'audio' || currentMediaType === 'video')) {
				currentMediaElement.pause();
				currentMediaElement.currentTime = 0; // Reiniciar la reproducción desde el principio
			}

			// Redirigir al paso anterior con el tipo de multimedia actual
			window.location.href = 'ver_pasos_tarea.php?tarea_id=<?php echo $tarea_id; ?>&paso=<?php echo $paso_actual - 1; ?>&media=' + currentMediaType;
		}




		// Función para obtener el tipo de multimedia actual
		function getCurrentMediaType() {
			var mediaElements = document.querySelectorAll('.media-element');
			for (var i = 0; i < mediaElements.length; i++) {
				if (mediaElements[i].style.display === 'block') {
					return mediaElements[i].classList[1]; // Devolver la clase que representa el tipo de multimedia
				}
			}
			return ''; // Devolver cadena vacía si no se encuentra ningún tipo de multimedia
		}

		function toggleCircle() {
			var button = document.getElementById('completado-button');
			var audio = document.getElementById('bienHechoAudio');

			button.classList.toggle('active');

			if (button.classList.contains('active')) {
				// Solo reproduce el sonido si el botón está marcado
				audio.play();
			} else {
				// Pausa el sonido si el botón se desmarca
				audio.pause();
				audio.currentTime = 0;
			}
		}




	</script>
</html>

