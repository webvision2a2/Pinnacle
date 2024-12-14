document.getElementById("inscription").addEventListener("submit",function(e){
    
    var erreur;
    var title = document.getElementById("title");
    var description = document.getElementById("description");
    var content = document.getElementById("content");
    var videolink = document.getElementById("videolink");
    var imageurl = document.getElementById("imageurl");

    
    
    if (!imageurl.value){
        erreur= "Veuillez renseigner une image";
    }
    if (!videolink.value){
        erreur= "Veuillez renseigner un video";
    }
    if (!content.value){
        erreur= "Veuillez renseigner un contenu";
    }
    if (!description.value){
        erreur= "Veuillez renseigner une description";
    }
    if (!title.value){
        erreur= "Veuillez renseigner un titre";
    }
    
    
    
    

    if (erreur){
        e.preventDefault();
        document.getElementById("erreur").innerHTML = erreur;
        return false;
    }else{
        alert('Formulaire envoyé!');
    }
    
})
   