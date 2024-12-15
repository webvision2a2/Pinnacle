document.getElementById("UpdateForm").addEventListener("submit", function (e) {
    let errors = false;

    document.querySelectorAll(".error").forEach(el => el.innerText = "");

    const domaine = document.getElementById("domaine").value.trim();
    if (!domaine) {
        document.getElementById("domaine_err").innerText = "Le domaine est requis.";
        errors = true;
    }

    const occupation = document.getElementById("occupation").value.trim();
    if (!occupation) {
        document.getElementById("occupation_err").innerText = "L'occupation est requise.";
        errors = true;
    }

    const photo = document.getElementById("photo_profil").value.trim();
    if (!photo) {
        document.getElementById("photo_err").innerText = "Veuillez télécharger une photo de profil.";
        errors = true;
    }

    const age = document.getElementById("age").value.trim();
    if (!age || isNaN(age) || age < 1 || age > 120) {
        document.getElementById("age_err").innerText = "Veuillez entrer un âge valide.";
        errors = true;
    }

    const telephone = document.getElementById("telephone").value.trim();
    if (!telephone || !/^[0-9]{8}$/.test(telephone)) {
        document.getElementById("telephone_err").innerText = "Le numéro de téléphone doit être composé de 8 chiffres.";
        errors = true;
    }

    if (errors) {
        e.preventDefault();
    }
});
