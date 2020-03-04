<?php
session_start();
require_once "connection.php";
$link = mysqli_connect($host, $user, $password, $database)
    or die ("Error: " . mysqli_error($link));

if (isset($_POST['name']) && isset($_POST['activity'])){
    $name = htmlentities(mysqli_real_escape_string($link, $_POST['name']));
    $activity = htmlentities(mysqli_real_escape_string($link, $_POST['activity']));

    $queryInsertCompane = "INSERT INTO compane VALUES (NULL, '$name', '$activity')";
    $resultInsertCompane = mysqli_query($link, $queryInsertCompane);
    if ($resultInsertCompane){
        $querySelectIdCompane = "SELECT MAX(Id) FROM compane";
        $resultIdCompane = mysqli_query($link, $querySelectIdCompane);
        if($resultIdCompane){
            while($row = mysqli_fetch_row($resultIdCompane)){
                $_SESSION['Id_Compane'] = $row[0];
            }
        }
    }
    $queryInsertRab = "INSERT INTO rabotodatel VALUES (NULL," . $_SESSION['Id_Compane'] . " , ". $_SESSION['Id_reg'] .")";
    $resultInsertRab = mysqli_query($link, $queryInsertRab);
    if ($resultInsertRab){
        header("Location:companeRabPhaseThree.php");
    }
}
?>