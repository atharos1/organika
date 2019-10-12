<?php
    if(!isset($_SESSION)) session_start();

    include_once("../connection.php");

    $retObj = (object) [
        'status' => -1
    ];

    $pdo = Connection::getConnection();

    $query = $pdo->prepare("SELECT COUNT(*) as quantity FROM ticketsSold s 
        INNER JOIN eventInstances i ON i.id = s.eventInstanceId 
        WHERE 
        TIMESTAMP(i.date, i.time) > NOW() AND 
        s.ownerId = ?");

    $query->execute([$_SESSION['user_id']]);
    $tickets = $query->fetch(PDO::FETCH_ASSOC);

    if($tickets != NULL) {
        $retObj->ticketCount = $tickets["quantity"];

        $retObj->status = 0;
    } else {
        $retObj->status = 1;
    }

    echo json_encode($retObj);

?>

