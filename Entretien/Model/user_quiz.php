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
?>
