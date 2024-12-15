<?php
    require_once '../../Controller/commentController.php';

    $commentController = new CommentController();

    $commentId = $_GET['id'];
    $articleId = $_GET['topid'];

    $commentController->deleteComment($commentId);

    header("Location: readTopic.php?id=" . $_GET['topid']);
    exit;
?>