<?php

    //TODO: COMPROBACIONES DE SEGURIDAD, ARCHIVOS PERMITIDOS, TAMAÑOS, Y PRIVILEGIOS, TANTO EN PHP COMO EN JAVASCRIPT

    if(!isset($_SESSION)) session_start();

    include_once("../connection.php");
    include_once("../session/userdata.php");

    if(getPrivilegeLevel() < PrivilegeLevels::ORGANIZER) {
        $retObj->status = -2;
        echo json_encode($retObj);
        die();
    }

    $eventId = $_POST["eventId"];

    $retObj = (object) [
        'status' => -1
    ];

    $coverImage = json_decode($_POST["coverImage"]);
    $newCover = ($coverImage->serverName == NULL);

    $pdo = Connection::getConnection();

    if(isset($eventId)) { //Mod

        $query = $pdo->prepare("UPDATE events SET
            title = ?,
            description = ?,
            ticketprice = ?,
            artistId = ?,
            locationId = ?,
            eventType = ?
            WHERE Id = ? AND adminId = ?");
        $query->execute([$_POST["eventTitle"], $_POST["eventDescription"], $_POST["ticketPrice"], $_POST["artistId"], 
        $_POST["locationId"], $_POST["eventType"], 
        $_POST["eventId"], $_SESSION['user_id']]);

        $retObj->status = 0;

    } else {

        $query = $pdo->prepare("INSERT INTO events (
            title,
            description, 
            ticketprice, 
            artistId, 
            locationId, 
            eventType, 
            adminId
        ) VALUES (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?
        )");
        $query->execute([$_POST["eventTitle"], $_POST["eventDescription"], $_POST["ticketPrice"], $_POST["artistId"], 
        $_POST["locationId"], $_POST["eventType"], $_SESSION['user_id']]);

        $eventId = $pdo->lastInsertId();

        mkdir("../../img/events/" . $eventId . "/", 0777, true);

        $retObj->status = 0;

    }

    $retObj->eventId = $eventId;


    $instancesList = $_POST["instancesList"];
    for($i = 0; $i < count($instancesList); $i++) {
        $instance = json_decode( $instancesList[$i] );
        if($instance->id == 0) {
            $query = $pdo->prepare("INSERT INTO eventInstances (eventId, date, time, tickets) VALUES (?, ?, ?, ?)");
            $query->execute([$eventId, $instance->date, $instance->time, $instance->tickets]);
        } else {
            $query = $pdo->prepare("UPDATE eventInstances SET date = ?, time = ?, tickets = ? WHERE eventId = ? AND Id = ?");
            $query->execute([$instance->date, $instance->time, $instance->tickets, $eventId, $instance->id]);
        }
    }



    $deleteList = $_POST["deleteList"];

    $target_path = "../../img/events/" . $eventId . "/";
    $glob = glob($target_path ."*");

    $files_total = count($_FILES['file']['name']);
    $files_uploaded = 0;
    $files_error = 0;

    $deleted_total = count($deleteList);
    $deleted_success = 0;
    $deleted_error = 0;


    for($i=0; $i < $files_total; $i++) {
        $filenamekey = md5(uniqid($_FILES["file"]["name"][$i], true));
        $finalFileName = $filenamekey . "." . strtolower(pathinfo($_FILES["file"]["name"][$i], PATHINFO_EXTENSION));

        if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path . $finalFileName)) {
            if($newCover && $coverImage->file == $_FILES["file"]["name"][$i]) {
                $coverImage->serverName = $finalFileName;
            }

            $files_uploaded++;
        } else {
            $files_error++;
        }
    }

    for($j=0; $j < $deleted_total; $j++) {
        unlink($target_path . $deleteList[$j]); //TODO: Hacer chequeo, podría fallar y bla bla bla
        $deleted_success++;
    }

    $query = $pdo->prepare("UPDATE events SET
            imgCover = ?
            WHERE Id = ? AND adminId = ?");
    $query->execute([$coverImage->serverName, 
        $eventId, $_SESSION['user_id']]);

    $retObj->images = (object) [
        'upload' => (object) [
            'received' => $files_total,
            'seccesses' => $files_uploaded,
            'failtures' => $files_error
        ],
        'deletion' => (object) [
            'received' => $deleted_total,
            'seccesses' => $deleted_success,
            'failtures' => $deleted_error
        ]
    ];

echo json_encode($retObj);