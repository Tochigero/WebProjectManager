$("#project_minimal_name").on("keypress", function (e) {
    if (e.which === 13) {
        $("#project_div").hide();
        $("#password_div").show();
    }
});

$("#project_minimal_password").on("keypress", function (e) {
    if (e.which === 13) {
        $("form").submit();
    }
});