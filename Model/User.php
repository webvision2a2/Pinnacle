<?php

class User {
    private ?int $id;
    private ?string $nom;
    private ?string $prenom;
    private ?string $email;
    private ?string $password;
    private ?int $role;
    private ?DateTime $date_creation;
    private ?int $verification;
    private ?string $face_id;

    // Constructor
    public function __construct(?int $id, ?string $nom, ?string $prenom, ?string $email, ?string $password, ?int $role, ?DateTime $date_creation, ?int $verification, ?string $face_id = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->date_creation = $date_creation;
        $this->verification = $verification;
        $this->face_id = $face_id;
    }


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

    public function getPrenom(): ?string {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): void {
        $this->prenom = $prenom;
    }

    public function getCreationDate(): ?DateTime {
        return $this->date_creation;
    }

    public function setCreationDate(?DateTime $date_creation): void {
        $this->date_creation = $date_creation;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): void {
        $this->email = $email;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(?string $password): void {
        $this->password = $password;
    }

    public function getRole(): ?int {
        return $this->role;
    }

    public function setRole(?int $role): void {
        $this->role = $role;
    }
    public function getVerification(): ?int {
        return $this->verification;
    }

    public function setVerification(?int $verification): void {
        $this->role = $verification;
    }
    public function getFaceId(): ?string {
        return $this->face_id;
    }

    public function setFaceId(?string $face_id): void {
        $this->face_id = $face_id;
    }
}

?>
