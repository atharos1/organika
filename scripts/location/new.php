<?php

    include_once("../connection.php");

    if(!isset($_SESSION)) session_start();

    $retObj = (object) [
        'status' => -1
    ];

    if ( isset( $_POST['name'] ) && isset( $_POST['addresstext'] ) && isset( $_POST['lat'] ) && isset( $_POST['lon'] ) && isset( $_SESSION['user_id'] ) ) {

        $pdo = Connection::getConnection();
        
        $query = $pdo->prepare("INSERT INTO locations (name, addresstext, lat, lon, addedby) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$_POST['name'], $_POST['addresstext'], $_POST['lat'], $_POST['lon'], $_SESSION['user_id']]);

        $id = $pdo->lastInsertId();

        $retObj->insertedId = $id;
        $retObj->status = 0;
    }

    echo json_encode($retObj);