<?php

require 'database.php';
include 'editstorytitle.php';
$update = $_POST['storytitle'];

    echo $s_username;
echo "<br>";
    echo $story_id;
echo "<br>";
echo $update;


if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Error editing");
}
else{

if (assert( $_POST["operation"])){



switch($_POST["operation"]){
//looks to see which radio button was pressed, link or title
case "Title":

        $stmt = $mysqli->prepare("update story set story_title = ? where story_id = ?");
        if(!$stmt){
         printf("Query Prep Failed: %s\n", $mysqli->error);
         exit;
        }
        $stmt->bind_param('si', $update, $story_id);
        if (!$stmt->execute()){
            echo "Fail to update :( ";
        }

        $stmt->fetch();
        $stmt->close();
        break;

case "Link":
        $stmt = $mysqli->prepare("update story set link = ? where story_id = ?");
        if(!$stmt){
         printf("Query Prep Failed: %s\n", $mysqli->error);
         exit;
        }
        $stmt->bind_param('si', $update, $story_id);
        if (!$stmt->execute()){
            echo "Fail to update :( ";
        }


        $stmt->fetch();
        $stmt->close();
        break;
default:
        echo "error";
}

}
else {
        echo "fail to update";
}

}

?>
