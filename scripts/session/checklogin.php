<?php
    if(!isset($_SESSION)) session_start();

    include_once("../connection.php");

    if ( !isset( $_SESSION['user_id'] ) ) {
        $retObj = (object) [
            'logged' => false
        ];
    } else {

        $pdo = Connection::getConnection();

        $query = $pdo->prepare("SELECT name, usertype FROM users WHERE id = ?");
        $query->execute([$_SESSION['user_id']]);
        $row = $query->fetch(PDO::FETCH_ASSOC);

        $retObj = (object) [
            'logged' => true,
            'name' => $row['name'],
            'userType' => $row['usertype']
        ];
    }

    echo json_encode($retObj);