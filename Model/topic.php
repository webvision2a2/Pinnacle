<?php
    class Topic {
        private $id;
        private $title;
        private $description;
        private $content;
        private $videolink;
        private $imageurl;

        public function __construct($title, $description, $content, $videolink, $imageurl) {
            $this->title = $title;
            $this->description = $description;
            $this->content = $content;
            $this->videolink = $videolink;
            $this->imageurl = $imageurl;
        }

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getTitle() {
            return $this->title;
        }

        public function setTitle($title) {
            $this->title = $title;
        }

        public function getDescription() {
            return $this->description;
        }

        public function setDescription($description) {
            $this->description = $description;
        }

        public function getContent() {
            return $this->content;
        }

        public function setContent($content) {
            $this->content = $content;
        }

        public function getVideolink() {
            return $this->videolink;
        }

        public function setVideolink($videolink) {
            $this->videolink = $videolink;
        }

        public function getImageurl() {
            return $this->imageurl;
        }

        public function setImageurl($imageurl) {
            $this->imageurl = $imageurl;
        }
    }
?>
