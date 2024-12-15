<?php

class Domaine {
    private ?int $id;
    private ?string $nom;
    private ?string $description;
    private ?string $image;
    private ?string $competence;

    // Constructor
    public function __construct(?int $id, ?string $nom, ?string $description, ?string $image, ?string $competence) {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->image = $image;
        $this->competence = $competence;

    }

    // Getters and Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(?string $nom): void {
        $this->nom = $nom;
    }

    public function getdescription(): ?string {
        return $this->description;
    }

    public function setdescription(?string $description): void {
        $this->description = $description;
    }

    public function getImage(): ?string {
        return $this->image;
    }

    public function setImage(?string $image): void {
        $this->image = $image;
    }
    public function getcompetence(): ?string {
        return $this->competence;
    }

    public function setcompetence(?string $competence): void {
        $this->competence = $competence;
    }

}
?>