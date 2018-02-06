$("#project_div > input").on("keypress", function (e) {
    if (e.which === 13) {
        $("#project_div").hide();
        $("#password_div").show();
    }
});

$("#password_div > input").on("keypress", function (e) {
    if (e.which === 13) {
        $("form > button[type='submit']").click();
    }
});