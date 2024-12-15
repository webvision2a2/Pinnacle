<?php

class Stage {
    private $id_stage;
    private $nom_stage; // Ajout du champ "nom_stage"
    private $type;
    private $duration;
    private $email;
    private $speciality;
    private $documents;
    private $id_societe;  // ID de la société associée

    public function __construct($id_stage, $nom_stage, $type, $duration, $email, $speciality, $documents, $id_societe) {
        $this->id_stage = $id_stage;
        $this->nom_stage = $nom_stage; // Assurez-vous que le nom du stage est bien attribué
        $this->type = $type;
        $this->duration = $duration;
        $this->email = $email;
        $this->speciality = $speciality;
        $this->documents = $documents;
        $this->id_societe = $id_societe;  // Assurez-vous que l'ID de la société est bien attribué
    }

    public function getIdStage() {
        return $this->id_stage;
    }

    public function getNomStage() {
        return $this->nom_stage; // Retourne le nom du stage
    }

    public function getType() {
        return $this->type;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSpeciality() {
        return $this->speciality;
    }

    public function getDocuments() {
        return $this->documents;
    }

    public function getIdSociete() {
        return $this->id_societe;  // Retourne l'ID de la société associée
    }

    public function setIdStage($id_stage) {
        $this->id_stage = $id_stage;
    }

    public function setNomStage($nom_stage) {
        $this->nom_stage = $nom_stage;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setDuration($duration) {
        $this->duration = $duration;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSpeciality($speciality) {
        $this->speciality = $speciality;
    }

    public function setDocuments($documents) {
        $this->documents = $documents;
    }

    public function setIdSociete($id_societe) {
        $this->id_societe = $id_societe;
    }
}


?>
