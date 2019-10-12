<?php
    if(!isset($_SESSION)) session_start();
    include_once("../connection.php");

    abstract class PrivilegeLevels {
        const USER = 0;
        const ORGANIZER = 1;
        const GOD = 2;
    }

    function getPrivilegeLevel() {
        $pdo = Connection::getConnection();
        
        $query = $pdo->prepare("SELECT usertype FROM users WHERE id = ?");
        $query->execute([$_SESSION['user_id']]);
        $row = $query->fetch(PDO::FETCH_ASSOC);

        return $row['usertype'];
    }