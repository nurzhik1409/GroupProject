<?php
session_start();

if (isset ($_POST['role'])){
    $_SESSION['case_role'] = $_POST['role'];
    switch ($_SESSION['case_role']){
        case "Соискатель":
            header('Location: registrationForSeekerPhaseOne.php');
        break;
        case "Работодатель":
            header('Location: registrationForRabPhaseOne.php');
        break;
        default :
            echo "What???";
        break;
    }
}
?>
