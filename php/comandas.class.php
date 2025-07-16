<?php
    require_once ('datos_object.class.php');

    // Cada instancia de la clase Comandas se corresponde con una fila/registro de la tabla del mismo nombre
    class Comandas extends DataObject {
        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que devuelve los menus */
        public static function obtenerMenus() {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_MENUS;
        
            try {
                $st = $conexion->prepare($sql);
                $st->execute();
                $menus = $st->fetchAll(PDO::FETCH_ASSOC);
        
                parent::desconectar($conexion);
        
                return $menus;
            } catch (PDOException $e) {
                parent::desconectar($conexion);
                return false;
            }
        }
        /****************************************************************************************/
    }
 ?>