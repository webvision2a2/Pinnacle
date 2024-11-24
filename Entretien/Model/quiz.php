<?php
class Quiz {
    private ?int $id;
    private ?string $title;
    private ?string $description;
    private ?DateTime $datec;
    private ?string $author;
    private ?int $time_limit;
    private ?string $difficulty;
    private ?string $category;
    private ?int $total_questions;
    
    public function __construct( $id ,$title , $description , $datec ,$author ,$time_limit,$difficulty, $category, $total_questions) {
        
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->datec = $datec;

        // To Ensure that $datec is a DateTime object
        //if (is_string($datec)) {
            //$this->datec = new DateTime($datec);
        //} elseif ($datec instanceof DateTime) {
            //$this->datec = $datec;
        //} else {
            //throw new TypeError('Invalid type for $datec. Expected string or DateTime.');
        //}

        $this->author = $author;
        $this->time_limit = $time_limit;
        $this->difficulty = $difficulty;
        $this->category = $category;
        $this->total_questions = $total_questions;
    
    }

    // Getter methods
    public function getId(): ?int {
        return $this->id;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function getAuthor(): ?string {
        return $this->author;
    }

    public function getDatec(): ?DateTime {
        return $this->datec;
    }
    public function getTimeLimit(): int {
        return $this->time_limit;
    }

    public function getDifficulty(): string {
        return $this->difficulty;
    }

    public function getCategory(): string {
        return $this->category;
    }

    public function getTotalQuestions(): int {
        return $this->total_questions;
    }

    // Display method
    public function show() {
        echo "
            <table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Auteur</th>
                    <th>Date de Creation</th>
                    <th>Time Limit (minutes)</th>
                    <th>Difficulty</th>
                    <th>Category</th>
                    <th>Total Questions</th>
                </tr>
                <tr>
                    <td>{$this->id}</td>
                    <td>{$this->title}</td>
                    <td>{$this->description}</td>
                    <td>{$this->author}</td>
                    <td>{$this->datec}</td>
                     <td>{$this->time_limit}</td>
                    <td>{$this->difficulty}</td>
                    <td>{$this->category}</td>
                    <td>{$this->total_questions}</td>
                </tr>
            </table>
        ";
    }
}
?>