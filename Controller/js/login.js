document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();
    var valid = true;

    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var pEmail = document.getElementById("p_email");
    var pPassword = document.getElementById("p_password");
    var pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!email) {
        pEmail.innerHTML = "L'email est obligatoire.";
        pEmail.style.color = "#EB6C4C";
        valid = false;
    } else if (!pattern.test(email)) {
        pEmail.innerHTML = "L'email doit être valide.";
        pEmail.style.color = "#EB6C4C";
        valid = false;
    } else {
        pEmail.innerHTML = "Correct";
        pEmail.style.color = "green";
    }

    
    if (!password) {
        pPassword.innerHTML = "Le mot de passe est obligatoire.";
        pPassword.style.color = "#EB6C4C";
        valid = false;
    } else if (password.length < 8) {
        pPassword.innerHTML = "Le mot de passe doit contenir au moins 6 caractères.";
        pPassword.style.color = "#EB6C4C";
        valid = false;
    } else {
        pPassword.innerHTML = "Correct";
        pPassword.style.color = "green";
    }

    if (valid) {
        alert("Connexion validée!");
    }
});