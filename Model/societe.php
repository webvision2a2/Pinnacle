<?php

class Societe {
    private $id;
    private $nom_soc;
    private $adresse;
    private $numero;
    private $email;
    private $speciality;  // Devrait être un tableau

    public function __construct($id, $nom_soc, $adresse, $numero, $email, $speciality) {
        $this->id = $id;
        $this->nom_soc = $nom_soc;
        $this->adresse = $adresse;
        $this->numero = $numero;
        $this->email = $email;
        $this->speciality = $speciality;  // Assurez-vous que les spécialités sont un tableau
    }

    public function getNomSoc() {
        return $this->nom_soc;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSpeciality() {
        return $this->speciality;  // Retourne le tableau des spécialités
    }
}

?>
