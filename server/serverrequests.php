<?php

header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');


if (isset($_POST["destination"])) {

    require_once 'config.php';
    require_once 'DBoperations.php';
    require_once 'cryptpass.php';

    session_start();

    if ($_POST["destination"] == "signin") {
        if (isset($_POST["inuserpass"]) && isset($_POST["inuseremail"])) {
            echo json_encode(DBoperations::SignIn($_POST["inuserpass"], $_POST["inuseremail"]));
        }
    } elseif ($_SESSION['login'] && $_POST["destination"] != "signin") {
        switch ($_POST["destination"]) {
            case "logScreenshots":
                if (isset($_POST["logid"])) {
                    echo json_encode(DBoperations::getLogsScreenshot($_POST["logid"]));
                }
                break;
            case "logDescription":
                if (isset($_POST["logid"])) {
                    echo json_encode(DBoperations::getLogDescription($_POST["logid"]));
                }
                break;
            case "logsnextlist":
                if (isset($_POST["selectfrom"]) && isset($_POST["selectamount"])) {
                    echo json_encode(DBoperations::getLogsList($_POST["selectfrom"], $_POST["selectamount"]));
                }
                break;
            case "newlog":
                if (isset($_POST["new-log-form-type"]) &&
                        isset($_POST["new-log-form-title"]) &&
                        isset($_POST["new-log-form-solve-by"]) &&
                        isset($_POST["new-log-form-desc"]) &&
                        isset($_FILES["file"])
                ) {
                    DBoperations::newLog($_POST["new-log-form-solve-by"], $_SESSION['login-admin-id'], $_POST["new-log-form-title"], $_POST["new-log-form-desc"], $_POST["new-log-form-type"], $_FILES["file"]);
                }
                break;
            default:
                break;
        }
    }
}