<?php
    require_once '../../Controller/topicController.php';

    $topicController = new TopicController();
    $topicId = $_GET['id'];
    $topicController->deleteTopic($topicId);

    header('Location: topicsList.php');
?>