<?php
    if(!isset($_SESSION)) session_start();

    session_destroy();

    if(isset($_GET["prev"]))
        header("Location: " . $_GET["prev"]);
    else
        header("Location: /index.html");
    
    die();