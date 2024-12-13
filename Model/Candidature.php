<?php

<<<<<<< HEAD
/* class Candidature
=======
<<<<<<< HEAD
/* class Candidature
=======
<<<<<<< HEAD
/* class Candidature
=======
<<<<<<< HEAD
/* class Candidature
=======
class Candidature
>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
>>>>>>> b4a7ddee5f45959b2e0369349cbe89e271e53df7
>>>>>>> 3a91d57dee08a2e567788638ae118b4e4071076b
{
    private $nom;
    private $prenom;
    private $numero;
    private $email;
    private $cv;
    private $id_stage;

    public function __construct($nom, $prenom, $numero, $email, $cv, $id_stage)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->numero = $numero;
        $this->email = $email;
        $this->cv = $cv;
        $this->id_stage = $id_stage;
    }

    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getNumero() { return $this->numero; }
    public function getEmail() { return $this->email; }
    public function getCv() { return $this->cv; }
    public function getIdStage() { return $this->id_stage; }
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
>>>>>>> b4a7ddee5f45959b2e0369349cbe89e271e53df7
>>>>>>> 3a91d57dee08a2e567788638ae118b4e4071076b
} */

class Candidature
{
    private $nom;
    private $prenom;
    private $numero;
    private $email;
    private $cv;
    private $id_stage;
    private $etat;  // Ajout de la propriété pour l'état de la candidature

    // Constructeur mis à jour avec l'ajout de l'état
    public function __construct($nom, $prenom, $numero, $email, $cv, $id_stage, $etat = 'en cours') 
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->numero = $numero;
        $this->email = $email;
        $this->cv = $cv;
        $this->id_stage = $id_stage;
        $this->etat = $etat;  // Par défaut l'état est 'en cours'
    }

    // Getters
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getNumero() { return $this->numero; }
    public function getEmail() { return $this->email; }
    public function getCv() { return $this->cv; }
    public function getIdStage() { return $this->id_stage; }
    public function getEtat() { return $this->etat; }  // Getter pour l'état

    // Setter pour l'état
    public function setEtat($etat) {
        $this->etat = $etat;
    }
}


<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
}

>>>>>>> 9a548a0f2e33eeeca8558231a4df113c476541b6
>>>>>>> 9b68f2222f40985bd4afe91fc6758d1f8609557d
>>>>>>> b4a7ddee5f45959b2e0369349cbe89e271e53df7
>>>>>>> 3a91d57dee08a2e567788638ae118b4e4071076b
?>
