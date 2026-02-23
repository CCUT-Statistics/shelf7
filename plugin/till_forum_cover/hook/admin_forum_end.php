//<?php

if($action == 'upload_cover') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $allowedTypes = [
                'image/jpeg' => 'jpeg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/bmp' => 'bmp'
            ];

            if (in_array($file['type'], array_keys($allowedTypes))) {
                $extension = $allowedTypes[$file['type']];
                $k = uniqid(); 
                $cover_file = "../upload/forum_cover/{$k}.{$extension}";
                if(!file_exists(APP_PATH . '/upload/forum_cover/')) {
                    mkdir(APP_PATH . '/upload/forum_cover/');
                }
                if (move_uploaded_file($file['tmp_name'], $cover_file)) {
                    message(0,substr($cover_file, 3));
                    die;

                } else {
                    message(4,"Error uploading file.");
                    die;
                }
            } else {
                message(3,"Invalid file type.");
                die;
            }
        } else {
            message(2,"No file uploaded.");
            die;
        }
    } else {
        message(1,"Invalid request method.");
        die;
    }

}