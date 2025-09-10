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
    <link rel="stylesheet" type="text/css" href="../css/comandas.css">
    
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
                require_once('../php/comandas.class.php');
                require_once('../php/profesores.class.php');

                // Iniciar la sesión
                session_start();

                // Si hay una sesión activa de usuario, mostrar el nombre de usuario y la posibilidad de cerrar sesión
                if (isset($_SESSION['sesion_alumno']) && $_SESSION['sesion_alumno'] == true) {
                    // Acceder al nombre de usuario almacenado en la variable de sesión
                    $username = $_SESSION['nombre'];
                    $ruta_foto = $_SESSION['ruta_foto'];

                    // Creamos en HTML la zona arriba a la derecha de un usuario que ha iniciado sesión
                    echo "<div id='perfil-login'>
                                <a href='../alumnos/alumno.php'>
                                    <div><img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'></div>
                                    <div><h2>$username</h2></div>
                                </a>
                            </div>";
                } else { // Si no hay ninguna sesión de usuario activa
                    header("Location: ../index.php");
                }

                $seccion_actual = isset($_GET['section']) ? $_GET['section'] : 'imagenes';

                // Obtener el parámetro del aula desde la URL
                $aula = isset($_GET['aula']) ? $_GET['aula'] : null;

                // Validar si el aula está presente
                if (!$aula) {
                    echo "Error: Aula no especificada.";
                    exit;
                }

                // Obtener la información de los menús disponibles
                $menusDisponibles = Comandas::obtenerMenus();
                $tmp = new Profesores();
                $profesor = $tmp->obtenerProfesorAula($aula);
                $ruta_foto = $profesor['ruta_foto'];

                // Verificar si hay algún menú disponible
                if (!$menusDisponibles) {
                    echo "No hay menús disponibles.";
                    exit;
                }
            ?>

            <div id='div-titulo'>
                <?php echo "<img src='../multimedia/imagenes/$ruta_foto' alt='Foto del profesor'>";?>
                <h1 id='tituloPrincipal'>Aula <?= $aula; ?></h1>
            </div>
            <a id='enlace-header' href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
        </div>
    </header>

    <main>
        <div class="botones">
            <a href='../alumnos/alumno.php' class='boton-casa' id='casa'>
                <button>
                    <img src='../multimedia/imagenes/icono_casa.png' width="50" height="50" alt='Casa'>
                </button>
            </a>
        </div>

        <div class="imagen-tarea">
            <?php
            // Obtener el menú actual
            $menuActual = isset($_GET['menu']) ? $_GET['menu'] : 0;

            // Verificar si se envió un formulario con la cantidad
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Actualizar la base de datos con la cantidad recibida del formulario

                // Incrementar el índice del menú actual
                $menuActual++;

                // Redirigir al siguiente menú
                header("Location: ver_menus.php?aula=$aula&menu=$menuActual");
                exit;
            }

            // Verificar si hay más menús para mostrar
            if ($menuActual < count($menusDisponibles)) {
                $menu = $menusDisponibles[$menuActual];
                $idMenu = $menu['id_menu'];
                $nombreMenu = $menu['nombre_menu'];
                $descripcionMenu = $menu['descripcion_menu'];
                $ruta_foto_comida = $menu['ruta_foto'];

                // Mostrar la información del menú
                echo "<div class='menu-item'>";
                echo "<img src='../multimedia/imagenes/$ruta_foto_comida' alt='Foto del menú $nombreMenu' width='100px' height='100px'>";
                echo "<h2>$nombreMenu</h2>";
                echo "<p>$descripcionMenu</p>";
                echo "</div>";

                // Formulario para seleccionar la cantidad
                echo "<form method='POST' action='ver_menus.php?aula=$aula&menu=$menuActual'>";
                echo "<div class='botones'>";
                for ($i = 0; $i <= 7; $i++) {
                    // Agregar un botón para cada cantidad
                    echo "<button class='boton-pantalla' type='submit' name='cantidad' value='$i'><img src='../multimedia/imagenes/imagen_$i.png' alt='$i'></button>";
                }
                echo "</div>";
                echo "</form>";
            } else {
                // Todos los menús han sido procesados
                echo "<p>¡Comanda completada!</p>";

                // Redirigir a la página de alumnos.php
                header("Location: ../alumnos/comandas.php");
                exit;
            }
            ?>
        </div>
    </main>

</body>

</html>
