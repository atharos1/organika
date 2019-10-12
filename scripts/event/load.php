<?php
    if(!isset($_SESSION)) session_start();

    include_once("../connection.php");

    $retObj = (object) [
        'status' => -1
    ];

    if ( ! empty( $_GET ) ) {
        if ( isset( $_GET['eventId'] ) ) {

            $pdo = Connection::getConnection();

            $query = $pdo->prepare("SELECT e.title, e.description, e.ticketPrice, e.imgCover,
                a.name as artistName,
                l.name as locationName, l.addressText as locationAddress, l.lon, l.lat,
                t.name as eventType
                FROM events e
                INNER JOIN artists a ON e.artistId = a.id
                INNER JOIN locations l on e.locationId = l.id
                INNER JOIN eventTypes t on e.eventType = t.id
                WHERE e.id = ?");
            $query->execute([$_GET['eventId']]);
            $eventData = $query->fetch(PDO::FETCH_OBJ);

            $query = $pdo->prepare("SELECT id, date, time, 
                CASE 
                WHEN ticketsSold < tickets THEN false
                ELSE true
                END as isFull
                FROM eventInstances
                WHERE eventId = ? AND
                TIMESTAMP(date, time) > NOW()
                ORDER BY date");
            $query->execute([$_GET['eventId']]);
            $eventInstances = $query->fetchAll(PDO::FETCH_OBJ);

            if($eventData) {
                $retObj->eventData = $eventData;
                $retObj->eventInstances = $eventInstances;

                $retObj->status = 0;
            } else {
                $retObj->status = 1;
            }
        }
    }

    echo json_encode($retObj);

?>