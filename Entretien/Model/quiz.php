<?php
class Quiz {
    private ?int $id;
    private ?string $title;
    private ?string $description;
    private ?DateTime $datec;
    private ?string $author;
    public function __construct( $id ,$title , $description , $datec ,$author ) {
        
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
                </tr>
                <tr>
                    <td>{$this->id}</td>
                    <td>{$this->title}</td>
                    <td>{$this->description}</td>
                    <td>{$this->author}</td>
                    <td>{$this->datec}</td>
                </tr>
            </table>
        ";
    }
}
?>