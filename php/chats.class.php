<?php
    require_once ('datos_object.class.php');

    // Cada instancia de la clase Chats se corresponde con una fila/registro de la tabla del mismo nombre
    class Chats extends DataObject { 

        /****************************************************************************************/
        /****************************************************************************************/
        /* Constructor */
        protected $datos = array(
            "tipo" => "",
            "alumno_id" => "",
            "profesor_id"=>""
        );
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que devuelve el chan con id indicada */
        public static function obtenerChatconId($chat_id) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_CHATS . " WHERE id = :chat_id";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":chat_id", $chat_id, PDO::PARAM_INT );
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
        /* Funcion que devuelve el chan qu conecta al alumno y profesor con id indicadas */
        public static function obtenerChat($alumno_id, $profesor_id) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_CHATS . " WHERE (alumno_id = :alumno_id) AND (profesor_id = :profesor_id)";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":alumno_id", $alumno_id, PDO::PARAM_INT );
                $st->bindValue( ":profesor_id", $profesor_id, PDO::PARAM_INT );
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
        /* Funcion que devuelve todos los mensajes de un chat con id indicada */
        public static function obtenerMensajes($id_chat) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_MENSAJES . " WHERE chat_id = :id_chat";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue(":id_chat", $id_chat, PDO::PARAM_INT );
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
        /* Funcion que inserta un mensaje en la BD */
        public static function insertarMensaje($chat_id, $sender, $senderimg, $mensaje) {
            $conexion = parent::conectar();
            $sql="INSERT INTO " . TABLA_MENSAJES . "(chat_id, sender, senderimg, mensaje, fecha) VALUES (?, ?, ?, ?, DEFAULT)";

            try {
                $st = $conexion->prepare( $sql );
                $st->execute([$chat_id, $sender, $senderimg, $mensaje]);
                parent::desconectar( $conexion );
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        /****************************************************************************************/
    }
?>