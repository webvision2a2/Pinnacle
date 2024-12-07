<?php
    require_once '../Controller/topicController.php';
    $topicController = new TopicController();
    $topic = $topicController->getTopicById($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Update Topic</title>

    <!-- Custom fonts for this template-->
    <link href="./backoffice/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./backoffice/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Topiclist -->
            <li class="nav-item">
                <a class="nav-link" href="topicsList.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Topics List</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Createtopic -->
            <li class="nav-item">
                <a class="nav-link" href="createTopic.php">
                    <i class="fas fa-fw fa-folder"></i></i>
                    <span>Create Topic</span></a>
            </li>

        

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                

                <!-- Begin Page Content -->
                
                    <br>
                    <div class="wow fadeInUp" data-wow-delay="0.1s">
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="wow fadeInUp" data-wow-delay="0.3s">
                                <div class="mt-4">
                                    
                                    <div class="card container mt-4">
                                        <div class="card-title">
                                            <h1 class="text-center mt-4">Edit Topic</h1>
                                        </div>
                                        <form class="card-body" method="POST" action="updateTopic2.php?id=<?php echo $topic['id']?>" id="inscription">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    id="title" name="title" placeholder="Enter Title..." value="<?php echo $topic['title'];?>">
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <textarea class="form-control form-control-user"
                                                    id="description" name="description" placeholder="Enter Description..." rows="4"><?php echo $topic['description'];?></textarea>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <textarea class="form-control form-control-user"
                                                    id="content" name="content" placeholder="Enter Content..." rows="4"><?php echo $topic['content'];?></textarea>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    id="videolink" name="videolink" placeholder="Enter Video Link..." value="<?php echo $topic['video_link'];?>">
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    id="imageurl" name="imageurl" placeholder="Enter Image URL..." value="<?php echo $topic['image'];?>">
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-primary w-100 py-3">
                                                Save changes
                                            </button>
                                        </form>
                                    <p style="color: red;" id="erreur" align="center"></p>
                                    </div>
                                    
                                </div>

                        
                            </div>
                        </div>
                    <script src="scripttopic.js"></script>
                    </div>
                
                
            <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Your Website 2024</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="./backoffice/vendor/jquery/jquery.min.js"></script>
    <script src="./backoffice/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="./backoffice/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="./backoffice/js/sb-admin-2.min.js"></script>

</body>

</html>