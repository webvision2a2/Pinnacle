<?php

class Candidature
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
}

?>
