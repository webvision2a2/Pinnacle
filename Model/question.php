<?php

class Question {
    private ?int $id; // Nullable for new questions (auto-incremented)
    private ?string $content; 
    private ?int $points; 
    private ?string $type; // Type of question (MCQ, True/False, etc.)
    private ?int $id_quiz; // Foreign key referencing the quiz

    public function __construct($id, $content, $points, $type, $id_quiz) {
        $this->id = $id;
        $this->content = $content;
        $this->points = $points;
        $this->type = $type;
        $this->id_quiz = $id_quiz;
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getPoints(): int {
        return $this->points;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getIdQuiz(): int {
        return $this->id_quiz;
    }


    
    // Display method
    public function show() {
        echo "
            <table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Contenu</th>
                    <th>Points</th>
                    <th>Type</th>
                    <th>ID du Quiz</th>
                </tr>
                <tr>
                    <td>{$this->id}</td>
                    <td>{$this->content}</td>
                    <td>{$this->points}</td>
                    <td>{$this->type}</td>
                    <td>{$this->id_quiz}</td>
                </tr>
            </table>
        ";
    }

    
}

?>