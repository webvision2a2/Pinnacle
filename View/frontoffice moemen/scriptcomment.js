document.getElementById("com").addEventListener("submit",function(e){
    
    var erreur;
    var commentaire = document.getElementById("commentaire");
    

    
    
    if (!commentaire.value){
        erreur= "Veuillez renseigner un commentaire";
    }
    
    
    
    
    

    if (erreur){
        e.preventDefault();
        document.getElementById("erreur").innerHTML = erreur;
        return false;
    }else{
        alert('Commentaire envoyé!');
    }
    
})

   