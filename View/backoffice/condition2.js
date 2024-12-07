document.getElementById("societeForm").addEventListener("submit", function(event) {
    let isValid = true;
    
    // Récupération des éléments DOM
    const nom = document.getElementById("nom_soc");
    const adresse = document.getElementById("adresse");
    const numero = document.getElementById("numero");
    const email = document.getElementById("email");
    const speciality = document.getElementById("speciality");

    // Validation du nom
    if (nom.value.length < 2) {
        document.getElementById("nom_soc_message").innerHTML = "Le nom doit contenir au moins 2 caractères.";
        nom.classList.add("is-invalid");
        isValid = false;
    } else {
        nom.classList.remove("is-invalid");
        nom.classList.add("is-valid");
        document.getElementById("nom_soc_message").innerHTML = "Correct";
    }

    // Validation de l'adresse
    if (adresse.value.length < 2) {
        document.getElementById("adresse_message").innerHTML = "L'adresse doit contenir au moins 2 caractères.";
        adresse.classList.add("is-invalid");
        isValid = false;
    } else {
        adresse.classList.remove("is-invalid");
        adresse.classList.add("is-valid");
        document.getElementById("adresse_message").innerHTML = "Correct";
    }

    // Validation du numéro de téléphone
    const numeroPattern = /^\d{8}$/;
    if (!numeroPattern.test(numero.value)) {
        document.getElementById("numero_message").innerHTML = "Le numéro doit contenir 8 chiffres.";
        numero.classList.add("is-invalid");
        isValid = false;
    } else {
        numero.classList.remove("is-invalid");
        numero.classList.add("is-valid");
        document.getElementById("numero_message").innerHTML = "Correct";
    }

    // Validation de l'email
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email.value)) {
        document.getElementById("email_message").innerHTML = "L'email doit être dans un format valide.";
        email.classList.add("is-invalid");
        isValid = false;
    } else {
        email.classList.remove("is-invalid");
        email.classList.add("is-valid");
        document.getElementById("email_message").innerHTML = "Correct";
    }

    // Validation des spécialités
    if (speciality.selectedOptions.length === 0) {
        document.getElementById("speciality_message").innerHTML = "Il faut choisir une spécialité.";
        speciality.classList.add("is-invalid");
        isValid = false;
    } else {
        speciality.classList.remove("is-invalid");
        speciality.classList.add("is-valid");
        document.getElementById("speciality_message").innerHTML = "Correct";
    }

    // Si une validation échoue, empêcher la soumission du formulaire
    if (!isValid) {
        event.preventDefault();
    }
});