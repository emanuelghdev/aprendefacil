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

            <section class="pictogramas">
				<div class='botones-pantalla'><button class='boton-pantalla' id='prevPictos' aria-label="Ir a pictogramas anteriores" style='visibility: hidden;'>&#129152;</button></div>

				<?php
					$directorio = "../multimedia/pictogramas_password";
					$page = isset($_GET['page']) ? $_GET['page'] : 1;
					$itemsPerPage = count(scandir($directorio)) - 2; 					// Número de elementos por página

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
                                echo "<button class='pictograma' id='pictograma' name='pictograma' onClick='addPicto(\"$archivo\")' value='" . $archivo . "'><img src='" . $directorio . "/" . $archivo . "' alt='" . $archivo . "' title='" . $archivo . "'></button>";
                            }
                            $count++;
                        }
                    }
                ?>

				<div class='botones-pantalla'><button class='boton-pantalla' id='posPictos' aria-label='Mostrar más pictogramas'>&#129154;</button></div>
			</section>

			<div class="pictogramas-seleccionados">
				<div><button class='boton-pantalla' onClick='clearPictos()' name='borrar' value='borrar'><img src='../multimedia/imagenes/icono_borrar.png' width='100' height='100' alt='Icono iniciar sesión'></button></div>
				<div class="pictograma-seleccionado"><img id="picto1" src=""></div>
				<div class="pictograma-seleccionado"><img id="picto2" src=""></div>
				<div class="pictograma-seleccionado"><img id="picto3" src=""></div>

				<script>
					let selected = [];
					var d=new Date();
					d.setTime(d.getTime()+(60*1000));
					var expires = "; expires="+d.toGMTString();

					function addPicto(archivo) {
						if(typeof selected[0] == 'undefined') {
							selected[0] = archivo;
							document.getElementById("picto1").src="../multimedia/pictogramas_password/" + archivo;
							document.getElementById("picto1d").value = archivo;
							document.getElementById("picto1").style.visibility = "visible";
							document.cookie = "picto1=" + archivo + expires;
						} else if(typeof selected[1] == 'undefined') {
							selected[1] = archivo;
							document.getElementById("picto2").src="../multimedia/pictogramas_password/" + archivo;
							document.getElementById("picto2d").value = archivo;
							document.getElementById("picto2").style.visibility = "visible";
							document.cookie = "picto2=" + archivo + expires;
						} else if(typeof selected[2] == 'undefined') {
							selected[2] = archivo;
							document.getElementById("picto3").src="../multimedia/pictogramas_password/" + archivo;
							document.getElementById("picto3d").value = archivo;
							document.getElementById("picto3").style.visibility = "visible";
							document.cookie = "picto3=" + archivo + expires;
						}
					}

					function clearPictos() {
						selected = [];
						document.getElementById("picto1").src="";
						document.getElementById("picto2").src="";
						document.getElementById("picto3").src="";
						document.getElementById("picto1").style.visibility = "hidden";
						document.getElementById("picto2").style.visibility = "hidden";
						document.getElementById("picto3").style.visibility = "hidden";
						clearCookies();
					}

					function clearCookies() {
						document.cookie = "picto1=" + "; expires=Thu, 01 Jan 1970 00:00:00 UTC"
						document.cookie = "picto2=" + "; expires=Thu, 01 Jan 1970 00:00:00 UTC"
						document.cookie = "picto3=" + "; expires=Thu, 01 Jan 1970 00:00:00 UTC"
					}

					// Función para obtener el valor de una cookie por su nombre
					function obtenerCookie(picto1,picto2,picto3) {
						var picto1EQ = picto1 + "=";
						var picto2EQ = picto2 + "=";
						var picto3EQ = picto3 + "=";
						var pictos = [];

						var cookies = document.cookie.split(';');
						for (var i = 0; i < cookies.length; i++) {
							var cookie = cookies[i];
							while (cookie.charAt(0) == ' ') {
								cookie = cookie.substring(1, cookie.length);
							}
							if (cookie.indexOf(picto1EQ) == 0) {
								pictos[0] = cookie.substring(picto1EQ.length, cookie.length);
							}else if (cookie.indexOf(picto2EQ) == 0) {
								pictos[1] = cookie.substring(picto2EQ.length, cookie.length);
							}else if (cookie.indexOf(picto3EQ) == 0) {
								pictos[2] = cookie.substring(picto3EQ.length, cookie.length);
							}
						}

						return pictos;
					}	

					// Al cargar la página, verifica si hay una selección guardada y la muestra
					window.onload = function () {
						var pictos = obtenerCookie("picto1","picto2","picto3");
						if (pictos[0]) {
							addPicto(pictos[0]);
						} 
						if (pictos[1]) {
							addPicto(pictos[1]);
						}
						if (pictos[2]) {
							addPicto(pictos[2]);
						}
					};
				</script>

				<form action="../php/login_alumnos_pictos.php" method="POST" class="formulario">
					<p id="password-login-incorrecto" style="display:none;">La contrase&ntilde;a no es v&aacute;lida. Por favor, int&eacute;ntalo de nuevo.</p>
					<input class="hidden" type="text" id="picto1d" name="picto1d">
					<input class="hidden" type="text" id="picto2d" name="picto2d">
					<input class="hidden" type="text" id="picto3d" name="picto3d">
					<button class="boton-pantalla" onClick="clearCookies()" type="submit"><img src='../multimedia/imagenes/icono_entrar.png' width='100' height='100' alt='Icono iniciar sesión'></button>
				</form>
			</div>
			<div id="-login-incorrecto" aria-live="assertive" role="status" style='display: none;'></div>	

			<script>
				document.addEventListener("DOMContentLoaded", function () {
					var pictogramas = document.querySelectorAll(".pictograma");
					var posButton = document.getElementById("posPictos");
					var prevButton = document.getElementById("prevPictos");
					const form = document.querySelector(".formulario");
                    const resultDiv = document.getElementById("-login-incorrecto");

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
                                window.location.href = "../alumnos/inicio_sesion_pictogramas.php";
                            }, 1700);      // Redirigimos después de 1 segundo
                        }
                    });

                    function showResult(message, color) {
                        resultDiv.style.display = "flex";
                        resultDiv.innerHTML = "<button id='mensaje-login' style='border-color: " + color + "'><img src='../multimedia/imagenes/" + message  + ".png' width='300' height='300' alt='Icono iniciar sesión'></button>";
                        resultDiv.style.color = color;
                    }

					function calcularPictogramasPorPantalla() {
						var anchoVentana = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
						var altoVentana = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
						
						// Ajustamos estos valores según el ancho de los alumnos
						var anchoPicto = 200;

						var elemento = document.getElementById("pictograma");
						var numPictogramas = Math.floor(anchoVentana / anchoPicto);
						
						return numPictogramas;
					}


					// Inicializamos el estado de la pantalla
					var pantallaActual = 0;
					actualizarPantalla();

					// Escuchamos el evento del botón para avanzar de pantalla
					posButton.addEventListener("click", function () {
						pantallaActual++;
						actualizarPantalla();
					});

					// Escuchamos el evento del botón para retroceder de pantalla
					prevButton.addEventListener("click", function () {
						pantallaActual--;
						actualizarPantalla();
					});

					function actualizarPantalla() {
						var pictogramasPorPantalla = calcularPictogramasPorPantalla()-1;
						var startIndex = pantallaActual * pictogramasPorPantalla;
						var endIndex = startIndex + pictogramasPorPantalla;

						// Mostramos u ocultamos los pictogramas según la pantalla actual
						pictogramas.forEach(function (pictograma, index) {
							pictograma.style.display = index >= startIndex && index < endIndex ? "block" : "none";
						});

						// Mostramos u ocultamos los botones dependiendo de si hay más pantallas
						posButton.style.visibility = endIndex < pictogramas.length ? "visible" : "hidden";
						prevButton.style.visibility = pantallaActual > 0 ? "visible" : "hidden";
					}

					// Actualizamos el número de pictogramas por pantalla al cambiar el tamaño de la ventana
					window.addEventListener("resize", function () {
						actualizarPantalla();
					});
				});
			</script>
        </main>

        <footer>

        </footer>
    </body>
</html>