<?php
session_start();
require_once 'connection.php'; 

$link = mysqli_connect($host, $user, $password, $database)
    or die ("Error: ". mysqli_error($link));

    if (isset($_POST['spec']) && isset($_POST['prof']) && isset($_POST['institution']) && isset($_POST['Is_true']) && isset($_POST['description']) && isset ($_POST['links'])){
        $special = $_POST['spec'];
        $querySelectInSpecial = "SELECT Id FROM specialty WHERE Название_специальности = '$special'";
        $resultSpecial = mysqli_query($link, $querySelectInSpecial);
        
        if ($resultSpecial){
            while ($row = mysqli_fetch_row($resultSpecial)){
                $_SESSION['Id_special'] = $row[0];
            }
        }

        $profession = $_POST['prof'];
        $institution = $_POST['institution'];
        $queryInsertInEducation = "INSERT INTO education VALUES (NULL, '$institution', ". $_SESSION['Id_special'] ." , '$profession')";
        $resultEducation = mysqli_query($link, $queryInsertInEducation);
        if($resultEducation){
            $queryEducationId = "SELECT MAX(Id) FROM education";
            $resultEducationId = mysqli_query($link, $queryEducationId);
            if ($resultEducationId){
                while ($row = mysqli_fetch_row($resultEducationId)){
                    $_SESSION['Id_Education'] = $row[0];
                }
            }
        }

        $Is_true = $_POST['Is_true'];
        $description = $_POST['description'];
        $links = $_POST['links'];
        $queryInsertInExp = "INSERT INTO experiense VALUES (NULL, '$Is_true', '$description', '$links')";
        $resultExp = mysqli_query($link, $queryInsertInExp);
        if ($resultExp){
            $queryExpId = "SELECT MAX(Id) FROM experiense";
            $resultExpId = mysqli_query($link, $queryExpId);
            if ($resultExpId){
                while ($row = mysqli_fetch_row($resultExpId)){
                    $_SESSION['Id_Exp'] = $row[0];
                }
            }
        }   

        $queryInsertIntoProfQual = "INSERT INTO professional_qualities VALUES (NULL, " . $_SESSION['Id_Exp'] . "," . $_SESSION['Id_Education'] . "," 
            . $_SESSION['Id_Seeker'] . ")";
        $resultProfQual = mysqli_query($link, $queryInsertIntoProfQual)
            or die ("Error: ". mysqli_error($link));
        if($resultProfQual){
            echo "GREAT!!!";
        }        
    }
mysqli_close($link);
?>