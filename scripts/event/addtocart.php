<?php

    if(!isset($_SESSION)) session_start();

    include_once("../connection.php");

    $retObj = (object) [
        'status' => -1
    ];

    if ( ! empty( $_POST ) ) {
        if ( isset( $_POST['eventId'] ) && isset( $_POST['eventInstanceId'] ) && isset( $_POST['ticketAmount'] ) ) {

            $pdo = Connection::getConnection();

            $eventId = $_POST['eventId'];
            $eventInstanceId = $_POST['eventInstanceId'];
            $ticketAmount = $_POST['ticketAmount'];

            $query = $pdo->prepare("SELECT ((ticketsSold + ?) <= tickets) as isAvalible FROM eventInstances WHERE eventId = ? AND id = ?");
            $query->execute([$ticketAmount, $eventId, $eventInstanceId]);

            $eventData = $query->fetch(PDO::FETCH_ASSOC);

            if($eventData != NULL) {
                $isAvalible = $eventData["isAvalible"];

                if($isAvalible) {

                    $pdo->beginTransaction();

                    try {

                        for ($i = 0; $i < $ticketAmount; $i++) {
                            $query = $pdo->prepare("INSERT INTO ticketsSold(eventInstanceId, ownerId) VALUES (?, ?)");
                            $query->execute([$eventInstanceId, $_SESSION['user_id']]);
                        }
                        
                        $query = $pdo->prepare("UPDATE eventInstances SET ticketsSold = (ticketsSold + ?) WHERE id = ?");
                        $query->execute([$ticketAmount, $eventInstanceId]);

                        $pdo->commit();

                        $retObj->status = 0;

                    } catch (\Exception $e) {
                        $pdo->rollback();
                        //throw $e;
                    }

                } else {
                    $retObj->status = 1; //No hay suficientes entradas
                }
            }
        }
    }

    echo json_encode($retObj);

?>