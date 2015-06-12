<!DOCTYPE html>
<html>
    <head>
        <?php
        include  '../server/auth.php';
        require_once '../includefile/header.php';
        require_once '../server/config.php';
        require_once '../server/DBoperations.php';
        ?>
        <style>
            body{
                overflow-x: hidden;
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
            include_once '../pagescontrl/passgenerator.php';
            ?>
        </div>

        
        <?php
        include_once '../includefile/footer.php';
        ?>
    </body>
</html>
