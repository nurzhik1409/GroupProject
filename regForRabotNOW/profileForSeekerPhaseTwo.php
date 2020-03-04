<?php
session_start();
require_once 'connection.php'; 

$link = mysqli_connect($host, $user, $password, $database)
    or die ("Error: ". mysqli_error($link));

if (isset($_POST ['zpot']) && isset ($_POST ['zpdo']) && isset ($_POST ['graph']) && isset($_POST ['gender']) && isset ($_POST ['baby_count']) && isset ($_POST ['maried']) 
    && isset( $_POST ['aim'])){

    $zpot = htmlentities(mysqli_real_escape_string($link, $_POST['zpot']));
    $zpdo = htmlentities(mysqli_real_escape_string($link, $_POST['zpdo']));
    $graph = htmlentities(mysqli_real_escape_string($link, $_POST['graph']));
    $queryInsertInHopesSeeker = "INSERT INTO hopes_seeker VALUES (NULL, '$zpot', '$zpdo', '$graph')";
    $resultHopesSeeker = mysqli_query($link, $queryInsertInHopesSeeker);

    if ($resultHopesSeeker){
        $queryHopesSeekerSelectId = "SELECT MAX(Id) FROM hopes_seeker";
        $resultHopesSeekerId = mysqli_query ($link, $queryHopesSeekerSelectId);
        if ($resultHopesSeekerId){
            while($row = mysqli_fetch_row($resultHopesSeekerId)){
                $_SESSION['Id_Hopes_Seeker'] = $row[0];
                echo $_SESSION['Id_Hopes_Seeker'];
            }
        }
    }

    $gender = htmlentities(mysqli_real_escape_string($link, $_POST['gender']));
    $baby_count = htmlentities(mysqli_real_escape_string($link, $_POST['baby_count']));
    $maried = htmlentities(mysqli_real_escape_string($link, $_POST['maried']));
    $aim = htmlentities(mysqli_real_escape_string($link, $_POST['aim']));
    $queryInsertInPersonalData = "INSERT INTO personal_data VALUES (NULL, '$gender', '$baby_count', '$maried', '$aim')";
    $resultPersonalData = mysqli_query($link, $queryInsertInPersonalData);

    if ($resultPersonalData){
        $queryPersonalDataSelectId = "SELECT MAX(Id) FROM personal_data";
        $resultPersonalDataId = mysqli_query($link, $queryPersonalDataSelectId);
        if ($resultPersonalDataId){
            while($row = mysqli_fetch_row($resultPersonalDataId)){
                $_SESSION['Id_Personal_Data'] = $row[0];
                echo $_SESSION['Id_Personal_Data'];
            }
        }
    }
}
?>

<?php
if (isset($_POST['gramota']) && isset($_POST['sertifikat'])){
    $gramota = htmlentities(mysqli_real_escape_string($link, $_POST['gramota']));
    $sertifikat = htmlentities(mysqli_real_escape_string($link, $_POST['sertifikat']));
    $queryInsertMerits = "INSERT INTO merits VALUES (NULL, '$gramota', '$sertifikat')";
    $resultMerits = mysqli_query($link, $queryInsertMerits);
    if ($resultMerits){
        $queryMeritsSelectId = "SELECT MAX(Id) FROM merits";
        $resultMeritsId = mysqli_query($link, $queryMeritsSelectId);
        if($resultMeritsId){
            while($row = mysqli_fetch_row($resultMeritsId)){
                $_SESSION['Id_Merits'] = $row[0];
                echo $_SESSION['Id_Mertis'];
            }
        }
    }
}

if(isset($_POST['PC_skills']) && isset($_POST['Knowlege_languages']) && isset($_POST['Addition_education'])){
   $PC_skills = htmlentities(mysqli_real_escape_string($link, $_POST['PC_skills']));
   $Knowlege_languages = htmlentities(mysqli_real_escape_string($link, $_POST['Knowlege_languages']));
   $Addition_education = htmlentities(mysqli_real_escape_string($link, $_POST['Addition_education']));
   $queryInsertAdditionalProfessionalQualities = "INSERT INTO additional_professional_qualities VALUES (NULL, '$PC_skills', '$Knowlege_languages', '$Addition_education' , 
    ". $_SESSION['Id_Merits'] ." )";
   $resultAdditionalProfessionalQualities = mysqli_query($link, $queryInsertAdditionalProfessionalQualities);
   if ($resultAdditionalProfessionalQualities){
       $queryAdditionProfessionQualitiesId = "SELECT MAX(Id) FROM additional_professional_qualities";
       $resultAdditionProfessionQualitiesId = mysqli_query($link, $queryAdditionProfessionQualitiesId);
       if ($resultAdditionProfessionQualitiesId){
           while($row = mysqli_fetch_row($resultAdditionProfessionQualitiesId)){
               $_SESSION['Id_additional_professional_qualities'] = $row[0];
               echo $_SESSION['Id_additional_professional_qualities'];
           }
       }
   }
           
    $queryInsertIntoSeeker = "INSERT INTO seeker VALUES (NULL, " . $_SESSION['Id_Hopes_Seeker'] . "," . $_SESSION['Id_additional_professional_qualities'] . "," 
        . $_SESSION['Id_Personal_Data'] . "," . $_SESSION['Id_Registration'] . ")";
    $resultSeeker = mysqli_query($link, $queryInsertIntoSeeker);
    if($resultSeeker){
        $querySeekerId = "SELECT MAX(Id) FROM seeker";
        $resultSeekerId = mysqli_query($link, $querySeekerId);
        if ($resultSeekerId){
            while ($row = mysqli_fetch_row($resultSeekerId)){
                $_SESSION['Id_Seeker'] = $row[0];
            }
        }
        echo $_SESSION['Id_Seeker'];
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Анкета соискателя</title>
        <meta charset="utf-8" />
    </head>
    <body>
        <form name = 'profile' action = '' method = 'post'>
            <h3>Профессиональные качества</h3>
                <p>Специальность</p>
                    <select name='spec' onChange='document.profile.submit();'>
                        <option value='<?if($_POST['spec']!=''){ echo $_POST['spec'];}?>'><?if($_POST['spec']!=''){ echo $_POST['spec'];}?></option>
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
                <p>Профессия</p>
                    <select name = 'prof' onChange=''>
                        <?php
                            if (isset ($_POST['spec'])){
                                $Name_special = $_POST['spec'];
                                $query_1 = "SELECT Id FROM specialty WHERE Название_специальности = '$Name_special'";
                                $result_1 = mysqli_query($link, $query_1);
                                if ($result_1){
                                    while ($row = mysqli_fetch_row($result_1)){
                                        $Id_special = $row[0];
                                    }
                                    $query_2 = "SELECT Id, Название FROM profession WHERE Id_Специальности = $Id_special";
                                    $result_2 = mysqli_query($link, $query_2);
                                    if ($result_2){
                                        while ($row = mysqli_fetch_row($result_2)){
                                        echo "<option value = '$row[0]' >$row[1]</option>";
                                        }
                                    }
                                }
                            }
                        ?>
                    </select>
                <p>Наличие опыта работы</p>
                    <select name="Is_true">
                        <option value="Имеется">Имеется</option>
                        <option value="Не имеется">Не имеется</option>
                    </select>
                <p>Описание</p>
                    <textarea name="description"></textarea>
                <p>Ссылки на проекты</p>
                    <textarea name="links"></textarea>
                <p>Учебное заведение</p>
                    <input type="text" name="institution" />
                
                <input type = "submit" value = "Продолжить" formaction = "profileForSeekerPhaseThree.php" formmethod = "POST"/>
            </form>
    </body>
</html>