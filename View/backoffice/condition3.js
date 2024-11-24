document.getElementById("stageForm").addEventListener("submit", function(event) {
    let isValid = true;
    
    // Récupération des éléments DOM
    const type = document.getElementById("type");
    const typeOther = document.getElementById("type_other");
    const speciality = document.getElementById("speciality");
    const duration = document.getElementById("duration");
    const email = document.getElementById("email");
    const documents = document.getElementById("documents");

    // Validation du nom de l'entreprise
   
    // Validation du type de stage
    if (type.value === "autre" && typeOther.value.length < 2) {
        document.getElementById("type_message").innerHTML = "Veuillez préciser le type de stage.";
        typeOther.classList.add("is-invalid");
        isValid = false;
    } else {
        typeOther.classList.remove("is-invalid");
        typeOther.classList.add("is-valid");
        document.getElementById("type_message").innerHTML = "Correct";
    }

    // Validation des spécialités
    if (speciality.selectedOptions.length === 0) {
        document.getElementById("speciality_message").innerHTML = "Il faut choisir au moins une spécialité.";
        speciality.classList.add("is-invalid");
        isValid = false;
    } else {
        speciality.classList.remove("is-invalid");
        speciality.classList.add("is-valid");
        document.getElementById("speciality_message").innerHTML = "Correct";
    }

    // Validation de la durée du stage
    if (duration.value.length === 0) {
        document.getElementById("duration_message").innerHTML = "Veuillez indiquer la durée du stage.";
        duration.classList.add("is-invalid");
        isValid = false;
    } else {
        duration.classList.remove("is-invalid");
        duration.classList.add("is-valid");
        document.getElementById("duration_message").innerHTML = "Correct";
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

    // Validation des documents requis
    if (documents.value.length === 0) {
        document.getElementById("documents_message").innerHTML = "Veuillez indiquer les documents requis.";
        documents.classList.add("is-invalid");
        isValid = false;
    } else {
        documents.classList.remove("is-invalid");
        documents.classList.add("is-valid");
        document.getElementById("documents_message").innerHTML = "Correct";
    }

    // Si une validation échoue, empêcher la soumission du formulaire
    if (!isValid) {
        event.preventDefault();
    }
});
