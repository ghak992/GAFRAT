$(document).ready(function () {
    $("#main-signin-form").submit(function (event) {
        event.preventDefault();
        var Data = {
            'destination': 'signin',
            'inuserpass': $('#main-signin-form #inpass').val()
        };
        $.ajax({
            type: 'POST',
            url: mainrequesturl,
            data: Data,
            dataType: 'json',
            encode: true,
            timeout: 10000, //10 second timeout, 
            beforeSend: function (xhr) {
                $("#main-signin-form input, button").prop("disabled", true);
            },
            complete: function (jqXHR, textStatus) {
                $("#main-signin-form input, button").prop("disabled", false);
            },
            success: function (data, textStatus, jqXHR) {
                if (data.status == "false") {
                    $("#main-signin-form-message").text(data.message);
                } else {
                    window.location.assign(mainurl+"/pages/logs.php");
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus)
                if (textStatus === "timeout") {
                    $("#main-signin-form-message").text("time is out");
                } else {
                    $("#main-signin-form-message").text("unexpected error please try again");
                }
            }
        });
    });
});


