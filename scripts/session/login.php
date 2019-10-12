<?php
    if(!isset($_SESSION)) session_start();

    include_once("../connection.php");

    $retObj = (object) [
        'status' => -1
    ];

    if ( ! empty( $_POST ) ) {
        if ( isset( $_POST['mail'] ) && isset( $_POST['password'] ) ) {

            $pdo = Connection::getConnection();

            $query = $pdo->prepare("SELECT id, password FROM users WHERE mail = ?");
            $query->execute([$_POST['mail']]);
            $row = $query->fetch(PDO::FETCH_ASSOC);

            if($row && password_verify( $_POST['password'], $row["password"] ) ) {
                $_SESSION['user_id'] = $row['id'];

                $retObj->status = 0;
            } else {
                $retObj->status = 1;
            }
        }
    }

    echo json_encode($retObj);

?>