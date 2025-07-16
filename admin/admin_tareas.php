<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Perfil de administrador - Tareas</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
		<script src="../javascript/header_responsive.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/admin.css">
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
				<h1 id='tituloPrincipal'>Tareas</h1></div>
				<a id='enlace-header' href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
			</div>
		</header>

		<main>
			<div class="div-principal">
				<section class="opciones-admin">
					<a href="admin_tareas.php"><button><h3>Tareas</h3></button></a>
				
					<a href="admin_profesores.php"><button><h3>Profesores</h3></button></a>

					<a href="admin_alumnos.php"><button><h3>Alumnos</h3></button></a>

					<a href="admin_multimedia.php"><button><h3>Multimedia</h3></button></a>
				</section>

				<section class="tareas">
					<div class="barra-busqueda">
						<form action="admin_tareas.php" method="get">
							<input type="text" id="filtro" name="filtro" placeholder="Busqueda"><br><br>
							<input type="submit" id="boton-buscar" value="Buscar">
						</form>
						<a href="crear_tareas.php"><button>Nueva Tarea</button></a>
					</div>

					<table>
						<tbody>
							<tr>
								<th><b>NOMBRE</b></th>
								<th style='width:10%'><b>CHAT TEXTO</b></th>
								<th style='width:10%'><b>CHAT IMAGENES</b></th>
							</tr>
							<?php
								require_once('../php/tareas.class.php');
								require_once('../php/chats.class.php');

								$tmp = new Tareas();
								$tmp2 = new Chats();
								$tareas = $tmp->obtenerTareas();
								$_SESSION['tarea'] = array(); 			// Inicializa $_SESSION['tarea'] como una matriz vacía
								$i = 0;

								if (empty($_GET["page"])) {
									$page = 1;
								} else {
									$page = $_GET["page"];
								}

								if($tareas){
									$perPage = 5;
									$startIndex = ($page - 1) * $perPage;
									$endIndex = $startIndex + $perPage - 1;

									foreach ($tareas as $tarea) {
										if ($i >= $startIndex && $i <= $endIndex) {
											$tareasTitulo[$i] = $tarea['titulo'];
											$tareasIcono[$i] = $tarea['ruta_icono'];
											

											// Guardamos en una variable de sesion de la tarea correspondiente
											$_SESSION['tarea'][$i] = serialize($tarea);
											$_SESSION['chat'][$i*2] = serialize($tmp2->obtenerChatconId($tarea['chat_text_id']));
											$_SESSION['chat'][$i*2+1] = serialize($tmp2->obtenerChatconId($tarea['chat_pict_id']));
											
											// Creamos todos los articles de las tareas
											echo "<tr>
												<td><a href='../admin/asignar_tareas.php?indice=$i'><h3>{$tareasTitulo[$i]}</h3>
												<img src='../multimedia/imagenes/{$tareasIcono[$i]}' width='60' height='60' alt='Icono tarea'></div></a></td>
												<td><a href='../chat/chat_texto.php?chat=" . $i*2 . "'><button>Chat texto</button></td>
												<td><a href='../chat/chat_imagen.php?chat=" . $i*2+1 . "'><button>Chat imagenes</button></td>
											</tr>";
										}
										$i++;
									}
								
									$pagep = $page+1;
									$pagem = $page-1;
									echo "</tbody>
									</table>
									<form method='get'>";
										if($page!=1) {
											echo "<button type='submit' name='page' value='$pagem' action='admin_tareas.php'><<</button>";
										} else {echo "<div></div>";}
										echo "<span>Page $page</span>";
										if(sizeof($tareas)>$page*$perPage) {
											echo "<button type='submit' name='page' value='$pagep' action='admin_tareas.php'>>></button>";
										} else {echo "<div></div>";}
									echo "</form>";
								}
								else{
									echo "<article class='alumno'><h2>No hay ninguna tarea registrada</h2></article></tbody></table>";
								}
							?>
				</section>
			</div>
		</main>

		<footer>
		</footer>
	</body>
</html>