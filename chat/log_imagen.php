<?php
require_once('../php/chats.class.php');

if(isset($_POST['chat_id']))
{
  $id = $_POST['chat_id'];
  $tmp = new Chats();
  $msjs = $tmp->obtenerMensajes($id);

  if($msjs) {
    foreach ($msjs as $msj) {
      $sender = $msj['sender'];
      $senderimg = "../multimedia/imagenes/" . $msj['senderimg'];
      $mensaje = "../multimedia/imagenes_chat/" . $msj['mensaje'];
      $fecha = $msj['fecha'];
      echo "<div class='mensajeimg'><img src='$senderimg' width='75' height='75'> <img src='$mensaje' width='110' height='110'></div></br>";
    }
  }
}
?>