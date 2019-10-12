<?php
    if(!isset($_SESSION)) session_start();

    include_once("../connection.php");

    $retObj = (object) [
        'status' => -1
    ];
    $pdo = Connection::getConnection();

    $query = $pdo->prepare("SELECT events.*, locations.name FROM events 
                            JOIN locations
                            ON events.locationId = locations.Id");
    $query->execute();
    $events = $query->fetchAll(PDO::FETCH_OBJ);

    if($events) {
        $retObj->events = $events;
        $retObj->status = 0;
    } else {
        $retObj->status = 1;
    }

    echo json_encode($retObj);

?>