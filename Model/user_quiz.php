<?php
class UserQuiz {
    private ?int $id;
    private ?int $quiz_id;
    private ?int $user_id;
    private ?int $score;
    private ?int $attempts;
    private ?string $email;

    public function __construct($id, $quiz_id, $user_id, $score, $attempts, $email) {
        $this->id = $id;
        $this->quiz_id = $quiz_id;
        $this->user_id = $user_id;
        $this->score = $score;
        $this->attempts = $attempts;
        $this->email = $email;
    }

    // Getter methods
    public function getId(): ?int {
        return $this->id;
    }

    public function getQuizId(): ?int {
        return $this->quiz_id;
    }

    public function getUserId(): ?int {
        return $this->user_id;
    }

    public function getScore(): ?int {
        return $this->score;
    }

    public function getAttempts(): ?int {
        return $this->attempts;
    }

    public function getEmail(): ?string {
        return $this->email;
    }
}


 //CLASS USER TO FETCH THE EMAIL FROM THE USER

    class User {
        private ?int $id;
        private ?string $nom;
        private ?string $prenom;
        private ?string $email;
        private ?string $password;
        private ?string $role;
        private ?DateTime $date_creation;
        private ?bool $verification;
        private ?string $face_id;

        public function __construct($id, $nom, $prenom, $email, $password, $role, $date_creation, $verification, $face_id) {
            $this->id = $id;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->email = $email;
            $this->password = $password;
            $this->role = $role;

            if (is_string($date_creation)) {
                $this->date_creation = new DateTime($date_creation);
            } elseif ($date_creation instanceof DateTime) {
                $this->date_creation = $date_creation;
            } else {
                throw new TypeError('Invalid type for $date_creation. Expected string or DateTime.');
            }

            $this->verification = $verification;
            $this->face_id = $face_id;
        }

        // Getter methods
        public function getId(): ?int {
            return $this->id;
        }

        public function getNom(): ?string {
            return $this->nom;
        }

        public function getPrenom(): ?string {
            return $this->prenom;
        }

        public function getEmail(): ?string {
            return $this->email;
        }

        public function getPassword(): ?string {
            return $this->password;
        }

        public function getRole(): ?string {
            return $this->role;
        }

        public function getDateCreation(): ?DateTime {
            return $this->date_creation;
        }

        public function isVerified(): ?bool {
            return $this->verification;
        }

        public function getFaceId(): ?string {
            return $this->face_id;
        }

        // Display method
        public function show() {
            echo "
                <table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Date de Création</th>
                        <th>Verification</th>
                        <th>Face ID</th>
                    </tr>
                    <tr>
                        <td>{$this->id}</td>
                        <td>{$this->nom}</td>
                        <td>{$this->prenom}</td>
                        <td>{$this->email}</td>
                        <td>{$this->password}</td>
                        <td>{$this->role}</td>
                        <td>{$this->date_creation->format('Y-m-d')}</td>
                        <td>{$this->verification}</td>
                        <td>{$this->face_id}</td>
                    </tr>
                </table>
            ";
        }
    }


?>

