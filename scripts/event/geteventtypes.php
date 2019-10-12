<?php
    if(!isset($_SESSION)) session_start();

    include_once("../connection.php");

    $retObj = (object) [
        'status' => -1
    ];

    $pdo = Connection::getConnection();

    $query = $pdo->prepare("SELECT id, name from eventTypes");
    $query->execute();
    $eventTypes = $query->fetchAll(PDO::FETCH_OBJ);

    if($eventTypes) {
        $retObj->eventTypes = $eventTypes;

        $retObj->status = 0;
    } else {
        $retObj->status = 1;
    }

    echo json_encode($retObj);

?>