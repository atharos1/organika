<?php

    include_once("../connection.php");

    $retObj = (object) [
        'status' => -1
    ];

    if ( isset( $_POST['name'] ) && isset( $_POST['surname'] ) && isset( $_POST['mail'] ) && isset( $_POST['password'] ) ) {
        $confirmationKey = md5(microtime());

        $pdo = Connection::getConnection();

        $query = $pdo->prepare("INSERT INTO users (name, surname, mail, password, confirmationKey) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$_POST['name'], $_POST['surname'], $_POST['mail'], password_hash($_POST['password'], PASSWORD_DEFAULT), $confirmationKey]);

        sendConfirmationEmail($_POST['mail'], $confirmationKey);

        if(!isset($_SESSION)) session_start();

        $_SESSION['user_id'] = $pdo->lastInsertId();

        $retObj->status = 0;
    }

    function sendConfirmationEmail($email, $key){
        $e = sha1($email); // For verification purposes
        $to = trim($email);

        $baseAddress = $_SERVER['SERVER_NAME'];
 
        $subject = "Bienvenido a TuviTicket!";
 
        $headers = <<<MESSAGE
From: Tuvi Ticket <donotreply@tuviticket.com>
Content-Type: text/plain;
MESSAGE;
 
        $msg = <<<EMAIL
        Por favor, haga click en el siguiente link para confirmar su dirección de correo electrónico:
        $baseAddress/confirmation.html?key=$key&mail=$email
EMAIL;
 
        return mail($to, $subject, $msg, $headers);
    }

    echo json_encode($retObj);
?>