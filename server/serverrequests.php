<?php

header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');
session_start();

if (isset($_POST["destination"])) {
    require_once 'config.php';
    require_once 'DBoperations.php';


    if ($_POST["destination"] == "signin" && isset($_POST["inuserpass"])) {
        require_once 'cryptpass.php';
        if (isset($_POST["inusername"])) {
            echo json_encode(
                    DPoperations::SignIn($_POST["inuserpass"], $_POST["inusername"])
            );
        } else {
            echo json_encode(
                    DPoperations::SignIn($_POST["inuserpass"])
            );
        }
    } else {
        if ($_SESSION['login']) {
            switch ($_POST["destination"]) {
                case "logScreenshots":
                    if (isset($_POST["logid"])) {
                        echo json_encode(DBoperations::getLogsScreenshot($_POST["logid"]));
                    }
                    break;

                default:
                    break;
            }
        }
    }
}

 

//

//
//if (isset($_POST["destination"])) {
//    
//    require_once 'config.php';
//    require_once 'DPoperations.php';
//    
//    
//    if($_POST["destination"] == "signin"){
//        //sign in request
//        if(isset($_POST["inuserpass"])){
//           require_once 'cryptpass.php';
//           if(isset($_POST["inusername"])){
//               echo json_encode(
//                       DPoperations::SignIn($_POST["inuserpass"], 
//                               $_POST["inusername"])
//                       );
//           }
//           else {
//               echo json_encode(
//                       DPoperations::SignIn($_POST["inuserpass"])
//                       );
//           }
//       }
//    }  
//    
//    
//    else {
//        
//    }
//    
//    
//}
//
