<?php
session_start();
require_once "connection.php";
$link = mysqli_connect($host,$user,$password,$database)
    or die ("Error: " . mysqli_error($link));
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Test Insert In DataBase</title>
        <meta charset="utf-8" />
    </head>
    <body>
        <?php 
            if (isset ($_POST['E-mail']) && isset ($_POST['phone_number']) && isset ($_POST['adress'])){

                $Email = htmlentities(mysqli_real_escape_string($link, $_POST['E-mail']));
                $phone = htmlentities(mysqli_real_escape_string($link, $_POST['phone_number']));
                $adress = htmlentities(mysqli_real_escape_string($link, $_POST['adress']));
                $query = "INSERT INTO contacts VALUES (NULL, '$Email', '$phone', '$adress')";
                $result = mysqli_query($link, $query);

                if ($result){
                    $query_1 = "SELECT MAX(Id) FROM contacts";
                    $result_1 = mysqli_query($link, $query_1);
                    
                    if($result_1){
                        while ($row = mysqli_fetch_row($result_1)) {
                            $_SESSION['Id_contacts'] = $row[0];
                        }
                        echo $_SESSION['Id_contacts'];
                        echo $_SESSION['Id_role'];
                    }
                }
                mysqli_close($link);
            }
        ?>
        <form action = "registrationForRabPhaseThree.php" method = "POST">
            <h3>Персональные данные</h3>
            <p>Ваше ФИО:</p>
            <input type = "text" name = "FIO" />
            <p>Ваш логин:</p>
            <input type = "text" name = "login" />
            <p>Ваш пароль:</p>
            <input type = "text" name = "pass" />
            <p></p>
            <input type = "submit" value = "Зарегистрироваться" />
        </form>
    </body>
</html>