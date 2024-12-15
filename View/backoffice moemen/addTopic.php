<?php
    require_once '../../Controller/topicController.php';
    require_once '../../Model/topic.php';

    $topicController = new TopicController();

    $title = $_POST["title"];
    $description = $_POST["description"];
    $content = $_POST["content"];
    $videolink = $_POST["videolink"];
    $imageurl = $_POST["imageurl"];

    $topic = new Topic($title, $description, $content, $videolink, $imageurl);

    $topicController->addTopic($topic);

    header("Location: topicsList.php");

    exit;
?>