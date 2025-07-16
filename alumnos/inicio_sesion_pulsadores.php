<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión</title>
        <script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/header.css">
        <link rel="stylesheet" type="text/css" href="../css/acceso.css">
    </head>
    <body>
        <header>
            <div>
				<?php
					// Iniciar la sesión
					session_start();

					// Si hay una sesión activa de administrador redirigimos a la página del administrador
					if (isset($_SESSION['admin'])) {
						header("Location: ../admin/admin_alumnos.php");
					}
					else if (isset($_SESSION['usuario'])) {		// Si hay una sesión activa de usuario redirigimos a la página de profesor
                        header("Location: ../profesor/profesor_alumnos.php");
					}
                    else if(isset($_SESSION['sesion_alumno']) && $_SESSION['sesion_alumno'] == true){		// Si hay una sesión ya activa de alumnos redirigimos al alumno a la página correspondiente
                        header('Location: ../alumnos/alumno.php');
                    }
                    else if(isset($_SESSION['id_alumno'])){     // Si hay una sesión de inicio de sesión iniciada de alumno mostramos su nombre y foto
                        // Acceder al nombre de alumno almacenado en la variable de sesión
						$nombre = $_SESSION['nombre_alumno'] . " " . $_SESSION['apellidos_alumno'];
						$ruta_foto = $_SESSION['ruta_foto_alumno'];

                        echo "<div id='perfil-login'>
                        <div><img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'></div>
                        <div><h2>$nombre</h2></div></div>
                        <div id='div-titulo'><h1 id='titulo'>Iniciar Sesi&oacute;n</h1>
                        <img src='../multimedia/imagenes/icono_login.png' width='60' height='60' alt='Icono inicio de sesion'></div>
                        <div></div><div></div><div></div>";
                    }
					else{		// Si no hay ninguna sesión de usuario activa
						header("Location: ../index.php");
					}
				?>
			</div>
        </header>

        <main>
            <a href="../index.php" class="boton-volver" aria-label="Volver al inicio" role="button">&#129152;</a>

            <script>
                // Creamos un formulario dinámico
                var form = document.createElement('form');
                form.method = 'post';
                form.id = 'formulario';
                form.action = '../php/login_alumnos_pictos.php';

                function enviarFormulario(pictograma) {
                    // Modificamos el color de fondo del pictograma
                    pictograma.style.backgroundColor = '#080163';

                    // Creamos un campo de entrada oculto y agrega el dato
                    var input = document.createElement('input');
                    input.type = 'text';
                    input.className = 'hidden';
                    input.id = 'picto1d';
                    input.name = 'picto1d';
                    input.value = pictograma.value;
                    form.appendChild(input);

                    // Creamos otros dos campos ocultos vacios
                    var input = document.createElement('input');
                    input.type = 'text';
                    input.className = 'hidden';
                    input.id = 'picto2d';
                    input.name = 'picto2d';
                    input.value = "";
                    form.appendChild(input);

                    var input = document.createElement('input');
                    input.type = 'text';
                    input.className = 'hidden';
                    input.id = 'picto3d';
                    input.name = 'picto3d';
                    input.value = "";
                    form.appendChild(input);

                    // Agregamos el formulario al cuerpo del documento y envíalo
                    document.body.appendChild(form);
                    
                    // Disparamos manualmente el evento submit del formulario
                    var submitEvent = new Event('submit', {
                        bubbles: true,
                        cancelable: true,
                    });

                    // Esperar 500 milisegundos (0,5 segundos) antes de ejecutar la función
                    setTimeout(function() {
                        form.dispatchEvent(submitEvent);
                    }, 500);
                }
            </script>

            <section class="pictogramas" id="pictogramas-pulsadores">
				<?php
					$directorio = "../multimedia/pictogramas_password";
					$page = isset($_GET['page']) ? $_GET['page'] : 1;
					$itemsPerPage = 8; 										// Número de elementos por página

					function addPicto($archivo) {

					}

					function verificarMasElementos($directorio, $currentPage, $itemsPerPage) {

						if (is_dir($directorio)) {
							$archivos = scandir($directorio);
							$extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif');

							$archivos_filtrados = array_filter($archivos, function ($archivo) use ($extensiones_permitidas) {
								$extension = pathinfo($archivo, PATHINFO_EXTENSION);
								return in_array(strtolower($extension), $extensiones_permitidas);
							});

							// Calculamos la cantidad total de elementos y verifica si hay más allá de la página actual
							$totalItems = count($archivos_filtrados);
							$startIndex = ($currentPage - 1) * $itemsPerPage;
							$endIndex = $startIndex + $itemsPerPage;

							return $endIndex < $totalItems;
						}

						return false;
					}                    

                    // Verificamos que la carpeta exista
                    if (is_dir($directorio)) {
                        // Obtenemos la lista de archivos en la carpeta
						$archivos = scandir($directorio);
                        $extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif');

                        $archivos_filtrados = array_filter($archivos, function ($archivo) use ($extensiones_permitidas) {
                            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                            return in_array(strtolower($extension), $extensiones_permitidas);
                        });

                        // Mostramos los archivos de la página actual
                        $start = ($page - 1) * $itemsPerPage;
                        $end = $start + $itemsPerPage - 1;

                        $count = 0;

                        foreach ($archivos_filtrados as $archivo) {
							$archivostr = '"'.$archivo.'"';
							if ($count >= $start && $count <= $end) {
                                echo "<button class='pictograma' id='pictograma' name='pictograma' onclick='enviarFormulario(this)' value='" . $archivo . "'><img src='" . $directorio . "/" . $archivo . "' alt='" . $archivo . "' title='" . $archivo . "'></button>";
                            }
                            $count++;
                        }
                    }
                ?>
			</section>
			<div id="-login-incorrecto" aria-live="assertive" role="status" style='display: none;'></div>	

			<script>
				document.addEventListener("DOMContentLoaded", function () {
					var pictogramas = document.getElementById("pictogramas-pulsadores");
                    const resultDiv = document.getElementById("-login-incorrecto");

					var elementos = pictogramas.children;
					var tiempoPorElemento = 2000; // Tiempo en milisegundos por cada elemento

					var indiceActual = -1;

					// Función para manejar el barrido
					function barrerElementos() {
						// Quita el foco del elemento actual
						if (elementos[indiceActual]) {
							elementos[indiceActual].blur();
						}

						// Incrementa el índice o reinicia si llega al final
						indiceActual = (indiceActual + 1) % elementos.length;

						// Establece el foco en el nuevo elemento
						elementos[indiceActual].focus();
					}

                    // Inicia el barrido y establece el intervalo
                    var intervalo = setInterval(barrerElementos, tiempoPorElemento);

                    // Creamos los elementos de audio y los agregamos al documento
                    const sonidoCorrecto = new Audio("../multimedia/sonidos/correcto.mp3");
                    const sonidoIncorrecto = new Audio("../multimedia/sonidos/incorrecto.mp3");

                    form.addEventListener("submit", async function (event) {
                        event.preventDefault();

                        // Realizamos la lógica de autenticación con PHP aquí
                        const response = await fetch("../php/login_alumnos_pictos.php", {
                            method: "POST",
                            body: new FormData(form),
                        });

                        const result = await response.text();

                        // Mostramos el resultado en la pantalla
                        if (result === "correcto") {
                            // Reproducimos el sonido de éxito
                            sonidoCorrecto.play();

                            showResult("icono_correcto", "green");
                            setTimeout(function () {
                                window.location.href = "../alumnos/alumno.php";
                            }, 1700);      // Redirigimos después de 2 segundos
                        } else {
                            // Reproducimos el sonido de error
                            sonidoIncorrecto.play();

                            showResult("icono_incorrecto", "red");
                            setTimeout(function () {
                                window.location.href = "../alumnos/inicio_sesion_pulsadores.php";
                            }, 1700);      // Redirigimos después de 1 segundo
                        }
                    });

                    function showResult(message, color) {
                        resultDiv.style.display = "flex";
                        resultDiv.innerHTML = "<button id='mensaje-login' style='border-color: " + color + "'><img src='../multimedia/imagenes/" + message  + ".png' width='300' height='300' alt='Icono iniciar sesión'></button>";
                        resultDiv.style.color = color;
                    }
				});
			</script>
        </main>

        <footer>

        </footer>
    </body>
</html>