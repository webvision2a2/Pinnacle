<?php
    require_once '../Controller/commentController.php';
    $commentController = new CommentController();

    $commentId = $_GET['id'];
    $newContent = $_POST['content'];

    $commentController->updateComment($commentId,$newContent);

    header("Location: readTopic.php?id=" . $_GET['topid']);
?>