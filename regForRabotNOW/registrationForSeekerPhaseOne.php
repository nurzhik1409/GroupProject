<?php
session_start();
require_once 'connection.php';
$link = mysqli_connect($host,$user,$password,$database)
    or die ("Error ". mysqli_error($link));
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Test Insert In DataBase</title>
        <meta charset="utf-8" />
    </head>
    <body>
        <?php                            
            if (isset ($_SESSION['case_role'])){

                $role = $_SESSION['case_role'];

                $query = "SELECT Id FROM role WHERE Роль = '$role'";
                
                $result = mysqli_query($link, $query)
                    or die ("Error ". mysqli_error($link));

                if ($result){
                    while ($row = mysqli_fetch_row($result)) {
                        $_SESSION['Id_role'] = $row[0];
                    }
                    echo $_SESSION['Id_role'];
                }
                mysqli_close($link);
            }
        ?>
        <form action = 'registrationForSeekerPhaseTwo.php' method = 'POST'>
            <h3>Ваши контакты</h3>
            <p>Ваш E-mail:</p>
            <input type = "text" name = "E-mail" />
            <p>Ваш номер телефона:</p>
            <input type = "text" name = "phone_number" />
            <p>Ваш адрес проживания:</p>
            <input type = "text" name = "adress" />
            <p></p>
            <input type = "submit" value = "Продолжить" />
        </form>
    </body>
</html>