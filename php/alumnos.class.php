<?php
    require_once ('datos_object.class.php');

    // Cada instancia de la clase Alumnos se corresponde con una fila/registro de la tabla del mismo nombre
    class Alumnos extends DataObject {

        /****************************************************************************************/
        /****************************************************************************************/
        /* Constructor */
        protected $datos = array(
            "nombre" => "",
            "apellidos" => "",
            "tipo_password"=>"",
            "password"=>"",
            "aula"=>"",
            "perfil_visualizacion"=>"",
            "ruta_foto"=>"",
            "comandas"=>""
        );
        /****************************************************************************************/


        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion boolean que se encarga de comprobar si existe un alumno
        que tenga el id de usuario y la contraseña pasada */
        public static function comprobarAlumno($id, $password) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_ALUMNOS . " WHERE id = :id AND password = :password";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id", $id, PDO::PARAM_STR );
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
        /* Funcion boolean que se encarga de comprobar si existe un alumno
        que tenga el id de usuario y la contraseña de pictogramas pasada */
        public static function comprobarAlumnoPictos($id, $picto1, $picto2, $picto3) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_CONTRASEÑA_PICTOGRAMA . " WHERE alumno_id = :id";
            $numero_pictos = 0;
            $passwd_id = 0;

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id", $id, PDO::PARAM_STR );
                $st->execute();
                $fila = $st->fetch();
                parent::desconectar( $conexion );

                if(!$fila) return false;

                $numero_pictos = $fila['numero_pictogramas'];
                $passwd_id = $fila['id'];
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );

                return false;
            }

            $sql1 = "SELECT * FROM " . TABLA_PICTOGRAMAS . " WHERE password_pictograma_id = :passwd_id AND orden = 1";
            $sql2 = "SELECT * FROM " . TABLA_PICTOGRAMAS . " WHERE password_pictograma_id = :passwd_id AND orden = 2";
            $sql3 = "SELECT * FROM " . TABLA_PICTOGRAMAS . " WHERE password_pictograma_id = :passwd_id AND orden = 3";

            try {
                $st = $conexion->prepare( $sql1 );
                $st->bindValue( ":passwd_id", $passwd_id, PDO::PARAM_STR );
                $st->execute();
                $fila1 = $st->fetch();
                parent::desconectar( $conexion );
                $st = $conexion->prepare( $sql2 );
                $st->bindValue( ":passwd_id", $passwd_id, PDO::PARAM_STR );
                $st->execute();
                $fila2 = $st->fetch();
                parent::desconectar( $conexion );
                $st = $conexion->prepare( $sql3 );
                $st->bindValue( ":passwd_id", $passwd_id, PDO::PARAM_STR );
                $st->execute();
                $fila3 = $st->fetch();
                parent::desconectar( $conexion );

                if(is_array($fila1) && is_array($fila2) && is_array($fila3)){
                    if($fila1['ruta_pictograma'] == $picto1 && $fila2['ruta_pictograma'] == $picto2 && $fila3['ruta_pictograma'] == $picto3){
                        return true;
                    }
                }
                else if(is_array($fila1)){
                    if($fila1['ruta_pictograma'] == $picto1){
                        return true;
                    }
                }
                else{
                    return false;
                }
                
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );

                return false;
            }

            return false;
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que devuelve el alumno con el id pasado */
        public static function obtenerAlumno($id) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_ALUMNOS . " WHERE id = :id";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id", $id, PDO::PARAM_STR );
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
        public static function obtenerAlumnos( ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_ALUMNOS;

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
        /* Funcion que devuelve si es encargado de las comandas el alumno con el id pasado */
        public static function esEncargado($id) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_ALUMNOS . " WHERE id = :id";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id", $id, PDO::PARAM_STR );
                $st->execute();
                $esEncargado= $st->fetch();
                parent::desconectar( $conexion );

                return $esEncargado["comandas"];
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                return false;
            }
        }
        /****************************************************************************************/


        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que asigna encargado de las comandas el alumno con el id pasado */
        public static function asignarComandas($id, $comandas) {
            $conexion = parent::conectar();
            $sql = "UPDATE " . TABLA_ALUMNOS . " SET comandas = :comandas WHERE id = :id";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id", $id, PDO::PARAM_STR );
                $st->bindValue( ":comandas", $comandas, PDO::PARAM_STR );
                $st->execute();
                $filasAfectadas = $st->rowCount();
                parent::desconectar($conexion);

                return $filasAfectadas > 0; // Devuelve true si se realizaron cambios, false si no se encontró ninguna coincidencia
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                return false;
            }
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que inserta en la tabla alumnos un alumno con los datos correspondientes */
        public static function insertarAlumno($nombre, $apellidos, $tipo_password, $password, $pictogramas, $aula, $perfil_visualizacion, $ruta_foto) {
            $conexion = parent::conectar();

            try {
                // Iniciamos la transacción
                $conexion->beginTransaction(); 
        
                // Insertar datos en la tabla "alumnos"
                $sql = "INSERT INTO " . TABLA_ALUMNOS . "(nombre, apellidos, tipo_password, password, aula, perfil_visualizacion, ruta_foto) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $st = $conexion->prepare($sql);
                $st->execute([$nombre, $apellidos, $tipo_password, $password, $aula, $perfil_visualizacion, $ruta_foto]);
                $alumnoId = $conexion->lastInsertId(); // Obtener el ID del último registro insertado en "alumnos"

                // Si hay pictogramas que añadir los procesamos
                if($tipo_password == "pictogramas"){
                    // Insertar datos en la tabla "password_pictograma"
                    $sql = "INSERT INTO password_pictograma (alumno_id, numero_pictogramas) VALUES (?, ?)";
                    $st = $conexion->prepare($sql);
                    $st->execute([$alumnoId, count($pictogramas)]);
                    $passwordPictogramaId = $conexion->lastInsertId(); // Obtener el ID del último registro insertado en "password_pictograma"
            
                    // Insertar datos en la tabla "pictogramas"
                    $sql = "INSERT INTO pictogramas (ruta_pictograma, password_pictograma_id, orden) VALUES (?, ?, ?)";
                    $st = $conexion->prepare($sql);
            
                    foreach ($pictogramas as $orden => $ruta) {
                        $st->execute([$ruta, $passwordPictogramaId, $orden]);
                    }
                }
                else if($tipo_password == "pulsadores"){
                    // Insertar datos en la tabla "password_pictograma"
                    $sql = "INSERT INTO password_pictograma (alumno_id, numero_pictogramas) VALUES (?, ?)";
                    $st = $conexion->prepare($sql);
                    $st->execute([$alumnoId, 1]);
                    $passwordPictogramaId = $conexion->lastInsertId(); // Obtener el ID del último registro insertado en "password_pictograma"
            
                    // Insertar datos en la tabla "pictogramas"
                    $sql = "INSERT INTO pictogramas (ruta_pictograma, password_pictograma_id, orden) VALUES (?, ?, ?)";
                    $st = $conexion->prepare($sql);
            
                    foreach ($pictogramas as $orden => $ruta) {
                        $st->execute([$ruta, $passwordPictogramaId, $orden]);
                        break;
                    }
                }

                if ($tipo_password == "texto") {
                    $tipo_chat = false;
                } else {
                    $tipo_chat = true;
                }

                $sql = "SELECT * FROM " . TABLA_PROFESORES;

                $st = $conexion->prepare( $sql );
                $st->execute();
                $profesores = $st->fetchAll(PDO::FETCH_ASSOC);
                if ( $profesores ){
                     foreach ($profesores as $profesor) {
                        $sql="INSERT INTO " . TABLA_CHATS . "(tipo, alumno_id, profesor_id) VALUES (?, ?, ?)";
                        $st = $conexion->prepare($sql);
                        $st->execute([$tipo_chat, $alumnoId, $profesor['id']]);
                     }
                }
        
                // Confirmamos la transacción
                $conexion->commit(); 
        
                header('Location: ../admin/admin_alumnos.php');
            } catch (PDOException $e) {
                // Deshacemos la transacción en caso de error
                $conexion->rollBack(); 
        
                header('Location: ../admin/alta_alumnos.php');
            } finally {
                parent::desconectar($conexion);
            }
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que modifica en la tabla alumnos un alumno con los datos correspondientes */
        public static function modificarAlumno($nombre, $apellidos, $aula, $perfil_visualizacion, $tipo_password, $password, $pictogramas, $ruta_foto, $id_alumno) {
            $conexion = parent::conectar();
            $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            try {
                // Iniciamos la transacción
                $conexion->beginTransaction();

                // Actualizar datos en la tabla "alumnos"
                $sql = "UPDATE " . TABLA_ALUMNOS . " SET nombre = :nombre, apellidos = :apellidos, aula = :aula, perfil_visualizacion = :perfil_visualizacion, tipo_password = :tipo_password, password = :password, ruta_foto = :ruta_foto WHERE id = :id_alumno";
                $st = $conexion->prepare($sql);
                $st->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                $st->bindValue(":apellidos", $apellidos, PDO::PARAM_STR);
                $st->bindValue(":aula", $aula, PDO::PARAM_STR);
                $st->bindValue(":perfil_visualizacion", $perfil_visualizacion, PDO::PARAM_STR);
                $st->bindValue(":tipo_password", $tipo_password, PDO::PARAM_STR);
                $st->bindValue(":password", $password, PDO::PARAM_STR);
                $st->bindValue(":ruta_foto", $ruta_foto, PDO::PARAM_STR);
                $st->bindValue(":id_alumno", $id_alumno, PDO::PARAM_STR);
                $st->execute();

                // Eliminar registros antiguos de "pictogramas" relacionados con el alumno
                $sql = "DELETE FROM " . TABLA_PICTOGRAMAS . "  WHERE password_pictograma_id IN (SELECT id FROM " . TABLA_CONTRASEÑA_PICTOGRAMA . "  WHERE alumno_id = :id_alumno)";
                $st = $conexion->prepare($sql);
                $st->bindValue(":id_alumno", $id_alumno, PDO::PARAM_INT);
                $st->execute();

                $sql = "DELETE FROM " . TABLA_CONTRASEÑA_PICTOGRAMA . "  WHERE alumno_id = :id_alumno";
                $st = $conexion->prepare($sql);
                $st->bindValue(":id_alumno", $id_alumno, PDO::PARAM_INT);
                $st->execute();

                // Si hay pictogramas que añadir los procesamos
                if($tipo_password == "pictogramas"){
                    // Insertar datos en la tabla "password_pictograma"
                    $sql = "INSERT INTO " . TABLA_CONTRASEÑA_PICTOGRAMA . "  (alumno_id, numero_pictogramas) VALUES (?, ?)";
                    $st = $conexion->prepare($sql);
                    $st->execute([$id_alumno, count($pictogramas)]);
                    $passwordPictogramaId = $conexion->lastInsertId(); // Obtener el ID del último registro insertado en "password_pictograma"

                    // Insertar datos en la tabla "pictogramas"
                    $sqlPictograma = "INSERT INTO " . TABLA_PICTOGRAMAS . "  (ruta_pictograma, password_pictograma_id, orden) VALUES (?, ?, ?)";
                    $stPictograma = $conexion->prepare($sqlPictograma);

                    foreach ($pictogramas as $orden => $ruta) {
                        $stPictograma->execute([$ruta, $passwordPictogramaId, $orden]);
                    }
                }
                else if($tipo_password == "pulsadores"){
                    // Insertar datos en la tabla "password_pictograma"
                    $sql = "INSERT INTO " . TABLA_CONTRASEÑA_PICTOGRAMA . "  (alumno_id, numero_pictogramas) VALUES (?, ?)";
                    $st = $conexion->prepare($sql);
                    $st->execute([$id_alumno, 1]);
                    $passwordPictogramaId = $conexion->lastInsertId(); // Obtener el ID del último registro insertado en "password_pictograma"

                    // Insertar datos en la tabla "pictogramas"
                    $sqlPictograma = "INSERT INTO " . TABLA_PICTOGRAMAS . "  (ruta_pictograma, password_pictograma_id, orden) VALUES (?, ?, ?)";
                    $stPictograma = $conexion->prepare($sqlPictograma);

                    foreach ($pictogramas as $orden => $ruta) {
                        $stPictograma->execute([$ruta, $passwordPictogramaId, $orden]);
                        break;
                    }
                }

                // Confirmamos la transacción
                $conexion->commit(); 

                header('Location: ../admin/admin_alumnos.php');
            } catch (PDOException $e) {
                // Deshacemos la transacción en caso de error
                $conexion->rollBack(); 

                header('Location: ../admin/admin_alumnos.php');
            } finally {
                parent::desconectar($conexion);
            }
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        public static function obtenerPictogramasAlumno($id_alumno) {
            $conexion = parent::conectar();
        
            try {
                $sql = "SELECT ruta_pictograma FROM " . TABLA_PICTOGRAMAS . "  WHERE password_pictograma_id IN (SELECT id FROM " . TABLA_CONTRASEÑA_PICTOGRAMA . "  WHERE alumno_id = ?) ORDER BY orden";
                $st = $conexion->prepare($sql);
                $st->execute([$id_alumno]);
                $pictogramas = $st->fetchAll(PDO::FETCH_COLUMN);
        
                parent::desconectar($conexion);

                // Evitamos que el array esté vacio, creamos uno con valores vacios
                if(empty($pictogramas)){
                    for($i=0; $i<3; $i++){
                        $pictogramas[$i] = "";
                    }
                }
        
                return $pictogramas;
            } catch (PDOException $e) {
                parent::desconectar($conexion);

                // Evitamos que el array esté vacio, creamos uno con valores vacios
                for($i=0; $i<3; $i++){
                    $pictogramas[$i] = "";
                }

                return $pictogramas;
            }
        }
        /****************************************************************************************/
    }
 ?>