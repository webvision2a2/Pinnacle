<?php
    require_once '../Controller/commentController.php';
    require_once '../Model/comment.php';

    $comment = new Comment($_GET['topid'],$_POST['content']);

    $commentController = new CommentController();
    $commentController->addComment($comment);
    header("Location: readTopic.php?id=" . $_GET['topid']);

    exit;
?>