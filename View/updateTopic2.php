<?php
    require_once '../Controller/topicController.php';
    require_once '../Model/topic.php';

    $topicController = new TopicController();
   
    $topicId = $_GET['id'];

    $newTitle = $_POST['title'];
    $newDescription = $_POST['description'];
    $newContent = $_POST['content'];
    $newVideolink = $_POST['videolink'];
    $newImageurl = $_POST['imageurl'];

    $topic = new Topic($newTitle,$newDescription,$newContent,$newVideolink,$newImageurl);

    $topicController->updateTopic($topicId,$topic);

    header('Location: topicsList.php');
?>