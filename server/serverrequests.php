<?php

header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');







if (isset($_POST["destination"])) {

    require_once 'config.php';
    require_once 'DBoperations.php';
    require_once 'cryptpass.php';

    session_start();

    if ($_POST["destination"] == "signin") {
        if (isset($_POST["inuserpass"])) {
            if (isset($_POST["inuseremail"])) {
                echo json_encode(DBoperations::SignIn($_POST["inuserpass"],
                        $_POST["inuseremail"]));
            } else {
                echo json_encode(DBoperations::SignIn($_POST["inuserpass"]));
            }
        }
    } elseif ($_SESSION['login'] && $_POST["destination"] != "signin") {
        switch ($_POST["destination"]) {
            case "logScreenshots":
                if (isset($_POST["logid"])) {
                    echo json_encode(DBoperations::getLogsScreenshot($_POST["logid"]));
                }
                break;
            case "logsnextlist":
                if (isset($_POST["selectfrom"]) && isset($_POST["selectamount"])) {
                    echo json_encode(DBoperations::getLogsList($_POST["selectfrom"], 
                            $_POST["selectamount"]));
                }
                break;
            default:
                break;
        }
    }
}
