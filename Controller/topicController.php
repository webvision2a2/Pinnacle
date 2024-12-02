<?php
    require_once '../Config.php';
    require_once '../Model/topic.php';

    class TopicController {

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


    }
?>