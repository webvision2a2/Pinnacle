<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>STable des participants</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                <div class="sidebar-brand-text mx-3">Pinnacle <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider"> <!-- Heading -->
            <div class="sidebar-heading">
                FrontOffice
            </div>



            <!-- Nav Item - Tables -->
            <li class="nav-item active">
                <a class="nav-link" href="../../view/FrontOffice/index.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Menu</span></a>
            </li>






            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Tables
            </div>





            <!-- Nav Item - Tables -->
            <li class="nav-item active">
                <a class="nav-link" href="tables.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables des evennements</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item active">
                <a class="nav-link" href="events_participants.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables des participants</span></a>
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

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">



                        <!-- Nav Item - Alerts -->

                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tables des participants</h1>

                    <?php
                    include '../../config.php';

                    // Get the database connection
                    $db = config::getConnexion();

                    // Query to fetch all participant data for each event
                    $query = "SELECT ep.id, ep.event_id, ep.user_id, ep.nom, ep.prenom, ep.email, ep.event_date, e.title 
          FROM events_participants ep
          JOIN events e ON e.id = ep.event_id";

                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <!-- DataTables Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Registered Participants</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Event ID</th>
                                            <th>User ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Event Date</th>
                                            <th>Event Title</th>
                                            <th style="width: 150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($participants) > 0): ?>
                                            <?php foreach ($participants as $participant): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($participant['id']) ?></td>
                                                    <td><?= htmlspecialchars($participant['event_id']) ?></td>
                                                    <td><?= htmlspecialchars($participant['user_id']) ?></td>
                                                    <td><?= htmlspecialchars($participant['nom']) ?> <?= htmlspecialchars($participant['prenom']) ?></td>
                                                    <td><?= htmlspecialchars($participant['email']) ?></td>
                                                    <td><?= htmlspecialchars($participant['event_date']) ?></td>
                                                    <td><?= htmlspecialchars($participant['title']) ?></td>
                                                    <td>
                                                        <a href="http://localhost/pinnacle/controller/delete.php?id=<?= $participant['id'] ?>"
                                                            style="color: red;"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </a>|
                                                        <!-- Send Email Button (using a link) -->
                                                        <a href="javascript:void(0);" style="color: orange;" onclick="openEmailPopup(<?= $participant['event_id'] ?>, '<?= addslashes($participant['title']) ?>')">
                                                            <i class="fas fa-envelope"></i> Email
                                                        </a>

                                                        <?php if (isset($_GET['status'])): ?>
                                                            <?php if ($_GET['status'] == 'success'): ?>
                                                                <div class="alert alert-success">The email has been sent successfully!</div>
                                                            <?php elseif ($_GET['status'] == 'error'): ?>
                                                                <div class="alert alert-danger">An error occurred while sending the email.</div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8">No participants have registered for any events yet.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                  <!-- Modal -->
<!-- Modal -->
<div id="emailModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEmailPopup()">&times;</span>
        <div class="modal-header">
            <h2>Send Event Update Email</h2>
        </div>
        <div class="modal-body">
            <form method="POST" id="sendEmailForm" action="../../controller/send_email.php">
                <input type="hidden" id="event_id" name="event_id">
                <div>
                    <label for="email_subject">Subject:</label>
                    <input type="text" id="email_subject" name="email_subject" required>
                    <input type="hidden" name="event_id" value="1">
                    <input type="hidden" name="event_id" value="66"> <!-- Example event ID -->

                </div>
                <div>
                    <label for="email_content">Email Content:</label>
                    <textarea id="email_content" name="email_content" rows="5" required></textarea>
                </div>
                <div>
                    <label for="email_template">Select Template:</label>
                    <select id="email_template" name="email_template">
                        <option value="update">Event Update</option>
                        <option value="reminder">Event Reminder</option>
                        <option value="thankyou">Thank You for Registering</option>
                    </select>
                </div>
                
                <button id="sendEmailBtn" class="btn send-btn" onclick="sendEmail()">Send</button>

            </form>
        </div>
    </div>
</div>


<style>
   /* Modal Overlay */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Slightly darker background */
    z-index: 1000; /* On top of other content */
    overflow: auto; /* Enables scrolling if content overflows */
    transition: opacity 0.3s ease; /* Smooth fade-in and fade-out */
}

/* Modal Content */
.modal-content {
    background-color: #fff; /* White background */
    border-radius: 12px; /* Rounded corners */
    margin: 5% auto; /* Center the modal */
    padding: 30px;
    max-width: 600px; /* Modal width */
    width: 90%;
    box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.2); /* Subtle shadow */
    transition: transform 0.3s ease-out; /* Smooth entrance */
}

/* Header for Modal */
.modal-header {
    font-size: 1.8rem;
    font-weight: 700;
    color: #007bff; /* Blue color */
    margin-bottom: 20px;
    text-align: center;
}

/* Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 30px;
    font-weight: bold;
    color: #007bff;
    cursor: pointer;
    transition: color 0.3s ease;
}

/* Close button hover effect */
.close:hover {
    color: #0056b3; /* Darker blue on hover */
}

/* Modal Body */
.modal-body {
    margin-bottom: 20px;
    font-size: 1rem;
    color: #555;
    line-height: 1.6;
}

/* Input & Select Fields */
#sendEmailForm input,
#sendEmailForm select,
#sendEmailForm textarea {
    width: 100%;
    padding: 14px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 1rem;
    background-color: #f8f9fa; /* Light gray background */
    transition: all 0.3s ease; /* Smooth transitions for all effects */
    box-sizing: border-box; /* Ensures padding doesn't affect width */
}

/* Textarea specific */
#sendEmailForm textarea {
    min-height: 120px;
    resize: vertical;
}

/* Focus Effects */
#sendEmailForm input:focus,
#sendEmailForm select:focus,
#sendEmailForm textarea:focus {
    border-color: #007bff; /* Blue border on focus */
    outline: none;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.5); /* Light blue glow on focus */
}

/* Hover Effects */
#sendEmailForm input:hover,
#sendEmailForm select:hover,
#sendEmailForm textarea:hover {
    border-color: #0056b3; /* Darker blue on hover */
}

/* Button Styling */
#sendEmailForm button {
    background-color: #007bff; /* Blue background */
    color: white;
    padding: 14px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.1rem;
    width: 100%;
    transition: all 0.3s ease; /* Smooth transition */
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2); /* Subtle shadow */
}

/* Button hover effect */
#sendEmailForm button:hover {
    background-color: #0056b3; /* Darker blue on hover */
    transform: translateY(-2px); /* Slight lift effect */
    box-shadow: 0 8px 12px rgba(0, 123, 255, 0.3); /* Stronger shadow on hover */
}

/* Responsive Design */
@media (max-width: 600px) {
    .modal-content {
        width: 95%; /* Modal takes up more width on smaller screens */
    }

    .modal-header {
        font-size: 1.6rem;
    }

    #sendEmailForm input,
    #sendEmailForm select,
    #sendEmailForm textarea {
        font-size: 1rem;
    }
}

</style>



                    <!-- DataTables JavaScript Initialization -->
                    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#dataTable').DataTable(); // Initialize DataTables
                        });
                    </script>


                    <!-- DataTables JavaScript Initialization -->
                    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#dataTable').DataTable(); // Initialize DataTables
                        });
                    </script>

                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

               

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/datatables-demo.js"></script>
       
<script>
    function openEmailPopup() {
    document.getElementById("emailModal").style.display = "block";
    document.getElementById("emailModal").classList.add("show");
}

// Function to close the modal
function closeEmailPopup() {
    document.getElementById("emailModal").style.display = "none";
    document.getElementById("emailModal").classList.remove("show");
}
    // Handle form submission using AJAX
    function sendEmail(event) {
        event.preventDefault();  // Prevent form from reloading the page

        const formData = new FormData(document.getElementById('sendEmailForm'));

        fetch('send_email.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);  // Show success or error message
            if (data.success) {
                closeEmailPopup();  // Close the modal on success
            }
        })
        .catch(error => {
            console.error('Error sending email:', error);
        });
    }

    // Function to close the modal
    function closeEmailPopup() {
        document.getElementById('emailModal').style.display = 'none';
    }
</script>





</body>

</html>