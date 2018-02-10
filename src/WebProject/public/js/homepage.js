$(window).keydown(function(event){
    if(event.keyCode == 13) {
        event.preventDefault();
        return false;
    }
});

$("#project_div > input").on("keyup", function (e) {
    if (e.which === 13) {
        $("#project_div").hide();
        $("#password_div").show();
    }
});

$("#password_div > input").on("keyup", function (e) {
    if (e.which === 13) {
        $("form > input[type='submit']").click();
    }
});