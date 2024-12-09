<?php
class Feedback {
    private ?int $id;
    private ?int $quiz_id;
    private ?int $user_id;
    private ?int $score;
    private ?string $feedback_text;
    private ?array $recommendations;

    public function __construct($id, $quiz_id, $user_id, $score, $feedback_text, $recommendations) {
        $this->id = $id;
        $this->quiz_id = $quiz_id;
        $this->user_id = $user_id;
        $this->score = $score;
        $this->feedback_text = $feedback_text;
        $this->recommendations = $recommendations;
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

    public function getFeedbackText(): ?string {
        return $this->feedback_text;
    }

    public function getRecommendations(): ?array {
        return $this->recommendations;
    }

    // Display method
    public function show() {
        echo "
            <table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Quiz ID</th>
                    <th>User ID</th>
                    <th>Score</th>
                    <th>Feedback</th>
                    <th>Recommendations</th>
                </tr>
                <tr>
                    <td>{$this->id}</td>
                    <td>{$this->quiz_id}</td>
                    <td>{$this->user_id}</td>
                    <td>{$this->score}</td>
                    <td>{$this->feedback_text}</td>
                    <td>" . implode(", ", $this->recommendations) . "</td>
                </tr>
            </table>
        ";
    }
}
?>
