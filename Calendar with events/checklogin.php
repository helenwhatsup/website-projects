<?php

session_start();


if (!(isset($_SESSION['username']) || $_SESSION['username'] != '')) {
        //logged out
        echo json_encode(array(
                "success" => false,
                "message" => "not logged in"
        ));
        exit;
}
else{
//logged in
        $username = (string)$_SESSION['username'];
        ini_set("session.cookie_httponly", 1);

        echo json_encode(array(
                "success" => true,
                "username" => $username,
                "token" => $_SESSION['token']
        ));
        exit;
}


?>
