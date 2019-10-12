<?php
    include_once("../connection.php");

    $retObj = (object) [
        'status' => -1
    ];

    $pdo = Connection::getConnection();

    $query = $pdo->prepare("SELECT id, CONCAT(name, ' (', addresstext, ')') as text FROM locations ORDER BY name");
    $query->execute();
    $locationList = $query->fetchAll(PDO::FETCH_OBJ);

    if($locationList) {
        $retObj->results = $locationList;

        $retObj->status = 0;
    } else {
        $retObj->status = 1;
    }

    echo json_encode($retObj);

?>