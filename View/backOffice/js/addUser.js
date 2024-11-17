document.getElementById("signupForm").addEventListener("submit", function (e) {
    e.preventDefault();

    var nom = document.getElementById("nom").value;
    var pnom = document.getElementById("p_nom");

    var prenom = document.getElementById("prenom").value;
    var pprenom = document.getElementById("p_prenom");

    var email = document.getElementById("email").value;
    var pEmail = document.getElementById("p_email");
    var pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    var password = document.getElementById("password").value;
    var pPassword = document.getElementById("p_password");

    var confirmPassword = document.getElementById("confirm_password").value;
    var pConfirmPassword = document.getElementById("p_confirmpassword");

    let isValid = true;

    if (!nom) {
        pnom.innerHTML = "Le nom d'utilisateur est obligatoire.";
        pnom.style.color = "#EB6C4C";
        isValid = false;
    } else if (nom.length < 2) {
        pnom.innerHTML = "Le nom d'utilisateur doit contenir au moins 3 caractères.";
        pnom.style.color = "#EB6C4C";
        isValid = false;
    }

    if (!prenom) {
        pprenom.innerHTML = "Le prénom d'utilisateur est obligatoire.";
        pprenom.style.color = "#EB6C4C";
        isValid = false;
    } else if (prenom.length < 3) {
        pprenom.innerHTML = "Le prénom d'utilisateur doit contenir au moins 3 caractères.";
        pprenom.style.color = "#EB6C4C";
        isValid = false;
    }

    if (!email) {
        pEmail.innerHTML = "L'email est obligatoire.";
        pEmail.style.color = "#EB6C4C";
        isValid = false;
    } else if (!pattern.test(email)) {
        pEmail.innerHTML = "Veuillez entrer un email valide.";
        pEmail.style.color = "#EB6C4C";
        isValid = false;
    }

    if (!password) {
        pPassword.innerHTML = "Le mot de passe est obligatoire.";
        pPassword.style.color = "#EB6C4C";
        isValid = false;
    } else if (password.length < 8) {
        pPassword.innerHTML = "Le mot de passe doit contenir au moins 8 caractères.";
        pPassword.style.color = "#EB6C4C";
        isValid = false;
    }

    if (!confirmPassword) {
        pConfirmPassword.innerHTML = "La confirmation du mot de passe est obligatoire.";
        pConfirmPassword.style.color = "#EB6C4C";
        isValid = false;
    } else if (confirmPassword !== password) {
        pConfirmPassword.innerHTML = "Les mots de passe ne correspondent pas.";
        pConfirmPassword.style.color = "#EB6C4C";
        isValid = false;
    }

    if (isValid) {
        e.target.submit(); 
    }
});
