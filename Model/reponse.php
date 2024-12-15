<?php

class Reponse {
    private ?int $id; // Nullable for new responses (auto-incremented)
    private ?string $content; 
    private ?bool $is_correct; // Indicates whether the response is correct
    private ?int $id_question; // Foreign key referencing the question

    public function __construct($id, $content, $is_correct, $id_question) {
        $this->id = $id;
        $this->content = $content;
        $this->is_correct = $is_correct;
        $this->id_question = $id_question;
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getIsCorrect(): bool {
        return $this->is_correct;
    }

    public function getIdQuestion(): int {
        return $this->id_question;
    }

    // Display method
    public function show() {
        echo "
            <table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Content</th>
                    <th>Is Correct</th>
                    <th>Question ID</th>
                </tr>
                <tr>
                    <td>{$this->id}</td>
                    <td>{$this->content}</td>
                    <td>" . ($this->is_correct ? 'Yes' : 'No') . "</td>
                    <td>{$this->id_question}</td>
                </tr>
            </table>
        ";
    }
}

?>
