$(function () {
    const signUpButton = $("#signUp");
    const signInButton = $("#signIn");
    const container = $("#container");

    $(signUpButton).click(function () {
        container.addClass("right-panel-active");
    });

    $(signInButton).click(function () {
        container.removeClass("right-panel-active");
    });
});
