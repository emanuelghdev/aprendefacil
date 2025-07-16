<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Alta de alumnos</title>
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
				<h1 id='tituloPrincipal'>Alta Alumnos</h1></div>
				<a id='enlace-header' href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
			</div>
		</header>

		<main>
			<a href="../admin/admin_alumnos.php" class="boton-volver" aria-label="Volver a la gestión de alumnos" role="button">&#129152;</a>

			<form onsubmit="return validarFormularioRegistroAlumno(event, '')" action="../php/registrar_alumno.php" method="POST" class="formulario">
				<article id="tituloSecundario">
					<img src='../multimedia/imagenes/icono_usuario.png' width='30' height='30' alt='Icono usuario'>
					<h2>Nuevo Alumno</h2>
				</article>

				<article class="campo">
					<label for="nombre" class="titulo-campo">Nombre:</label>
					<input type="text" id="nombre" name="nombre" placeholder="Introduce el nombre completo" required>
					<p id="nombre-incorrecto" style="display:none;">El nombre debe contener &uacute;nicamente caracteres alfab&eacute;ticos</p>
				</article>
				
				<article class="campo">
					<label for="apellidos" class="titulo-campo">Apellidos:</label>
					<input type="text" id="apellidos" name="apellidos" placeholder="Introduce los apellidos" required>
					<p id="apellidos-incorrecto" style="display:none;">Los apellidos deben contener &uacute;nicamente caracteres alfab&eacute;ticos</p>
				</article>

				<article class="campo">
					<label for="aula" class="titulo-campo">Aula:</label>
					<input type="text" id="aula" name="aula" placeholder="Introduce la letra del aula (A, B, C...)" required>
					<p id="aula-incorrecto" style="display:none;">El aula debe contener &uacute;nicamente caracteres alfan&uacute;mericos</p>
				</article>

                <article class="campo">
					<label for="ruta_foto" class="titulo-campo">Fotograf&iacute;a personal:</label>
					<input type="file" id="ruta_foto" name="ruta_foto" accept="image/*" required>
				</article>

				<article class="campo">
					<fieldset id="fieldset-perfil_visualizacion" name="fieldset-perfil_visualizacion">
						<legend class="titulo-campo">Perfil preferente de visualizaci&oacute;n:</legend>

						<label>
						<input type="checkbox" name="perfil[]" value="audio">Audio</label>

						<label>
						<input type="checkbox" name="perfil[]" value="video">V&iacute;deos</label>

						<label>
						<input type="checkbox" name="perfil[]" value="texto">Texto y Fotos</label>
					</fieldset>
					<p id="fieldset-perfil_visualizacion-incorrecto" style="display:none;">Se debe seleccionar al menos una opci&oacute;n de visualizaci&oacute;n</p>
				</article>

				<article class="campo">
					<fieldset id="fieldset-tipo_password" name="fieldset-tipo_password">
						<legend class="titulo-campo">Tipo de contrase&ntilde;a:</legend>

						<label>
						<input type="radio" name="tipo_password" id="tipo-texto" value="texto">Texto</label>

						<label>
						<input type="radio" name="tipo_password" id="tipo-pictogramas" value="pictogramas">Pictogramas</label>

						<label>
						<input type="radio" name="tipo_password" id="tipo-pulsadores" value="pulsadores">Pulsadores</label>
					</fieldset>
					<p id="fieldset-tipo_password-incorrecto" style="display:none;">Se debe seleccionar al menos un tipo de contrase&ntilde;a</p>
				</article>
      
				<article class="campo" id="campo-password">
					<label for="password" class="titulo-campo">Contrase&ntilde;a:</label>
					<input type="password" id="password" name="password" placeholder="********">
					<p id="password-incorrecto" style="display:none;">La contrase&ntilde;a debe tener 4 o más caracteres</p>
				</article>
				
				<article class="campo" id="campo-password-confirm">
					<label for="password-confirm" class="titulo-campo">Confirmar Contrase&ntilde;a:</label>
					<input type="password" id="password-confirm" name="password-confirm" placeholder="********">
					<p id="password-confirm-incorrecto" style="display:none;">La contrase&ntilde;a no coincide. Int&eacute;ntalo de nuevo</p>
				</article>

				<article class="campo" id="campo-pictogramas" style="display: none;">
					<label for="pictograma_1" class="titulo-campo">Primer Pictograma:</label>
					<input type="file" id="pictograma_1" name="pictograma_1" accept="image/*">

					<label for="pictograma_2" class="titulo-campo">Segundo Pictograma:</label>
					<input type="file" id="pictograma_2" name="pictograma_2" accept="image/*">

					<label for="pictograma_3" class="titulo-campo">Tercer Pictograma:</label>
					<input type="file" id="pictograma_3" name="pictograma_3" accept="image/*">
				</article>

				<article class="campo" id="campo-pulsadores" style="display: none;">
					<label for="pictograma_pulsadores" class="titulo-campo">Pictograma:</label>
					<input type="file" id="pictograma_pulsadores" name="pictograma_pulsadores" accept="image/*">
				</article>
				
				<article class="enviar">
					<input type="submit" value="Registrar Alumno">
				</article>
			</form>

			<script>
				// Función para manejar la visibilidad de los campos de contraseña
				function togglePasswordFields() {
					var tipoTextoCheckbox = document.getElementById('tipo-texto');
					var tipoPictogramasCheckbox = document.getElementById('tipo-pictogramas');
					var tipoPulsadoresCheckbox = document.getElementById('tipo-pulsadores');
					var campoPassword = document.getElementById('campo-password');
					var campoPasswordConfirm = document.getElementById('campo-password-confirm');
					var campoPictogramas = document.getElementById('campo-pictogramas');
					var campoPulsadores = document.getElementById('campo-pulsadores');

					// Si el tipo de contraseña es con texto
					if (tipoTextoCheckbox.checked) {
						campoPassword.style.display = 'block';
						campoPasswordConfirm.style.display = 'block';
						campoPassword.querySelector('input').setAttribute('required', 'required');
                		campoPasswordConfirm.querySelector('input').setAttribute('required', 'required');
					} else {
						campoPassword.style.display = 'none';
						campoPasswordConfirm.style.display = 'none';
						campoPassword.querySelector('input').removeAttribute('required');
                		campoPasswordConfirm.querySelector('input').removeAttribute('required');
					}

					// Si el tipo de contraseña es con pictogramas
					if (tipoPictogramasCheckbox.checked) {
						campoPictogramas.style.display = 'block';
						campoPictogramas.querySelectorAll('input').forEach(function(input) {
							input.setAttribute('required', 'required');
						});
					} else {
						campoPictogramas.style.display = 'none';
						campoPictogramas.querySelectorAll('input').forEach(function(input) {
							input.removeAttribute('required');
						});
					}

					// Si el tipo de contraseña es con pulsadores
					if (tipoPulsadoresCheckbox.checked) {
						campoPulsadores.style.display = 'block';
						input = document.getElementById('pictograma_pulsadores');
						input.setAttribute('required', 'required');
					} else {
						campoPulsadores.style.display = 'none';
						input = document.getElementById('pictograma_pulsadores');
						input.removeAttribute('required');
					}
				}

				// Asociamos la función al evento de cambio del checkbox
				document.getElementById('tipo-texto').addEventListener('change', togglePasswordFields);
				document.getElementById('tipo-pictogramas').addEventListener('change', togglePasswordFields);
				document.getElementById('tipo-pulsadores').addEventListener('change', togglePasswordFields);

				// Llamada inicial para asegurar que los campos se muestren correctamente al cargar la página
				togglePasswordFields();
			</script>
		</main>

		<footer>
		</footer>
	</body>
</html>