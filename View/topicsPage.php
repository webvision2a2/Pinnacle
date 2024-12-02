<?php
    require_once '../Controller/topicController.php';
    require_once '../Model/topic.php';

    $topicController = new TopicController();
    $topics = $topicController->getTopic();
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
        <div class="container-xxl p-0">
        <div class="container mt-4">
            <h2 class="text-center">Topics</h2>

            <div class="row container">
                <?php foreach($topics as $topic) { ?>
                    <div class="card col-4">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $topic['title']; ?></h4>
                            <div class="card-image"><img src="<?php echo $topic['image'];?>" alt="Topic image" ></div>
                            <p><?php echo $topic['description'];?></p>
                            <a href="readTopic.php?id=<?php echo $topic['id']; ?>" class="btn btn-primary">See more</a>
                        </div>
                    </div>
                <?php } ?>
            </div>

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