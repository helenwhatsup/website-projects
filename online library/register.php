<?php
        require 'database.php';
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $repass = trim($_POST['repass']);

        if($password != $repass){
                echo "Please enter the same password";
                exit;
        }
        else {
                $hashedPass = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $mysqli->prepare("insert into users(username, password) values (?, ?)");
                if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                }
                $stmt->bind_param('ss', $username, $hashedPass);
                $stmt->execute();
                $stmt->close();

                session_start();
                $_SESSION['username'] = $username;
                header("Location: login.html");
        }



?>