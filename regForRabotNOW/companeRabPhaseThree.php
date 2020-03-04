<?php
session_start();
require_once "connection.php";
$link = mysqli_connect($host,$user,$password,$database)
    or die ("Error ". mysqli_error($link));

    if(isset($_POST['usltrud'])){

        $special = $_POST['spec'];
        $querySelectInSpecial = "SELECT Id FROM specialty WHERE Название_специальности = '$special'";
        $resultSpecial = mysqli_query($link, $querySelectInSpecial);
        
        if ($resultSpecial){
            while ($row = mysqli_fetch_row($resultSpecial)){
                $_SESSION['Id_special'] = $row[0];
            }
        }

        $zpot = $_POST['zpot'];
        $zpdo = $_POST['zpdo'];
        $graph = $_POST['graph'];
        $socPackage = $_POST['socPackage'];

        $queryInsertUslTruda = "INSERT INTO usl_truda VALUES (NULL, $zpot, $zpdo, '$graph', '$socPackage' , 
            ". $_SESSION['Id_special'] ." , " . $_SESSION['Id_Compane'] . ")";
        $resultInsertUslTruda = mysqli_query($link, $queryInsertUslTruda);
        if ($resultInsertUslTruda){
            echo "Успешно добавили!";
        }
    }
mysqli_close($link);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Test Insert In DataBase</title>
        <meta charset="utf-8" />
    </head>
    <body>
        <form method = "POST"> 
            <h3>Условия труда</h3>
            <p>Специальность</p>
                <select name='spec'>
                    <?php
                        $query = "SELECT Название_специальности FROM specialty";

                        $result = mysqli_query($link, $query);

                        if ($result){
                            while ($row = mysqli_fetch_row($result)){
                                echo "<option value = '$row[0]'>$row[0]</option>";
                            }
                        }
                    ?>
                </select>
            <p>Зарплата от:</p>
                <input type = "text" name = "zpot" />
            <p>Зарплата до:</p>
                <input type = "text" name = "zpdo" />
            <p>График работы:</p>
                <select name="graph">
                    <option value="Свободный">Свободный</option>
                    <option value="Вахтовый">Вахтовый</option>
                    <option value="Полный">Полный</option>
                    <option value="Неполный">Неполный</option>
                </select>
            <p>Социальный пакет</p>
                <textarea name = "socPackage"></textarea>
            <p></p>
            <input type = "submit" name = "usltrud" value = "Добавить условие труда для данной специальности"/>
            <p></p>
            <input type = "submit" formaction = "act.php" value = "Перейти к личному кабинету" />
        </form>
    </body>
</html>