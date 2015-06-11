<!DOCTYPE html>
<html>
    <head>
        <?php
        require_once '../includefile/header.php';
        require_once '../server/config.php';
        require_once '../server/DBoperations.php';
        ?>
        <style>
            img{
                max-width: 95%;
            }
        </style>
    </head>
    <body>
        <?php
        // put your code here
        ?>

        <?php
        include_once '../includefile/navbar.php';
        ?>

        <div class="main-container-logs">
            <?php
            include_once '../pagescontrl/logstable.php';
            ?>
        </div>

        <?php
        require_once '../models/descptionmodal.html';
        require_once '../models/logscreenshotsmodal.html';
        require_once '../includefile/footer.php';
        ?>
        <script src="../js/jquery.tmpl.min.js" type="text/javascript"></script>
        <script src="../js/jquery.tmplPlus.min.js" type="text/javascript"></script>
        <script src="../js/logs.js" type="text/javascript"></script>
        
        
        <script id="LogsListTemplate" type="text/x-jquery-tmpl">
        
        </script>
    </body>
</html>
