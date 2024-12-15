<?php

class Candidature
{
    private $nom;
    private $prenom;
    private $numero;
    private $email;
    private $cv;
    private $id_stage;
    private $etat;  // Ajout de la propriété pour l'état de la candidature
    private $id_user; // Ajout de la propriété id_user

    // Constructeur mis à jour avec l'ajout de id_user et état
    public function __construct($nom, $prenom, $numero, $email, $cv, $id_stage, $id_user, $etat = 'en cours') 
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->numero = $numero;
        $this->email = $email;
        $this->cv = $cv;
        $this->id_stage = $id_stage;
        $this->id_user = $id_user; // Initialisation de id_user
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
    public function getIdUser() { return $this->id_user; } // Getter pour id_user

    // Setters
    public function setEtat($etat) {
        $this->etat = $etat;
    }

    public function setIdUser($id_user) {
        $this->id_user = $id_user; // Setter pour id_user
    }
}

?>
