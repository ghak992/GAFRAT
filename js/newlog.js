
$(document).ready(function () {

    // to solve the trim problem in IE <= 8
    if (typeof String.prototype.trim !== 'function') {
        String.prototype.trim = function () {
            return this.replace(/^\s+|\s+$/g, '');
        }
    }
    ;

    //  To add new input file field dynamically,
    //   on click of "Add More Files" button below
    //    function will be executed.
    $('#add_more').click(function () {
        $(this).before($("<div/>", {
            id: 'filediv'
        }).fadeIn('slow').append($("<input/>", {
            name: 'file[]',
            type: 'file',
            id: 'new-log-screenshot',
            class: 'form-control'
        }), $("<br/><br/>")));
    });


//add new log
    $("#new-log-form").submit(function (event) {
        event.preventDefault();

        if ($("#new-log-form-type").val() === "1000") {
            $("#new-log-form-type").focus();
            return false;
        }

        $.ajax({
            type: 'POST',
            url: mainrequesturl,
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                return myXhr;
            },
            beforeSend: function (xhr) {
                $("#new-log-form-message").html('<i class="fa fa-spinner fa-pulse fa-2x"></i>');
                $("#new-log-form :input").prop("disabled", true);
            }, complete: function (jqXHR, textStatus) {
                $("#new-log-form :input").prop("disabled", false);
            },
            success: function (data, textStatus, jqXHR) {
                
                if (data.status == "true") {
                    $('#new-log-form-message').html("<h5>log is inserted</h5>");
                    document.getElementById("form-add-new-places").reset();
                } else if (data.status == "false") {
                    $('#new-log-form-message').html("<h5>" + data.message + "<h5>");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus)
                if (textStatus === "timeout") {
                    $("#new-log-form-message").html("<h5>time is out</h5>");
                } else {
                    $("#new-log-form-message").html("<h5>unexpected error please try again</h5>");
                }
            }

        });
    });
});






