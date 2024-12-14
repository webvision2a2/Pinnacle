<?php
include_once '../../Controller/reponseController.php';
include_once '../../Model/reponse.php';

$error = '';

$id_question = $_GET['id_question'] ?? null;
$question_type = $_GET['question_type'] ?? null;
$quiz_id = $_GET['quiz_id'] ?? null;

if (!$id_question || !$question_type || !$quiz_id) {
    // Handle the error: missing parameters
    echo "Invalid request: Missing question ID or type.";
    exit;
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reponseController = new ReponseController();

    // Handle QCM
    if ($question_type === 'QCM') {
        if (isset($_POST['content'], $_POST['is_correct']) && !empty($_POST['content'])) {
            $contents = $_POST['content']; // Array of options
            $correctOption = $_POST['is_correct']; // Correct option index (1-based)

            foreach ($contents as $index => $content) {
                $is_correct = ($correctOption == $index + 1) ? 1 : 0;
                $reponse = new Reponse(NULL, $content, $is_correct, $id_question);
                $reponseController->addReponse($reponse);
            }
            header("Location: listReponse.php?quiz_id=$quiz_id&id_question=$id_question&question_type=$question_type");
            exit;
        } else {
            $error = "Tous les champs sont OBLIGATOIRES.";
        }
    }
    // Handle Réponse Courte
    elseif ($question_type === 'Réponse Courte') {
        if (isset($_POST['answer_text']) && !empty($_POST['answer_text'])) {
            $reponse = new Reponse(NULL, $_POST['answer_text'], 1, $id_question);
            $reponseController->addReponse($reponse);

            header("Location: listReponse.php?quiz_id=$quiz_id&id_question=$id_question&question_type=$question_type");
            exit;
        } else {
            $error = "La réponse correcte est obligatoire.";
        }
    }
    // Handle Vrai/Faux
    elseif ($question_type === 'Vrai/Faux') {
        if (isset($_POST['is_correct']) && ($_POST['is_correct'] === '1' || $_POST['is_correct'] === '0')) {
            // Determine which answer is correct
            $isCorrect = (int)$_POST['is_correct']; // 1 for Vrai, 0 for Faux
    
            // Add the correct answer
            $correctAnswer = $isCorrect === 1 ? 'Vrai' : 'Faux';
            $reponse = new Reponse(NULL, $correctAnswer, 1, $id_question);
            $reponseController->addReponse($reponse);
    
            // Add the incorrect answer
            $incorrectAnswer = $isCorrect === 1 ? 'Faux' : 'Vrai';
            $reponse = new Reponse(NULL, $incorrectAnswer, 0, $id_question);
            $reponseController->addReponse($reponse);
    
            // Redirect to the response list page
            header("Location: listReponse.php?quiz_id=$quiz_id&id_question=$id_question&question_type=$question_type");
            exit;
        } else {
            $error = "Veuillez sélectionner une réponse correcte (Vrai/Faux).";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Blank</title>

    <!-- Custom fonts for this template-->
    <link href="template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="template/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="template\img\LOGO white.png" width="50px" height="50px">
                </div>
                <div class="sidebar-brand-text mx-3">Pinnacle</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
          
<!-- Heading -->
            <div class="sidebar-heading">
                Categories
            </div>

            <!-- Nav Item - Utilisateurs -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-user"></i>
                    <span>Utilisateurs</span></a>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-envelope"></i>
                    <span>Messages</span></a>
            </li>

            <!-- Nav Item - Catalogues -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-book"></i>
                    <span>Catalogues</span></a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                    aria-controls="collapsePages">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Enretiens</span>
                </a>
                <div id="collapsePages" class="collapse show" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item active" href="listQuiz.php">Quiz</a>
                        <a class="collapse-item" href="#">Scores</a>
                        <a class="collapse-item" href="#">Feedback</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">detail</h6>
                        <a class="collapse-item" href="#">Quiz</a>
                        <a class="collapse-item " href="#">Questions</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Ateliers -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-tools"></i>
                    <span>Ateliers</span></a>
            </li>

            <!-- Nav Item - Stages -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-briefcase"></i>
                    <span>Stages</span></a>
            </li>

            <!-- Nav Item - Evenements -->
                        <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Evenements</span></a>
            </li>

          
                <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            
                <!-- Nav Item - Tables -->
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Se Déconnecter</span></a>
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
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Rechercher..."
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

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                      

                        <!-- Nav Item - Messages -->
                 

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administarteur #1</span>
                                <img class="img-profile rounded-circle"
                                    src="template/img/undraw_profile.svg">
                            </a>
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

                    <div class="container mt-5">
                    <h1 class="text-primary text-center">Ajouter Une Nouvelle Réponse</h1>
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>

                        <!-- Form -->
                        <form id="reponseForm" action="addReponse.php?id_question=<?= htmlspecialchars($id_question) ?>&question_type=<?= htmlspecialchars($question_type) ?>&quiz_id=<?= htmlspecialchars($quiz_id) ?>" method="POST">

                            <!-- Common Fields -->
                           

                            <!-- Dynamic Fields -->
                            <div id="additionalFields"></div>

                            <button type="submit" class="btn btn-primary btn-block">Ajouter Réponse</button>
                            <a href="listReponse.php?id_question=<?= htmlspecialchars($id_question) ?>&question_type=<?= htmlspecialchars($question_type) ?>&quiz_id=<?= htmlspecialchars($quiz_id) ?>" class="btn btn-secondary btn-block">Annuler</a>
                        </form>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Pinnacle 2024</span>
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
                    <a class="btn btn-primary" href="html/login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="template/vendor/jquery/jquery.min.js"></script>
    <script src="template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="template/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="template/js/sb-admin-2.min.js"></script>
    <script>
        // Get the question type from PHP
        const questionType = "<?= htmlspecialchars($question_type) ?>";

        // Reference to the dynamic fields container
        const additionalFields = document.getElementById('additionalFields');
        const form = document.querySelector('#reponseForm');

        let maxOptions = 4; // Maximum number of options for QCM
        let optionCount = 0; // Track the current number of options

        // Render fields based on question type
        function renderFields(type) {
            let fields = '';

            if (type === 'QCM') {
                fields = `
                    <div id="qcm-container">
                        <button type="button" id="addOption" class="btn btn-primary mb-2">Ajouter une option</button>
                        <p class="text-muted">Vous pouvez ajouter jusqu'à ${maxOptions} options. Une seule option peut être correcte.</p>
                        <div id="qcm-options"></div>
                    </div>
                `;
            } else if (type === 'Réponse Courte') {
                fields = `
                    <div class="form-group">
                        <label for="answer_text" class="text-primary">Réponse Correcte :</label>
                        <input type="text" id="answer_text" name="answer_text" class="form-control" placeholder="Entrez la réponse correcte">
                    </div>
                    <div class="form-group">
                        <label for="requirements" class="text-primary">Exigences pour la réponse :</label>
                        <input type="text" name="requirements" class="form-control" placeholder="Exigences spécifiques (facultatif)">
                    </div>
                `;
            } 
            else if (type === 'Vrai/Faux') {
                fields = `
                    <div class="form-group">
                        <label for="is_correct" class="text-primary">Réponse Correcte :</label>
                        <select name="is_correct" id="is_correct" class="form-control">
                            <option value="">Choisir...</option>
                            <option value="1">Vrai</option>
                            <option value="0">Faux</option>
                        </select>
                    </div>
                    <div id="oppositeAnswer" class="mt-2 text-muted">
                        <p>L'autre réponse sera automatiquement marquée comme incorrecte.</p>
                    </div>
                `;

                // Add event listener for dynamically showing the opposite answer
                additionalFields.innerHTML = fields;

                const selectElement = document.getElementById('is_correct');
                const oppositeAnswerDiv = document.getElementById('oppositeAnswer');

                selectElement.addEventListener('change', () => {
                    const selectedValue = selectElement.value;
                    if (selectedValue === '1') {
                        oppositeAnswerDiv.innerHTML = `<p>Vrai est la bonne réponse, Faux sera incorrect.</p>`;
                    } else if (selectedValue === '0') {
                        oppositeAnswerDiv.innerHTML = `<p>Faux est la bonne réponse, Vrai sera incorrect.</p>`;
                    } else {
                        oppositeAnswerDiv.innerHTML = `<p>L'autre réponse sera automatiquement marquée comme incorrecte.</p>`;
                    }
                });
            } 
            else {
                fields = `<p class="text-danger">Type de question inconnu.</p>`;
            }

            additionalFields.innerHTML = fields;

            if (type === 'QCM') setupQCM();
        }

        // QCM Setup
        function setupQCM() {
            const addOptionButton = document.getElementById('addOption');
            const qcmOptions = document.getElementById('qcm-options');

            addOptionButton.addEventListener('click', () => {
                if (optionCount >= maxOptions) {
                    alert('Vous avez atteint le nombre maximum d\'options.');
                    return;
                }

                optionCount++;
                const optionDiv = document.createElement('div');
                optionDiv.classList.add('form-group');
                optionDiv.innerHTML = `
                    <label for="option_${optionCount}" class="text-primary">Option ${optionCount} :</label>
                    <input type="text" name="content[]" class="form-control mb-2" placeholder="Entrez l'option ${optionCount}">
                    <label>
                        <input type="radio" name="is_correct" value="${optionCount}" class="mr-1"> Correcte
                    </label>
                    <button type="button" class="btn btn-danger btn-sm removeOption">Supprimer</button>
                `;

                qcmOptions.appendChild(optionDiv);

                optionDiv.querySelector('.removeOption').addEventListener('click', () => {
                    qcmOptions.removeChild(optionDiv);
                    optionCount--;
                    updateCorrectOptionValues();
                });
            });
        }

        // Update radio values
        function updateCorrectOptionValues() {
            const radios = document.querySelectorAll('input[name="is_correct"]');
            radios.forEach((radio, index) => {
                radio.value = index + 1;
            });
        }

        // Form Validation
        form.addEventListener('submit', (e) => {
            let isValid = true;
            let errorMessage = '';

            if (questionType === 'QCM') {
                const options = document.querySelectorAll('input[name="content[]"]');
                const isCorrect = document.querySelector('input[name="is_correct"]:checked');

                if (options.length < 2 || !isCorrect) {
                    isValid = false;
                    errorMessage = 'Ajoutez au moins 2 options et sélectionnez une réponse correcte.';
                } else {
                    options.forEach(opt => {
                        if (opt.value.trim() === '') isValid = false;
                    });
                    if (!isValid) errorMessage = 'Toutes les options doivent être remplies.';
                }
            } else if (questionType === 'Réponse Courte') {
                const answerText = document.getElementById('answer_text');
                if (!answerText || answerText.value.trim() === '') {
                    isValid = false;
                    errorMessage = 'Fournissez une réponse correcte.';
                }
            } else if (questionType === 'Vrai/Faux') {
                const isCorrect = document.getElementById('is_correct');
                if (!isCorrect || isCorrect.value === '') {
                    isValid = false;
                    errorMessage = 'Sélectionnez une réponse correcte.';
                }
            }

            if (!isValid) {
                e.preventDefault();
                alert(errorMessage);
            }
        });

        // Initial Rendering
        renderFields(questionType);
    </script>

</body>

</html>