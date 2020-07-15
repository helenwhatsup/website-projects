<?php
        require 'database.php';
        //insert user to new database
        session_start();

//      header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
        $newUser = (string)mysql_real_escape_string($_POST['r_username']);
        $newPassword = (string)mysql_real_escape_string(crypt($_POST['r_password']));

        if (strlen($newUser)>0 && strlen($newPassword)>0){
                $stmt = $mysqli->prepare("insert into users(username, password) values (?, ?)");
                if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                }

                $stmt->bind_param('ss', $newUser, $newPassword);

                $stmt->execute();

                echo json_encode(array("success" => true));

                $stmt->close();
        }
        else{
                echo json_encode(array(
                        "success" => false,
                        "message" => "Empty Username or Password"
                        ));
                exit;
        }

?>
