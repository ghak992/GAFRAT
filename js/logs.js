$(document).ready(function () {
    $('.filterable .btn-filter').click(function () {
        var $panel = $(this).parents('.filterable'),
                $filters = $panel.find('.filters input'),
                $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function (e) {
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9')
            return;
        /* Useful DOM data and selectors */
        var $input = $(this),
                inputContent = $input.val().toLowerCase(),
                $panel = $input.parents('.filterable'),
                column = $panel.find('.filters th').index($input.parents('th')),
                $table = $panel.find('.table'),
                $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function () {
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="' + $table.find('.filters th').length + '">No result found</td></tr>'));
        }
    });

    LogsListOperations = {
        setLogScreenshots: function (logid) {
            var Data = {
                'destination': 'logScreenshots',
                'logid': logid
            };
            $.ajax({
                type: 'POST',
                url: mainrequesturl,
                data: Data,
                dataType: 'json',
                encode: true,
                timeout: 10000, //10 second timeout, 
                beforeSend: function (xhr) {
                    $("#logscreenshots_modal_image").html('<i class="fa fa-spinner fa-pulse fa-5x"></i>');
                },
                complete: function (jqXHR, textStatus) {

                },
                success: function (data, textStatus, jqXHR) {
                    var count = Object.keys(data).length;
                    if (count > 0) {
                        var html = "";
                        $.each(data, function (id, Screenshots) {
                            html = html +
                                    '<img src="'
                                    + Screenshots.log_screenshot_path +
                                    Screenshots.log_screenshot_name +
                                    '"/><br><br>';
                        });
                        $("#logscreenshots_modal_image").html(html);
                    } else {
                        $("#logscreenshots_modal_image").html("<h3>there no screenshot for this log</h3>");
                    }

                }, error: function (jqXHR, textStatus, errorThrown) {
                    if (textStatus === "timeout") {
                        $("#logscreenshots_modal_image").html("<h3>time is out</h3>");
                    } else {
                        $("#logscreenshots_modal_image").html("<h3>unexpected error please try again</h3>");
                    }
                }
            });
        },
        setLogDescription: function (logid) {
            var Data = {
                'destination': 'logDescription',
                'logid': logid
            };
            $.ajax({
                type: 'POST',
                url: mainrequesturl,
                data: Data,
                dataType: 'json',
                encode: true,
                timeout: 10000, //10 second timeout, 
                beforeSend: function (xhr) {
                    $("#desc_modal_desc_text").html('<i class="fa fa-spinner fa-pulse fa-5x"></i>');
                },
                complete: function (jqXHR, textStatus) {
                    
                },
                success: function (data, textStatus, jqXHR) {
                    $("#desc_modal_desc_text").html("<h4>"+data.desc+"</h4>");
                }, error: function (jqXHR, textStatus, errorThrown) {
                    if (textStatus === "timeout") {
                        $("#desc_modal_desc_text").html("<h3>time is out</h3>");
                    } else {
                        $("#desc_modal_desc_text").html("<h3>unexpected error please try again</h3>");
                    }
                }
            });
        },
        nextLogsList: function (selectfrom, selectamount) {
            Data = {
                'destination': 'logsnextlist',
                'selectfrom': selectfrom,
                'selectamount': selectamount
            };
            $.ajax({
                type: 'POST',
                url: mainrequesturl,
                data: Data,
                dataType: 'json',
                encode: true,
                timeout: 10000, //10 second timeout, 
                beforeSend: function (xhr) {
                    $("#logstable-message").html('<center><i class="fa fa-spinner fa-pulse fa-3x"></i></center>');
                },
                complete: function (jqXHR, textStatus) {
                    $("#logstable-message").html('');
                },
                success: function (data, textStatus, jqXHR) {
                    if (data.status == "true") {
                        if (data.data.length === 0) {
                            $(".load-more").hide();
                        } else {
                            $(".list-nav").css("background", "#ffffff");
                            $(".list-nav").css("color", "#000");
                            $("#list-nav-button" + selectfrom).css("background", "#080808");
                            $("#list-nav-button" + selectfrom).css("color", "#ffffff");
                            $("#logstable-tbody").html("");
                            $("#LogsListTemplate").tmpl(data.data).appendTo("#logstable-tbody");
                        }

                    } else if (data.status === "false") {
                        alert("error")
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (textStatus === "timeout") {
                        $("#logstable-message").html("<h5>time is out</h5>");
                    } else {
                        $("#logstable-message").html("<h5>unexpected error please try again</h5>");
                    }
                }
            });

        }
    };

});





