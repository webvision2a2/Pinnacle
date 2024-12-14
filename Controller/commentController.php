<?php
require_once(__DIR__ . '/../Model/comment.php');
require_once(__DIR__ . '/../Config.php');

class CommentController {
    public function getComments($idtopic) {
        $conn = config::getConnexion();

        $sql = "SELECT * FROM tcomment where idtopic=:idtopic";
        try {
            $query = $conn->prepare($sql);
            $query->execute([
                ':idtopic' => $idtopic
            ]);
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function addComment($comment) {
        $conn = config::getConnexion();

        $sql = "INSERT INTO tcomment (idtopic, content, datec) VALUES (:idtopic,:content,:datec)";

        try {
            $query = $conn->prepare($sql);
            $query->execute([
                ':idtopic' => $comment->getIdTopic(),
                ':content' => $comment->getContent(),
                ':datec' => $comment->getDatec()
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function getCommentById($id,$idtopic) {
        $conn = config::getConnexion();
        $sql = "SELECT * FROM tcomment WHERE id =:id and idtopic=:idtopic";
        
        try {
            $query = $conn->prepare($sql);
            $query->execute([
                ':id' => $id,
                ':idtopic' => $idtopic
            ]);
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function updateComment($id, $newContent) {
        $conn = config::getConnexion();
        $sql = "UPDATE tcomment SET content=:content WHERE id = :id";
        
        try {
            $query = $conn->prepare($sql);
            $query->execute([
                ':id' => $id,
                ':content' => $newContent
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function deleteComment($id) {
        $conn = config::getConnexion();
        $sql = "DELETE FROM tcomment WHERE id = :id";
        
        try {
            $query = $conn->prepare($sql);
            $query->execute([':id' => $id]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function getCommentsCount($idtopic) {
        $conn = config::getConnexion();
    
        $sql = "SELECT COUNT(*) FROM tcomment WHERE idtopic = :idtopic";
        try {
            $query = $conn->prepare($sql);
            $query->execute([':idtopic' => $idtopic]);
            return $query->fetchColumn(); // Retourne le nombre de commentaires
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

}