<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Perfil de profesor</title>
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

					// Si hay una sesión activa de usuario, mostrar el nombre de usuario y la posibilidad de cerrar sesión
					if (isset($_SESSION['usuario'])) {

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
					else{		// Si no hay ninguna sesión de usuario activa
						header("Location: ../index.php");
					}
				?>
				<div id="div-titulo"><img src='../multimedia/imagenes/icono_profesor.png' width='60' height='60' alt='Icono profesor'>
				<h1 id='tituloPrincipal'>Perfil</h1></div>
				<a id='enlace-header' href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
			</div>
		</header>

		<main>
			<?php 
				if (isset($_SESSION['usuario'])) {

					// Acceder a los datos del usuario almacenados en las variables de sesión
                    $nombre = $_SESSION['nombre'];
                    $apellidos = $_SESSION['apellidos'];
					$aula = $_SESSION['aula'];
                    $ruta_foto = $_SESSION['ruta_foto'];
                    $usuario = $_SESSION['usuario'];
                    $password = $_SESSION['password'];
				}
			?>

			<a href="javascript:void(0);" onclick="volverPaginaAnterior()" class="boton-volver" aria-label="Volver a la página anterior" role="button">&#129152;</a>

			<script>
				function volverPaginaAnterior() {
					window.history.length > 1 ? window.history.go(-1) : window.location.href = document.referrer;
				}
			</script>

			<article id="tituloSecundario">
				<img src='../multimedia/imagenes/icono_usuario.png' width='30' height='30' alt='Icono usuario'>
				<h2><?php echo $nombre . ' ' . $apellidos; ?></h2>
			</article>
			<form onsubmit="return validarFormularioRegistroProfesor(event, '')" action="../php/modificar_profesor.php" method="POST" class="formulario" id="formulario-modificar">
				<button type="button" onclick="habilitarEdicion()" id="boton-editar">Editar perfil</button>
				<button type="button" onclick="deshabilitarEdicion()" id="boton-cerrarEdicion" style="display: none;">Cerrar X</button>

				<article class="campo">
					<label for="nombre" class="titulo-campo">Nombre:</label>
					<input type="text" id="nombre" name="nombre" value="<?php echo $nombre?>" required disabled>
					<p id="nombre-incorrecto" style="display:none;">El nombre debe contener &uacute;nicamente caracteres alfab&eacute;ticos</p>
				</article>
				
				<article class="campo">
					<label for="apellidos" class="titulo-campo">Apellidos:</label>
					<input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos?>" required disabled>
					<p id="apellidos-incorrecto" style="display:none;">Los apellidos deben contener &uacute;nicamente caracteres alfab&eacute;ticos</p>
				</article>

                <article class="campo">
					<label for="ruta_foto" class="titulo-campo">Fotograf&iacute;a:</label>
					<input type="text" id="ruta_foto" name="ruta_foto" value="<?php echo $ruta_foto?>" required disabled>
					<p id="ruta_foto-incorrecto" style="display:none;">La fotograf&iacute;a debe corresponder a un archivo v&aacute;lido de imagen</p>
				</article>

				<article class="campo">
					<label for="aula" class="titulo-campo">Aula:</label>
					<input type="text" id="aula" name="aula" value="<?php echo $aula?>" required disabled>
					<p id="aula-incorrecto" style="display:none;">El aula debe contener &uacute;nicamente caracteres alfan&uacute;mericos</p>
				</article>

				<article class="campo">
					<label for="usuario" class="titulo-campo">Nombre de usuario:</label>
					<input type="text" id="usuario" name="usuario" value="<?php echo $usuario?>" required disabled>
					<p id="usuario-incorrecto" style="display:none;">El nombre de usuario debe tener entre 4 y 30 carcteres y contener &uacute;nicamente letras, n&uacute;meros, guiones y guiones bajos</p>
				</article>
      
				<article class="campo">
					<label for="password" class="titulo-campo">Contrase&ntilde;a:</label>
					<input type="password" id="password" name="password" value="<?php echo $password?>" required disabled>
					<p id="password-incorrecto" style="display:none;">La contrase&ntilde;a debe tener 4 o más caracteres</p>
				</article>
				
				<article class="campo">
					<label for="password-confirm" class="titulo-campo">Confirmar Contrase&ntilde;a:</label>
					<input type="password" id="password-confirm" name="password-confirm" value="<?php echo $password?>" required disabled>
					<p id="password-confirm-incorrecto" style="display:none;">La contrase&ntilde;a no coincide. Int&eacute;ntalo de nuevo</p>
				</article>
				
				<article class="enviar">
					<input type="submit" id="boton-enviar" value="Guardar cambios" style="display:none;" disabled>
				</article>

				<?php
					if (isset($_SESSION['usuarioRepetidoBD']) && $_SESSION['usuarioRepetidoBD'] == true) {
						echo "<p id='usuarioBD-incorrecto'>El usuario introducido ya existe. Por favor, ingrese un nombre de usuario diferente </p>";

						$_SESSION['usuarioRepetidoBD'] = false;
					}
				?>
			</form>
		</main>

		<footer>
		</footer>
	</body>
</html>