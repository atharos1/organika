<?php

    $retObj = (object) [
        'status' => -1
    ];

    if ( ! empty( $_GET ) ) {
        if ( isset( $_GET['eventId'] ) ) {
            $directory = "../../img/events/" . $_GET['eventId'];
            $imageFileTypes = "{jpg,png,bmp}";
            $videoFileTypes = "{mp4}";

            $server_images = glob($directory . "/*.".$imageFileTypes, GLOB_BRACE);
            $imageList = [];
            foreach($server_images as $image)
                array_push($imageList, basename($image));
            $retObj->images = $imageList;

            $server_videos = glob($directory . "/*.".$videoFileTypes, GLOB_BRACE);
            $videoList = [];
            foreach($server_videos as $video)
                array_push($videoList, basename($video));
            $retObj->videos = $videoList;

            $retObj->status = 0;
        }
    }

    echo json_encode($retObj);