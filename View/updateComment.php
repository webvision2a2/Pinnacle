<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

</head>
<body>

    <div class="container">
        <div>
            <h3>Edit Comment</h3>
            <?php 
                require_once '../Controller/commentController.php';
                $commentController = new CommentController();

                $comment = $commentController->getCommentById($_GET['id'],$_GET['topid']);
            ?>

            <form action="updateComment2.php?id=<?php echo $_GET['id']; ?>&topid=<?php echo $_GET['topid']; ?>" method="Post">
                <h4>Modifier votre commentaire</h4>
                <textarea name="content" rows="10"><?php echo $comment['content'] ?></textarea>
                <button type="submit">Publier</button>
            </form>
        </div>
    </div>

</body>
</html>
