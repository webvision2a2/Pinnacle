<?php
    require_once '../Controller/topicController.php';
    $topicController = new TopicController();
    $topic = $topicController->getTopicById($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Topic</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="./backoffice/css/sb-admin-2.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="card container mt-4">
            <div class="card-title">
                <h1 class="text-center mt-4">Edit Topic</h1>
            </div>
            <form class="card-body" method="POST" action="updateTopic2.php?id=<?php echo $topic['id']?>">
                <div class="form-group">
                    <input type="text" class="form-control form-control-user"
                        id="title" name="title" placeholder="Enter Title..." value="<?php echo $topic['title'];?>">
                </div>
                <div class="form-group">
                    <textarea class="form-control form-control-user"
                        id="description" name="description" placeholder="Enter Description..."><?php echo $topic['description'];?></textarea>
                </div>
                <div class="form-group">
                    <textarea class="form-control form-control-user"
                        id="content" name="content" placeholder="Enter Content..."><?php echo $topic['content'];?></textarea>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-user"
                        id="videolink" name="videolink" placeholder="Enter Video Link..." value="<?php echo $topic['video_link'];?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-user"
                        id="imageurl" name="imageurl" placeholder="Enter Image URL..." value="<?php echo $topic['image'];?>">
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Save changes
                </button>
            </form>
        </div>
        
    </body>
</html>