<?php
    require_once '../Config.php';
    require_once '../Model/topic.php';

    class TopicController {

        private $pdo;

        public function __construct() {
        // Connexion à la base de données
        $this->pdo = new PDO('mysql:host=localhost;dbname=moemendb', 'root', '');
    }

        public function getTopic() {
            $conn = config::getConnexion();
            $sql = "SELECT * FROM topic";

            try {
                $query = $conn->prepare($sql);
                $query->execute();
                return $query->fetchAll();
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }

        public function addTopic($topic) {
            $conn = config::getConnexion();
            $sql = "INSERT INTO topic(title, description, content, video_link, image) VALUES (:title, :description, :content, :videolink, :imageurl)";

            try {
            $query = $conn->prepare($sql);
            $query->execute([
                ':title' => $topic->getTitle(),
                ':description' => $topic->getDescription(),
                ':content' => $topic->getContent(),
                ':videolink' => $topic->getVideolink(),
                ':imageurl' => $topic->getImageurl()
            ]);
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }

        public function getTopicById($id){
            $conn = config::getConnexion();
            $sql="select * from topic where id=:id ";
            try{
                $query=$conn->prepare($sql);
                $query->execute( [':id'=>$id]);
                return $query->fetch();
            } 
            catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }

        public function updateTopic($id,$topic){
            $conn = config::getConnexion();
            $sql="UPDATE topic SET title=:title ,description=:description, content=:content, video_link=:videolink, image=:imageurl WHERE id = :id";
            try{
            $query=$conn->prepare($sql);
            $query->execute([
                    ':id'=>$id,
                    ':title'=>$topic->getTitle(),
                    ':description'=>$topic->getDescription(),
                    ':content'=>$topic->getContent(),
                    ':videolink'=>$topic->getVideolink(),
                    ':imageurl'=>$topic->getImageurl()
                ]);
            }
            catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }

        public function deleteTopic($id){
            $conn = config::getConnexion();
            
            $sql="DELETE FROM topic WHERE id = :id";
            try{
                $query=$conn->prepare($sql);
                $query->execute([':id'=>$id]);
            }
            catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }

        public function getTopicsWithPagination($offset, $limit) {
            $conn = config::getConnexion();
            $sql = "SELECT * FROM topic LIMIT :offset, :limit";
            try {
                $query = $conn->prepare($sql);
                $query->bindValue(':offset', $offset, PDO::PARAM_INT);
                $query->bindValue(':limit', $limit, PDO::PARAM_INT);
                $query->execute();
                return $query->fetchAll();
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }
        
        public function getTotalTopicsCount() {
            $conn = config::getConnexion();
            $sql = "SELECT COUNT(*) AS total FROM topic";
            try {
                $query = $conn->prepare($sql);
                $query->execute();
                $result = $query->fetch();
                return $result['total'];
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }

        public function searchTopicsByName($searchQuery)
        {
            $conn = config::getConnexion();
            $sql = "SELECT * FROM topic WHERE title LIKE :searchQuery";
            try {
                $query = $conn->prepare($sql);
                $query->execute(['searchQuery' => '%' . $searchQuery . '%']);
                return $query->fetchAll();
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }

        public function getTopicsWithSearch($searchQuery, $limit, $offset)
    {
        $conn = config::getConnexion();
        $sql = "SELECT * FROM topic WHERE title LIKE :searchQuery LIMIT :limit OFFSET :offset";
        try {
            $query = $conn->prepare($sql);
            $query->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
            $query->bindValue(':limit', $limit, PDO::PARAM_INT);
            $query->bindValue(':offset', $offset, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function countTopicsWithSearch($searchQuery)
    {
        $conn = config::getConnexion();
        $sql = "SELECT COUNT(*) as count FROM topic WHERE title LIKE :searchQuery";
        try {
            $query = $conn->prepare($sql);
            $query->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
            $query->execute();
            return $query->fetch()['count'];
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    

    }

    
?>
