<?php
<<<<<<< HEAD

class Stage {
    private $id_stage;
    private $nom_stage; // Ajout du champ "nom_stage"
=======
/* 
class Stage {
    private $id_stage;
    private $nom_societe;
    private $type;
    private $duration;
    private $email;
    private $speciality;
    private $documents;

    public function __construct($id_stage, $nom_societe, $type, $duration, $email, $speciality, $documents) {
        $this->id_stage = $id_stage;
        $this->nom_societe = $nom_societe;
        $this->type = $type;
        $this->duration = $duration;
        $this->email = $email;
        $this->speciality = $speciality;
        $this->documents = $documents;
    }

    public function getIdStage() {
        return $this->id_stage;
    }

    public function getNomStage() {
        return $this->nom_societe;
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
} */


class Stage {
    private $id_stage;
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
    private $type;
    private $duration;
    private $email;
    private $speciality;
    private $documents;
    private $id_societe;  // ID de la société associée

<<<<<<< HEAD
    public function __construct($id_stage, $nom_stage, $type, $duration, $email, $speciality, $documents, $id_societe) {
        $this->id_stage = $id_stage;
        $this->nom_stage = $nom_stage; // Assurez-vous que le nom du stage est bien attribué
=======
    public function __construct($id_stage, $type, $duration, $email, $speciality, $documents, $id_societe) {
        $this->id_stage = $id_stage;
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
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

<<<<<<< HEAD
    public function getNomStage() {
        return $this->nom_stage; // Retourne le nom du stage
    }

=======
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
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

<<<<<<< HEAD
    public function setNomStage($nom_stage) {
        $this->nom_stage = $nom_stage;
    }

=======
>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
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


<<<<<<< HEAD
=======

>>>>>>> bdf924f206f39f0052cdb7e993e0f5176ade5091
?>
