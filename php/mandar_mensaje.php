<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('chats.class.php');

        $chat = new Chats();
        $chat_id = $_POST['input_chat_id'];
        $sender = $_POST['input_sender'];
        $senderimg = $_POST['input_senderimg'];
        $mensaje = $_POST['input_mensaje'];

        //Implementar sanitacion de user input

        $chat->insertarMensaje($chat_id, $sender, $senderimg, $mensaje);
    }
?>