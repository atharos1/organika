<?php
    if(!isset($_SESSION)) session_start();

    include_once("../connection.php");

    $retObj = (object) [
        'status' => -1
    ];

    $pdo = Connection::getConnection();

    $query = $pdo->prepare("SELECT 
        COUNT(s.id) as amount, 
        e.title, e.ticketPrice, e.imgCover, e.id as eventId, 
        a.name as artistName, 
        l.name as locationName, l.addressText as locationAddress, 
        t.name as eventType, 
        i.date as eventDate, i.time as eventTime 
        FROM ticketsSold s 
        INNER JOIN eventInstances i ON i.id = s.eventInstanceId 
        INNER JOIN events e ON e.id = i.eventId 
        INNER JOIN artists a ON e.artistId = a.id 
        INNER JOIN locations l on e.locationId = l.id 
        INNER JOIN eventTypes t on e.eventType = t.id 
        WHERE s.ownerId = ? 
        GROUP BY s.eventInstanceId 
        ORDER BY eventDate");
    $query->execute([$_SESSION['user_id']]);
    $tickets = $query->fetchAll(PDO::FETCH_OBJ);

    if($tickets) {
        $retObj->tickets = $tickets;

        $retObj->status = 0;
    } else {
        $retObj->status = 1;
    }

    echo json_encode($retObj);

?>