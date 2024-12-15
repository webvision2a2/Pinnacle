<?php

class Cours {
    private ?int $id_cours;      // Primary key for the course
    private ?string $nom;        // Name of the course
    private ?string $fichier;     // File associated with the course
    private ?int $domaine_id;    // Foreign key referencing the domain

    // Constructor
    public function __construct(?int $id_cours, ?string $nom, ?string $fichier, ?int $domaine_id) {
        $this->id_cours = $id_cours;
        $this->nom = $nom;
        $this->fichier = $fichier;
        $this->domaine_id = $domaine_id;
    }

    // Getters and Setters
    public function getIdCours(): ?int {
        return $this->id_cours;
    }

    public function setIdCours(?int $id_cours): void {
        $this->id_cours = $id_cours;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(?string $nom): void {
        $this->nom = $nom;
    }

    public function getFichier(): ?string {
        return $this->fichier;
    }

    public function setFichier(?string $fichier): void {
        $this->fichier = $fichier;
    }

    public function getDomaineId(): ?int {
        return $this->domaine_id;
    }

    public function setDomaineId(?int $domaine_id): void {
        $this->domaine_id = $domaine_id; // Correctly reference domaine_id
    }
}
?>