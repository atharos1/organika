<?php

    include_once("../connection.php");

    if(!isset($_SESSION)) session_start();

    $retObj = (object) [
        'status' => -1
    ];

    if ( isset( $_POST['name'] ) && isset( $_SESSION['user_id'] ) ) {
        
        $pdo = Connection::getConnection();

        $query = $pdo->prepare("INSERT INTO artists (name, addedBy) VALUES (?, ?)");
        $query->execute([$_POST['name'], $_SESSION['user_id']]);

        $id = $pdo->lastInsertId();

        $retObj->insertedId = $id;
        $retObj->status = 0;
    }

    echo json_encode($retObj);