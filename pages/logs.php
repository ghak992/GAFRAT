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
            img{
                max-width: 95%;
            }
        </style>
    </head>
    <body>
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
            <tr>
                            <td>${serialnumber}</td>
                            <td>${type}</td>
                            <td>${title}</td>
                            <td>${creatorname}</td>
                            <td>${createdate}</td>
                            <td>
                                <span 
                                    onclick="LogsListOperations.setLogDescription('${id}')"
                                    data-toggle="modal" data-target="#desc_modal"   
                                    class="btn btn-default btn-sm btn-block">
                                    <i class="fa fa-file-text"></i>
                                </span>
                            </td>
                            <td><span
                                    onclick="LogsListOperations.setLogScreenshots('${id}')"
                                    data-toggle="modal" data-target="#logscreenshots_modal"
                                    class="btn btn-default btn-sm btn-block">
                                    <i class="fa fa-image"></i>
                                </span>
                            </td>
                        </tr>
        </script>
    </body>
</html>
