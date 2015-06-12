<?php
/**
 * Description of DPoperations
 *
 * @author Gheith
 */
class DBoperations {
   
        
     
     public static function SignIn($userpass, $useremail = "ghak@gmail.com") {
        $data = array("status" => "false", "message" => "");
        try {

            $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . "", DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare('SELECT count(*) as find FROM admin WHERE admin_email = :useremail');
            $stmt->bindParam(':useremail', $useremail, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $find;
            foreach ($result as $row) {
                $find = ($row['find'] == 0) ? false : true;
            }

            
            if ($find == FALSE) {
                
                $data["message"] = "email not found on the database";
                 $dbh = null;
                return $data;
            } else {
                $stmt = $dbh->prepare("SELECT admin_password FROM admin WHERE admin_email = :useremail");
                $stmt->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                $stmt->execute();
                $pass = $stmt->fetch(PDO::FETCH_ASSOC);
                if (decrypt_pass($userpass, $pass['admin_password'])) {
                    $query = 'SELECT
                                admin.admin_id,
                                admin.admin_name,
                                admin.create_date
                            FROM admin
                            WHERE admin.admin_email = :useremail ';
                    $stmt = $dbh->prepare($query);
                    $stmt->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);




                    $_SESSION['login-admin-name'] = $row['admin_name'];
                    $_SESSION['login-admin-id'] = $row['admin_id'];
                    $_SESSION['login-admin-email'] = $useremail;
                    $_SESSION['login'] = true;

                    $data["message"] = "some message";
                    $data["status"] = "true";
                    
                    //inserted repor
                    
                } else {
                    //if the password is wrong
                    $data["message"] = "password is wrong";
                }

               
                $dbh = null;
                return $data;
            }
        } catch (PDOException $e) {
            $data["message"] = $e->getMessage();
            $data["status"] = "false";
            return $data;
        }
    }
    
    
    public static function getLogsList($selectfrom = 0, $selectamount = 25) {
        $response = array("status" => "false", "data" => "");
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . "", DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare('SELECT
                                    log.log_id,
                                    log.log_title,
                                    log.description,
                                    DATE(log.log_create_date) AS createdate,
                                    log_type.log_type_title,
                                    log.log_creator_name,
                                    admin.admin_name
                                  FROM log
                                    CROSS JOIN admin
                                    INNER JOIN log_type
                                      ON log.log_type = log_type.log_type_id
                                  ORDER BY log.log_create_date desc
                                  LIMIT ' . intval($selectfrom) . ' , ' . intval($selectamount) . '');
            $stmt->execute();
            $result = $stmt->fetchAll();
            $response = array("status" => "false", "data" => "");
            $serialnumber = $selectfrom + 1;
            $log = array(
                "id" => "",
                "title" => "",
                "serialnumber" => "",
                "desc" => "",
                "createdate" => "",
                "type" => "",
                "creatorname" => "",
                "adminname" => ""
            );
            $data = array();
            foreach ($result as $row) {
                $log['id'] = $row['log_id'];
                $log['title'] = $row['log_title'];
                $log['serialnumber'] = $serialnumber;
                $serialnumber++;
                $log['desc'] = str_replace("'", "\'", $row['description']); 
                $log['createdate'] = $row['createdate'];
                $log['type'] = $row['log_type_title'];
                $log['creatorname'] = $row['log_creator_name'];
                $log['adminname'] = $row['admin_name'];
                array_push($data, $log);
            }
            $response['data'] = $data;
            $response["status"] = "true";
        } catch (PDOException $e) {
            $response["data"] = $e->getMessage();
            $response["status"] = "false";
            echo $e->getMessage();
        }
        $dbh = null;
        return $response;
    }
     public static function getLogsCount() {
        try {

            $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . "", DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $sql = 'SELECT count(*) as count FROM log WHERE 1';
            $count;
            foreach ($dbh->query($sql) as $row) {
                $count = $row['count'];
            }
            return $count;
            $dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
      public static function getLogsScreenshot($logid) {
        $logscreenshot = array();
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . "", DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare('SELECT
                                    log_screenshot.log_screenshot_id,
                                    log_screenshot.log_screenshot_path,
                                    log_screenshot.log_screenshot_name
                                  FROM log_screenshot
                                  WHERE log_screenshot.log_id = :logid');
            $stmt->bindParam(":logid", $logid, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                array_push($logscreenshot, $row);
            }
        } catch (PDOException $e) {
            //
        }
        $dbh = null;
        return $logscreenshot;
    }
    
    
       public static function getLogDescription($logid) {
           $data = array("desc" => "");
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . "", DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare('SELECT
                        log.description
                      FROM log
                      WHERE log.log_id = :logid');
            $stmt->bindParam(":logid", $logid, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data["desc"] = $result[0]["description"];
        } catch (PDOException $e) {
            //
        }
        $dbh = null;
        return $data;
    }
    
     public static function getLogsTypes() {
        try {

            $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . "", DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $sql = "SELECT log_type_id, log_type_title FROM log_type WHERE 1";
            $getLogsTypes = array();
            foreach ($dbh->query($sql) as $row) {
                $id = $row['log_type_id'];
                $type = $row['log_type_title'];
                $getLogsTypes[$id] = $type;
            }
            $dbh = null;
            return $getLogsTypes;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
     public static function newLog($solveby, $adminid, $logtitle, $description, $log_type, $images) {

        $data = array("status" => "false", "message" => "");

        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . "", DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = 'INSERT INTO log (log_id, 
                            log_creator_admin, 
                            log_type, 
                            log_title, 
                            description, 
                            log_creator_name)
                            VALUES (NULL,
                            :admincreatorid,
                            :logtype,
                            :logtitle,
                            :description,
                            :creatorname)';
            $stmt = $dbh->prepare($query) or die(mysql_error());
            $stmt->bindParam(':admincreatorid', $adminid, PDO::PARAM_INT);
            $stmt->bindParam(':logtype', $log_type, PDO::PARAM_INT);
            $stmt->bindParam(':logtitle', $logtitle, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':creatorname', $solveby, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $data["status"] = "true";
                $idofinsertedlog = $dbh->lastInsertId();
                $placeimage = DBoperations::uploadItemImages($images);
                if (count($placeimage["success"]) > 0) {
                    $stmt = $dbh->prepare('INSERT INTO log_screenshot
                        (log_screenshot_id, log_id, log_screenshot_name, log_screenshot_path) 
                      VALUES(:id, :logid, :name, :path)');
                    foreach ($placeimage["success"] as $imagename) {
                        $stmt->bindValue(':id', 'NULL');
                        $stmt->bindValue(':logid', $idofinsertedlog);
                        $stmt->bindValue(':name', $imagename);
                        $stmt->bindValue(':path', '../logsscreenshots/');
                        $stmt->execute();
                    }
                }
            } else {
                $data["message"] = $stmt->errorInfo();
                $data["status"] = "false";
            }
        } catch (Exception $e) {
            $data["message"] = $e->getMessage();
            $data["status"] = "false";
        }
        $dbh = null;
        echo json_encode($data);
    }

    
     public static function uploadItemImages($images) {
        $response = array("success" => array(), "field" => array());
        $success_upload_image_url = array();
        $field_upload_image_url = array();
        $j = 0;     // Variable for indexing uploaded image.
        // Declaring Path for uploaded images.
        for ($i = 0; $i < count($images['name']); $i++) {
            // Loop to get individual element from the array
            $validextensions = array("jpeg", "jpg", "JPG", "png", "PNG");      // Extensions which are allowed.
            $ext = explode('.', basename($images['name'][$i]));   // Explode file name from dot(.)
            $file_extension = end($ext); // Store extensions in the variable.
            $imagename = "";
            $imagename = md5(uniqid()) . "." . $ext[count($ext) - 1];
            $target_path = "../logsscreenshots/";
            $target_path = $target_path . $imagename;     // Set the target path with a new name of image.
            $j = $j + 1;      // Increment the number of uploaded images according to the files in array.
            if (($images["size"][$i] < 2000001)     // 2MB files can be uploaded.
                    && in_array($file_extension, $validextensions)) {
                if (move_uploaded_file($images['tmp_name'][$i], $target_path)) {
                    // If file moved to uploads folder.
                    $success_upload_image_url[$i] = $imagename;
                } else {     //  If File Was Not Moved.
                    $field_upload_image_url[$i] = $images['name'][$i];
                }
            } else {     //   If File Size And File Type Was Incorrect.
                $field_upload_image_url[$i] = $images['name'][$i] . " | Image Size Or File Type Was Incorrect";
            }
        }
        $response["success"] = $success_upload_image_url;
        $response["field"] = $field_upload_image_url;
        return $response;
    }
}
