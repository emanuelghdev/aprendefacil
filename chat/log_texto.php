<?php
require_once('../php/chats.class.php');

if(isset($_POST['chat_id']))
{
  $id = $_POST['chat_id'];
  $tmp = new Chats();
  $msjs = $tmp->obtenerMensajes($id);

  if($msjs){
    foreach ($msjs as $msj) {
      $sender = $msj['sender'];
      $senderimg = "../multimedia/imagenes/" . $msj['senderimg'];
      $mensaje = $msj['mensaje'];
      $fecha = $msj['fecha'];
      echo "<h4><img src='$senderimg' width='35' heigth='35'><b>$sender:</b></h4> $mensaje</br></br>";
    }
  }

}
?>