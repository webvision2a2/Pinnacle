<?php
    require_once '../Controller/commentController.php';
<<<<<<< HEAD
    
=======
>>>>>>> dcb6d4c2ce784200db028ed4c59de45853ac9ff1
    $commentController = new CommentController();

    $commentId = $_GET['id'];
    $articleId = $_GET['topid'];

    $commentController->deleteComment($commentId);

    header("Location: readTopic.php?id=" . $_GET['topid']);
    exit;
?>