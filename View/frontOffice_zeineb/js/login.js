document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();
    var valid = true;

    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var pEmail = document.getElementById("p_email");
    var pPassword = document.getElementById("p_password");
    var pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    // Clear previous messages
    pEmail.innerHTML = "";
    pPassword.innerHTML = "";

    // Validate email
    if (!email) {
        pEmail.innerHTML = "L'email est obligatoire.";
        pEmail.style.color = "#EB6C4C";
        valid = false;
    } else if (!pattern.test(email)) {
        pEmail.innerHTML = "L'email doit être valide.";
        pEmail.style.color = "#EB6C4C";
        valid = false;
    }

    // Validate password
    if (!password) {
        pPassword.innerHTML = "Le mot de passe est obligatoire.";
        pPassword.style.color = "#EB6C4C";
        valid = false;
    } else if (password.length < 6) { // Use 6 for clarity
        pPassword.innerHTML = "Le mot de passe doit contenir au moins 6 caractères.";
        pPassword.style.color = "#EB6C4C";
        valid = false;
    }

    // Submit form if valid
    if (valid) {
        this.submit();
    }
});
