<?php
    if(!isset($_SESSION)) session_start();

    include_once("../connection.php");

    $retObj = (object) [
        'status' => -1
    ];

    $pdo = Connection::getConnection();

    $query = $pdo->prepare("SELECT
        e.title, e.ticketPrice, e.imgCover, e.id as eventId,
        i.date as eventDate, i.time as eventTime, i.tickets, i.ticketsSold,
        a.name as artistName,
        l.name as locationName, l.addressText as locationAddress,
        t.name as eventType
        FROM events e
        LEFT JOIN eventInstances i ON i.eventId = e.Id
        INNER JOIN artists a ON e.artistId = a.id
        INNER JOIN locations l on e.locationId = l.id
        INNER JOIN eventTypes t on e.eventType = t.id
        WHERE e.adminId = ?
        ORDER BY created DESC");

    $query->execute([$_SESSION['user_id']]);
    //$query->execute([2]);
    $events = $query->fetchAll(PDO::FETCH_OBJ);

    if($events) {
        $retObj->events = $events;

        $retObj->status = 0;
    } else {
        $retObj->status = 1;
    }

    echo json_encode($retObj);

?>
