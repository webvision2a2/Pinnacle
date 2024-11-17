const nom = document.getElementById("nom_soc")
const adresse = document.getElementById("adresse")
const numero = document.getElementById("numero")
const email = document.getElementById("email")
const checkboxes = document.querySelectorAll("input[type=checkbox][name=speciality]")

function initialisation(x,y)
{
    document.getElementById(x).innerHTML=""
    document.getElementById(y).innerHTML=""
}
function message (x,message)
{
    document.getElementById(x).innerHTML=message
}
function nom_message ()
{
    initialisation("1","2");
    if ((0 < nom.value.length)  && (nom.value.length< 2) || (nom.value.length===0))
        message ("1","Le nom doit contenir au moins 2 caractères.")
    if ((2 <= nom.value.length))
        message ("2","Correct.")
}
function adresse_message ()
{
    initialisation("3","4");
    if ((0 < adresse.value.length)  && (adresse.value.length< 2) || (adresse.value.length===0))
        message ("3","L'adresse doit contenir au moins 2 caractères.")
    if ((2 <= adresse.value.length))
        message ("4","Correct.")
}
function numero_message() {
    initialisation("5", "6")
    const numeroPattern = /^\d{8}$/  // Vérifie que le numéro contient exactement 8 chiffres
    if (!numeroPattern.test(numero.value)) {
        message("5", "Le numéro doit contenir 8 chiffres.")
    } else {
        message("6", "Correct.")
    }
}

function email_message ()
{
    initialisation("7","8");
    if ((0 < email.value.length)  && (email.value.length< 5) || (email.value.length===0))
        message ("7","L'email doit contenir au moins 5 caractères et de la forme : (exemple@exemple.exmple).")
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
    if ((email.value.length>=5) && (emailPattern.test(email.value))===false)
        { 
            message("7", "L'email doit être dans un format valide ( exemple@exemple.exmple ).")
        }
    if (emailPattern.test(email.value)) { 
        message("8", "Correct.")
    } 
    
}
function checkbox_message() {
    initialisation("9", "10")
    let checked = false;
    checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            checked = true;
        }
    })
    if (!checked) {
        message("9", "Il faut choisir au moins une spécialité.")
    } else {
        message("10", "Correct.")
    }
}
button.onclick=function(event){
    event.preventDefault()
    nom_message ()
    adresse_message ()
    numero_message ()
    email_message ()
    checkbox_message()
}