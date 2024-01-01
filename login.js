const formLogin = document.getElementById("login-form");

formLogin.addEventListener("submit", function (event) {
    validateAndNavigate(event);
});

function validateAndNavigate(event) {
    const Email = document.getElementById("email");
    const Password = document.getElementById("password");

    if (Email.value.trim() === "") {
        event.preventDefault();
        Email.placeholder = "Pleaes Enter Your Email";
        const emailLabel     = document.getElementById("email-label");
        emailLabel.style.color = "red";

    }
    if (Password.value.trim() === "") {
        event.preventDefault();
        Password.placeholder = "Pleaes Enter Your Password";
        const passwordLabel = document.getElementById("password-label");
        passwordLabel.style.color = "red";
    }
}
