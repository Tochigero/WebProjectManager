$(window).keydown(function(event){
    if(event.keyCode == 13) {
        event.preventDefault();
        return false;
    }
});

$("#forget_div > input").on("keyup", function (e) {
    var val = $("input[name='forget_password[name]']").val();

    if (e.which === 13 && val !== "") {
        $.post("/forget/token", {'project_name' : val}, function (data) {
            if (data === "true") {
                $("#forget_div").hide();
                $("#key_div").show();
            } else {
                // TODO Error
                console.log("error");
            }
        });
    }
});

$("#key_div > input").on("keyup", function (e) {
    var val = $("input[name='forget_password[key]']").val();
    var url = "/forget/check/" + val;

    $.post(url, function (data) {
        if (data !== "false") {
            $(".submit_div").removeClass("red_button");

            if (e.which === 13) {
                $("#key_div").hide();
                $("#password_div").show();
            }
            $("input[name='forget_password[token]']").val(data);
        } else {
            if ($(".submit_div").hasClass("red_button") === false) {
                $(".submit_div").addClass("red_button");
            }
        }
    });
});

$("#password_div > input").on("keyup", function (e) {
    if (e.which === 13) {
        $("form > input[type='submit']").click();
    }
});