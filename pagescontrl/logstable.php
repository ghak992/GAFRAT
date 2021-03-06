<div class="container">
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-warning"></i>
                    &nbsp;Logs</h3>
                <div class="pull-right">
                    <button class="btn btn-primary btn-xs btn-filter">
                        <span class="fa fa-filter"></span>
                        Filter</button>
                </div>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="filters">
                        <th></th>
                        <th><input type="text" class="form-control" placeholder="Type" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Title" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Solve By" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Add Date" disabled hidden></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="logstable-tbody">

                    <?php
                    $selectamount = 12;
                    $logslist = DBoperations::getLogsList(0, $selectamount);
                    $num = 1;
                    foreach ($logslist["data"] as $log) {
                        ?>
                        <tr>
                            <td><?php echo $num;$num++;?></td>
                            <td><?php echo $log["type"] ?></td>
                            <td><?php echo $log["title"] ?></td>
                            <td><?php echo $log["creatorname"] ?></td>
                            <td><?php echo $log["createdate"] ?></td>
                            <td>
                                <span 
                                    onclick="LogsListOperations.setLogDescription('<?PHP echo $log["id"]; ?>')"
                                    data-toggle="modal" data-target="#desc_modal"   
                                    class="btn btn-default btn-sm btn-block">
                                    <i class="fa fa-file-text"></i>
                                </span>
                            </td>
                            <td><span
                                    onclick="LogsListOperations.setLogScreenshots('<?PHP echo $log["id"]; ?>')"
                                    data-toggle="modal" data-target="#logscreenshots_modal"
                                    class="btn btn-default btn-sm btn-block">
                                    <i class="fa fa-image"></i>
                                </span>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
<!--                    <tr>
                        <td>1</td>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td><span class="btn btn-default btn-sm btn-block">
                                <i class="fa fa-file-text"></i>
                            </span>
                        </td>
                        <td><span class="btn btn-default btn-sm btn-block">
                                <i class="fa fa-image"></i>
                            </span>
                        </td>
                    </tr>-->
                </tbody>
            </table>
            <div class="panel-footer">
                <center>
                    <nav>
                        <ul class="pagination">
                            <?php
                            $logscount = DBoperations::getLogsCount();
                            $pages = intval($logscount) / $selectamount;
                            if (is_float($pages)) {
                                $pages = intval($pages + 1);
                            }
                            $selectfrom = 0;
                            $selectto = $selectamount;
                            $roundnum = 1;
                            for ($index = 0; $index < $pages; $index++) {
                                ?>
                            <li >
                                    <span 
                                        style="<?php echo ($selectfrom == 0)?  'background: #080808; color: #ffffff' :  ''; ?>"
                                        id="list-nav-button<?php echo $selectfrom; ?>"
                                        onclick="LogsListOperations.nextLogsList('<?php echo $selectfrom; ?>', '<?php echo $selectamount ?>')"
                                        class="btn list-nav" style="border-radius: 0px;">
                                        <?php echo $index + 1; ?>
                                    </span>
                                </li>
                                <?php
                                $roundnum++;
                                $selectfrom = $selectto;
                                $selectto = $selectamount * $roundnum;
                            }
                            ?>
                        </ul>
                    </nav>
                </center>
                <div id="logstable-message">
                    
                </div>
            </div>
        </div>
    </div>
</div>