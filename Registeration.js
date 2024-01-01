const formRegister = document.getElementById("registeration-form");

formRegister.addEventListener("submit", function (event1) {
    validateAndNavigate(event1);
});

function validateAndNavigate(event1) {
    const Name = document.getElementById("name");
    const Email = document.getElementById("email");
    const Password = document.getElementById("password");
    const ConfirmPassword = document.getElementById("confirm-password");                     
    if (Name.value.trim() === "") {
        event1.preventDefault();
        Name.placeholder = "Please Enter Your Name";
        const nameLabel = document.getElementById("name-label");
        nameLabel.style.color = "red";
    }

    if (Email.value.trim() === "") {
        event1.preventDefault();
        Email.placeholder = "Please Enter Your Email";
        const emailLabel = document.getElementById("email-label");
        emailLabel.style.color = "red";
    }
    if (Password.value.trim() === "") {
        event1.preventDefault();
        Password.placeholder = "Please Enter Your Password";
        const passwordLabel = document.getElementById("password-label");
        passwordLabel.style.color = "red";
    }
    if (ConfirmPassword.value.trim() === "") {
        event1.preventDefault();
        ConfirmPassword.placeholder = "Please Confirm Your Password";
        const confirmPasswordLabel = document.getElementById("confirmpassword-label");
        confirmPasswordLabel.style.color = "red";
        return;
    }
    if (Password.value.trim() !== ConfirmPassword.value.trim()) {
        event1.preventDefault();
        Password.placeholder = "The Two Passwords Don't Matach";
        const passwordLabel = document.getElementById("password-label");
        passwordLabel.style.color = "red";
        ConfirmPassword.placeholder = "The Two Passwords Don't Match";
        const confirmPasswordLabel = document.getElementById("confirmpassword-label");
        confirmPasswordLabel.style.color = "red";
        return;
    }
}

