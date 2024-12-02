<?php
    include_once '../Controller/topicController.php';
    $topicController = new TopicController();
    $topic = $topicController->getTopicById($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Topic</title>

        <!-- Favicon -->
        <link href="./frontoffice/img/favicon.ico" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="./frontoffice/lib/animate/animate.min.css" rel="stylesheet">
        <link href="./frontoffice/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="./frontoffice/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="./frontoffice/css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="./frontoffice/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-xxl bg-white p-0">
            <div class="mt-4">
                <div class="card">
                    <div class="card-title">
                    <h1 class="text-center mt-4"><?php echo $topic['title'];?></h1>
                    </div>
                    <div class="card-image container text-center">
                        <img src="<?php echo $topic['image'];?>">
                    </div>
                    <div class="card-body text-center">
                        <p><?php echo $topic['description'];?></p>
                        <p><?php echo $topic['content'];?></p>
                        <a href="<?php echo $topic['video_link'];?>">Video link</a>
                    </div>
                </div>

                <?php
                require_once '../Controller/commentController.php';	

                $topid = $_GET['id'] ?? null;

                $commentController = new CommentController();

                $comments = $commentController->getComments($topid);

                foreach ($comments as $comment):?>
                    
                    <div class="comment">
                        <p><strong>Utilisateur :</strong> <?php echo $comment['content']  ?> </p>
                        <p class="meta"><em>Publié le <?php echo $comment['datec'] ?></em></p>
                        <p class="meta">
                            <a href="updateComment.php?id=<?php echo $comment['id']?>&topid=<?php echo $topid ?>">Modifier</a> |
                            <a href="deleteComment.php?id=<?php echo $comment['id']?>&topid=<?php echo $topid ?>">Supprimer</a>
                        </p>
                    </div>
            
            <?php endforeach;?>

                <form action="addComment.php?topid=<?php echo $_GET['id'] ;?>" method="POST">
                    <h4>Ajouter un commentaire</h4>
                    <textarea name="content" rows="4" placeholder="Enter your comment"></textarea>
                    <button type="submit">Publier</button>
                </form>
            </div>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/isotope/isotope.pkgd.min.js"></script>
        <script src="lib/lightbox/js/lightbox.min.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
    </body>
</html>