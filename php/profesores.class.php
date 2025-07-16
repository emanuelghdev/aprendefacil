<?php
    require_once ('datos_object.class.php');

    // Cada instancia de la clase Profesores se corresponde con una fila/registro de la tabla del mismo nombre
    class Profesores extends DataObject {

        /****************************************************************************************/
        /****************************************************************************************/
        /* Constructor */
        protected $datos = array(
            "nombre" => "",
            "apellidos" => "",
            "usuario"=>"",
            "password"=>"",
            "es_administrador"=>"",
            "aula"=>"",
            "ruta_foto"=>""
        );
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion boolean que se encarga de comprobar si existe un profesor
        que tenga el nombre de usuario y la contraseña pasada */
        public static function comprobarProfesor($usuario, $password) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_PROFESORES . " WHERE usuario = :usuario AND password = :password";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":usuario", $usuario, PDO::PARAM_STR );
                $st->bindValue( ":password", $password, PDO::PARAM_STR );
                $st->execute();
                $fila = $st->fetch();
                parent::desconectar( $conexion );
                
                if($fila) return true;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );

                return false;
            }
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion boolean que se encarga de comprobar si existe en la
        tabla de datos una entrada con el usuario pasado */
        public static function existeProfesor($usuario) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_PROFESORES . " WHERE usuario = :usuario";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":usuario", $usuario, PDO::PARAM_STR );
                $st->execute();
                $fila = $st->fetch();
                parent::desconectar( $conexion );
                
                if($fila) return true;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );

                return false;
            }
        }
        /****************************************************************************************/
        
        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que devuelve el profesor con el nombre de usuario pasado */
        public static function obtenerProfesor($usuario) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_PROFESORES . " WHERE usuario = :usuario";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":usuario", $usuario, PDO::PARAM_STR );
                $st->execute();
                $fila = $st->fetch();
                parent::desconectar( $conexion );

                if ( $fila ) return $fila;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que devuelve todos los alumnos de la BD */
        public static function obtenerProfesores( ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_PROFESORES;

            try {
                $st = $conexion->prepare( $sql );
                $st->execute();
                $filas = $st->fetchAll(PDO::FETCH_ASSOC);
                parent::desconectar( $conexion );

                if ( $filas ) return $filas;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que devuelve todas las aulas de las que están a cargo los profesores */
        public static function obtenerAulas() {
            $conexion = parent::conectar();
            $sql = "SELECT DISTINCT aula FROM " . TABLA_PROFESORES . " ORDER BY aula ASC";

            try {
                $st = $conexion->prepare($sql);
                $st->execute();
                $resultados = $st->fetchAll(PDO::FETCH_ASSOC);
                parent::desconectar($conexion);

                // Obtener un array con todas las aulas
                $aulas = array_column($resultados, 'aula');

                return $aulas;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        /****************************************************************************************/


        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que devuelve todas las aulas de las que están a cargo los profesores */
        public static function obtenerProfesorAula($aula) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_PROFESORES . " WHERE aula = :aula LIMIT 1";

            try {
                $st = $conexion->prepare($sql);
                $st->bindParam(':aula', $aula, PDO::PARAM_STR);
                $st->execute();
                $profesor = $st->fetch(PDO::FETCH_ASSOC);
                parent::desconectar($conexion);

                return $profesor;
            } catch (PDOException $e) {
                parent::desconectar($conexion);
                die("Consulta fallada: " . $e->getMessage());
            }
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion boolean que se encarga de comprobar si un profeso con ese nombre de usuario 
        es un administrador o no */
        public static function esAdministrador($usuario) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_PROFESORES . " WHERE usuario = :usuario AND es_administrador = true";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":usuario", $usuario, PDO::PARAM_STR );
                $st->execute();
                $fila = $st->fetch();
                parent::desconectar( $conexion );
                
                if($fila){
                    return true;
                }
                else{
                    return false;
                }
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );

                return false;
            }
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que inserta en la tabla profesores un profesor con los datos correspondientes */
        public static function insertarProfesor($nombre, $apellidos, $usuario, $password, $aula, $ruta_foto) {
            $conexion = parent::conectar();

            $profesores = new Profesores();

            // Comprobamos que el profesor a insertar no es un profesor existente, es decir que el usuario no exista ya en la tabla
            if(!$profesores->existeProfesor($usuario)){

                $sql="INSERT INTO " . TABLA_PROFESORES . "(nombre, apellidos, usuario, password, es_administrador, aula, ruta_foto) VALUES (?, ?, ?, ?, ?, ?, ?)";

                try {
                    $st = $conexion->prepare( $sql );
                    $st->execute([$nombre, $apellidos, $usuario, $password, false, $aula, $ruta_foto]);
                    $profesorId = $conexion->lastInsertId();
                    $fila = $st->fetch();
                    parent::desconectar( $conexion );

                    $sql = "SELECT * FROM " . TABLA_ALUMNOS;

                    $st = $conexion->prepare( $sql );
                    $st->execute();
                    $alumnos = $st->fetchAll(PDO::FETCH_ASSOC);
                    if ( $alumnos ){
                         foreach ($alumnos as $alumno) {
                            if ($alumno['tipo_password'] == "texto") {
                                $tipo_chat = false;
                            } else {
                                $tipo_chat = true;
                            }
                            
                            $sql="INSERT INTO " . TABLA_CHATS . "(tipo, alumno_id, profesor_id) VALUES (?, ?, ?)";
                            $st = $conexion->prepare($sql);
                            $st->execute([$tipo_chat, $alumno['id'], $profesorId]);
                         }
                    }

                    header('Location: ../admin/admin_tareas.php');
                } catch ( PDOException $e ) {
                    parent::desconectar( $conexion );
                    
                    header('Location: ../admin/alta_profesores.php');
                }
            }
            else{
                // Iniciar la sesión
                session_start();

                // Almacenamos una variable de sesión para informar que el usuario ya está en nuestra base de datos
                $_SESSION['usuarioRepetidoBD'] = true;

                parent::desconectar( $conexion );
                    
                header('Location: ../admin/alta_profesores.php');
            }
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que modifica en la tabla profesores un profesor con los datos correspondientes */
        public static function modificarProfesor($nombre, $apellidos, $usuario, $password, $aula, $ruta_foto, $usuario_anterior, $cambio_admin) {
            $conexion = parent::conectar();
            $conexion->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );

            $profesores = new Profesores();

            // Comprobamos que el profesor a insertar no es un profesor existente, es decir que el usuario no exista ya en la tabla
            if($usuario == $usuario_anterior || !$profesores->existeProfesor($usuario)){

                $sql="UPDATE " . TABLA_PROFESORES . " SET nombre = :nombre, apellidos = :apellidos, usuario = :usuario, password = :password, aula = :aula, ruta_foto = :ruta_foto WHERE usuario = :usuario_anterior";

                try {
                    $st = $conexion->prepare( $sql );
                    $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                    $st->bindValue( ":apellidos", $apellidos, PDO::PARAM_STR );
                    $st->bindValue( ":usuario", $usuario, PDO::PARAM_STR );
                    $st->bindValue( ":password", $password, PDO::PARAM_STR );
                    $st->bindValue( ":aula", $aula, PDO::PARAM_STR );
                    $st->bindValue( ":ruta_foto", $ruta_foto, PDO::PARAM_STR );
                    $st->bindValue(":usuario_anterior", $usuario_anterior, PDO::PARAM_STR);
                    $st->execute();
                    $fila = $st->fetch();
                    parent::desconectar( $conexion );

                    // Si el cambio ha sido desde el perfil de un profesor
                    if($cambio_admin == false){
                        $profesores = new Profesores( );
                        $profesorActivo = $profesores->obtenerProfesor( $usuario );

                        // Almacenamos los datos modificados del profesor en variables de sesión
                        $_SESSION['nombre'] = $profesorActivo['nombre'];
                        $_SESSION['apellidos'] = $profesorActivo['apellidos'];
                        $_SESSION['aula'] = $profesorActivo['aula'];
                        $_SESSION['ruta_foto'] = $profesorActivo['ruta_foto'];
                        $_SESSION['usuario'] = $profesorActivo['usuario'];
                        $_SESSION['password'] = $profesorActivo['password'];

                        header('Location: ../profesores/modificacion_profesores.php');
                    }
                    else{       // Si por el contrario ha sido un cambio de un admin
                        header('Location: ../admin/admin_profesores.php');
                    }
                } catch ( PDOException $e ) {
                    parent::desconectar( $conexion );
                    header('Location: ../profesores/modificacion_profesores.php');
                }
            }
            else{
                // Iniciar la sesión
                session_start();

                // Almacenamos una variable de sesión para informar que el usuario ya está en nuestra base de datos
                $_SESSION['usuarioRepetidoBD'] = true;

                parent::desconectar( $conexion );
                    
                header('Location: ../profesores/modificacion_profesores.php');
            }
        }
        /****************************************************************************************/
    }
 ?>