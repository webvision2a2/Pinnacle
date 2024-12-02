<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Topic</title>

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
                <h1 class="text-center m-2">Add Topic</h1>
            </div>
            <form class="card-body" method="POST" action="addTopic.php" id="inscription">
                <div class="form-group">
                    <input type="text" class="form-control form-control-user"
                        id="title" name="title" placeholder="Enter Title...">
                </div>
                <div class="form-group">
                    <textarea class="form-control form-control-user"
                        id="description" name="description" placeholder="Enter Description..."></textarea>
                </div>
                <div class="form-group">
                    <textarea class="form-control form-control-user"
                        id="content" name="content" placeholder="Enter Content..."></textarea>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-user"
                        id="videolink" name="videolink" placeholder="Enter Video Link...">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-user"
                        id="imageurl" name="imageurl" placeholder="Enter Image URL...">
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Add Topic
                </button>
            </form>
        </div>
        <p style="color: red;" id="erreur" align="center"></p>
        <script src="script.js"></script>
    </body>
</html>