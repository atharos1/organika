<?php
    if(!isset($_SESSION)) session_start();

    include_once("../connection.php");
    include_once("../session/userdata.php");

    $retObj = (object) [
        'status' => -1
    ];

    if(getPrivilegeLevel() < PrivilegeLevels::ORGANIZER) {
        $retObj->status = -2;
        echo json_encode($retObj);
        die();
    }

    if ( ! empty( $_GET ) ) {
        if ( isset( $_GET['eventId'] ) ) {

            $pdo = Connection::getConnection();

            $query = $pdo->prepare("SELECT e.title, e.description, e.ticketPrice, e.imgCover,
                e.artistId, 
                e.locationId, 
                e.eventType 
                FROM events e
                WHERE e.id = ? AND e.adminId = ?");
            $query->execute([$_GET['eventId'], $_SESSION['user_id']]);
            $eventData = $query->fetch(PDO::FETCH_OBJ);

            $query = $pdo->prepare("SELECT id, date, time, tickets, ticketsSold
                FROM eventInstances
                WHERE eventId = ?
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