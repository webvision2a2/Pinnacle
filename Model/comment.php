<?php
class Comment {
    private $idComment;
    private $idTopic;
    private $content;
    private $datec;

    public function __construct($idTopic, $content) {
        $this->idTopic = $idTopic;
        $this->content = $content;
        $this->datec = date('Y-m-d');
    }

    public function getIdComment() {
        return $this->idComment;
    }

    public function setIdComment($idComment) {
        $this->idComment = $idComment;
    }

    public function getIdTopic() {
        return $this->idTopic;
    }

    public function setIdTopic($idTopic) {
        $this->idTopic = $idTopic;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getDatec() {
        return $this->datec;
    }

    public function setDatec($datec) {
        $this->datec = $datec;
    }
}
