<?php
include '../../config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkbox List with Descriptions</title>
    <link rel="stylesheet" href="css/evstyles.css">
    <form id="optionsForm" method="POST" action="save_options.php"></form>
    <body>
    <div class="container">
        <h1>Select Your Options</h1>
        <form id="optionsForm" action="../../controller/controllerevent.php?action=insertion" method="post">
            <div class="checkbox-item">
                <label class="custom-checkbox">
                    <input type="checkbox" id="option1" name="options[]" value="Coding">
                    <span class="checkmark"></span>
                    Coding
                    <a href="#" class="see-more" onclick="toggleDescription('desc1')">voir plus</a>   
                </label>
                <div class="description-box" id="desc1">La programmation consiste à écrire des instructions pour les ordinateurs en utilisant des langages de programmation. C'est la base du développement logiciel, permettant la création d'applications, de sites Web et de systèmes.</div>
            </div>
            <div class="checkbox-item">
                <label class="custom-checkbox">
                    <input type="checkbox" id="option2" name="options[]" value="Hackathon">
                    <span class="checkmark"></span>
                    Hackathon
                    <a href="#" class="see-more" onclick="toggleDescription('desc2')">voir plus</a>
                </label>
                <div class="description-box" id="desc2">Un hackathon est un événement collaboratif où des individus se réunissent pour résoudre des problèmes grâce à la programmation et à l'innovation dans un délai limité.</div>
            </div>
            <div class="checkbox-item">
                <label class="custom-checkbox">
                    <input type="checkbox" id="option3" name="options[]" value="Graphic Design">
                    <span class="checkmark"></span>
                    Graphic Design
                    <a href="#" class="see-more" onclick="toggleDescription('desc3')">voir plus</a>
                </label>
                <div class="description-box" id="desc3">Le design graphique est l'art de la communication visuelle à travers la typographie, les images, les couleurs et la mise en page. Les designers créent du contenu visuel pour divers médias.</div>
            </div>
            <div class="checkbox-item">
                <label class="custom-checkbox">
                    <input type="checkbox" id="option4" name="options[]" value="Game Development">
                    <span class="checkmark"></span>
                    Game Development
                    <a href="#" class="see-more" onclick="toggleDescription('desc4')">voir plus</a>
                </label>
                <div class="description-box" id='desc4'>Le développement de jeux englobe le processus de conception, de création et de publication de jeux sur diverses plateformes.</div>
            </div>
            <div class="checkbox-item">
                <label class="custom-checkbox">
                    <input type="checkbox" id="option5" name="options[]" value="Data Science">
                    <span class="checkmark"></span>
                    Data Science
                    <a href="#" class="see-more" onclick="toggleDescription('desc5')">voir plus</a>
                </label>
                <div class="description-box" id='desc5'>La science des données implique l'extraction d'informations à partir d'ensembles de données complexes en utilisant des techniques d'analyse statistique et d'apprentissage automatique.</div>
            </div>
            <div class="checkbox-item">
                <label class="custom-checkbox">
                    <input type="checkbox" id='option6' name='options[]' value='Cyber Security'>
                    <span class='checkmark'></span>
                    Cyber Security
                    <a href='#' class='see-more' onclick='toggleDescription("desc6")'>voir plus</a>
                </label>
                <div class='description-box' id='desc6'>La cybersécurité se concentre sur la protection des systèmes, des réseaux et des données contre les attaques numériques.</div>
            </div>
            <div class="date-item">
                <label class="custom-date">
                    <input type="date" id='option6' name='date' value='Option 6'>
                    <span class='checkmark'></span>
                    Date
                   
                </label>
                <div class='description-box' id='desc6'>La cybersécurité se concentre sur la protection des systèmes, des réseaux et des données contre les attaques numériques.</div>
            </div>

           
            <button type='submit' id='validateButton' class="close-btn" onclick="">Valider</button>
          
            <p id='errorMessage' class='error-message'></p>

        </form>

        <div id='customAlert' class='modal'>
            <div class='modal-content'>
                <span class='close-button' onclick='closeAlert()'>&times;</span>
                <p id='alertMessage'></p>
                <button onclick='closeAlert()'>OK</button>  
            </div>
        </div>

    </div>
     <script>
    function toggleDescription(descId) {
        const description = document.getElementById(descId);
        description.style.display = description.style.display === 'none' || description.style.display === '' ? 'block' : 'none';
    }
    
    document.getElementById('validateButton').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('input[name="options"]:checked');
    
        if (checkboxes.length === 0) {
            showAlert('Veuillez sélectionner au moins un evenement.'); 
        } else {
            showAlert('Options validées avec succès !'); 
        }
    });
    
    function showAlert(message) {
        document.getElementById('alertMessage').textContent = message;
        document.getElementById('customAlert').style.display = 'block'; 
    }
    
    function closeAlert() {
        document.getElementById('customAlert').style.display = 'none'; 
        closeModal(); 
        showSecondAlert(); 
    }
    
    function closeModal() {
        window.parent.document.getElementById('projectModal').style.display = 'none'; 
    }
    
    function showSecondAlert() {
        const secondAlertBox = document.getElementById('secondCustomAlert');
        const secondAlertMessage = document.getElementById('secondAlertMessage');
        
        secondAlertMessage.textContent = 'Votre sélection a bien été enregistrée. Merci !'; 
        secondAlertBox.style.display = 'block'; 
    }
    
    function closeSecondAlert() {
        document.getElementById('secondCustomAlert').style.display = 'none'; 
    }
</script>

</body>
</html>