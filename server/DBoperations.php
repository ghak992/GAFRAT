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
                                    log.description,
                                    DATE(log.log_create_date) AS createdate,
                                    log_type.log_type_title,
                                    log.log_creator_name,
                                    admin.admin_name
                                  FROM log
                                    CROSS JOIN admin
                                    INNER JOIN log_type
                                      ON log.log_type = log_type.log_type_id
                                  ORDER BY log.log_create_date
                                  LIMIT ' . intval($selectfrom) . ' , ' . intval($selectamount) . '');
            $stmt->execute();
            $result = $stmt->fetchAll();
            $response = array("status" => "false", "data" => "");
            $log = array(
                "id" => "",
                "desc" => "",
                "createdate" => "",
                "type" => "",
                "creatorname" => "",
                "adminname" => ""
            );
            $data = array();
            foreach ($result as $row) {
                $log['id'] = $row['log_id'];
                $log['desc'] = $row['description'];
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
    
    
}
