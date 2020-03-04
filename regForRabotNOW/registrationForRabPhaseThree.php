<?php
session_start();
require_once 'connection.php'; 
$link = mysqli_connect($host,$user,$password,$database)
    or die ("Error ". mysqli_error($link));
header('Location: companeRabPhaseOne.html');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Test Insert In DataBase</title>
        <meta charset="utf-8" />
    </head>
    <body>
        <?php        
            if (isset ($_POST['FIO']) && isset ($_POST['login']) && isset ($_POST['pass'])){
                
                $FIO = htmlentities(mysqli_real_escape_string($link, $_POST['FIO']));
                $login = htmlentities(mysqli_real_escape_string($link, $_POST['login']));
                $pass = htmlentities(mysqli_real_escape_string($link, $_POST['pass']));

                $query = "INSERT INTO registration VALUES (NULL, '$login', '$pass', " . $_SESSION['Id_role'] . ", '$FIO', " . $_SESSION['Id_contacts'] . ", now())";
                $result = mysqli_query($link, $query);

                if($result){
                    $querySelectIdReg = "SELECT MAX(Id) FROM registration";
                    $resultIdReg = mysqli_query($link, $querySelectIdReg);
                    if($resultIdReg){
                        while ($row = mysqli_fetch_row($resultIdReg)){
                            $_SESSION['Id_reg'] = $row[0];
                        }
                    }
                }
                mysqli_close($link);
            }
        ?>
    </body>
</html>