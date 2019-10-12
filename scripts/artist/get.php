<?php
    include_once("../connection.php");

    $retObj = (object) [
        'status' => -1
    ];

    $pdo = Connection::getConnection();

    $query = $pdo->prepare("SELECT id, name as text FROM artists ORDER BY name");
    $query->execute();
    $artistList = $query->fetchAll(PDO::FETCH_OBJ);

    if($artistList) {
        $retObj->results = $artistList;

        $retObj->status = 0;
    } else {
        $retObj->status = 1;
    }

    echo json_encode($retObj);

?>