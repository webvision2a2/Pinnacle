<?php
class Profile {
    private ?int $id;
    private ?int $user_id;
    private ?string $domaine;
    private ?string $occupation;
    private ?int $age;
    private ?string $telephone;
    private ?string $photo_profil;

    // Constructor
    public function __construct(
        ?int $id, 
        ?int $user_id, 
        ?string $domaine, 
        ?string $occupation, 
        ?int $age, 
        ?string $telephone, 
        ?string $photo_profil
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->domaine = $domaine;
        $this->occupation = $occupation;
        $this->age = $age;
        $this->telephone = $telephone;
        $this->photo_profil = $photo_profil;
    }


    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getUserId(): ?int {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): void {
        $this->user_id = $user_id;
    }

    public function getDomaine(): ?string {
        return $this->domaine;
    }

    public function setDomaine(?string $domaine): void {
        $this->domaine = $domaine;
    }

    public function getOccupation(): ?string {
        return $this->occupation;
    }

    public function setOccupation(?string $occupation): void {
        $this->occupation = $occupation;
    }

    public function getAge(): ?int {
        return $this->age;
    }

    public function setAge(?int $age): void {
        $this->age = $age;
    }

    public function getTelephone(): ?string {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): void {
        $this->telephone = $telephone;
    }

    public function getProfilePicture(): ?string {
        return $this->photo_profil;
    }

    public function setProfilePicture(?string $photo_profil): void {
        $this->photo_profil = $photo_profil;
    }
}
?>