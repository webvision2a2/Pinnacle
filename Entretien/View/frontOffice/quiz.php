<?php
include '../../Controller/quizController.php'; // Include quiz controller

$controller = new QuizController();

// Define the number of quizzes per page
$quizzes_per_page = 4;

// Get the current page number from the URL, default to 1
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Get the selected category from the URL, default to null (no filter)
$selected_category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : null;

// Calculate the total number of quizzes for the selected category
$total_quizzes = $controller->countQuizzesByCategory($selected_category); // Updated method to count quizzes based on category
$total_pages = ceil($total_quizzes / $quizzes_per_page);

// Ensure the current page is within valid bounds
if ($current_page > $total_pages && $total_pages > 0) {
    $current_page = $total_pages;
}

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $quizzes_per_page;

// Fetch quizzes for the current page and category
$quizzes = $controller->listQuizzesByCategoryPaginated($selected_category, $quizzes_per_page, $offset); // Updated method
?>
<!DOCTYPE html>
<html lang="fr">
<head>
 <!-- Favicon -->
    <link href="template/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="template/lib/animate/animate.min.css" rel="stylesheet">
    <link href="template/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="template/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="template/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="template/css/style.css" rel="stylesheet">
    <style>
       .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            margin: 20px 0;
            padding: 0;
            font-family: 'Jost', sans-serif;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-link {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            color: var(--dark);
            background-color: var(--light);
            border: 1px solid var(--primary);
            border-radius: 50%;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
        }

        .pagination .page-link:hover {
            color: #fff;
            background-color: var(--primary);
            transform: scale(1.1);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--secondary);
            color: #fff;
            font-weight: 700;
            border-color: var(--secondary);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            pointer-events: none;
        }

        .pagination .page-link.disabled {
            color: #ccc;
            cursor: not-allowed;
            background-color: var(--light);
            border-color: #ddd;
        }

        .pagination .page-link:first-child,
        .pagination .page-link:last-child {
            border-radius: 50%;
            font-size: 18px;
        }

        .pagination .page-link:first-child:hover,
        .pagination .page-link:last-child:hover {
            transform: translateY(-2px);
        }

        /* Add focus outline for accessibility */
        .pagination .page-link:focus {
            outline: 3px solid var(--secondary);
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .pagination .page-link {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }
        }



    </style>

</head>
<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" >
               <!-- <span class="sr-only">Loading...</span>  -->
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <img class ='logo' src="template/img/LOGO 1 blue.png">
                    <h1 class="m-0">Pinnacle</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="#" class="nav-item nav-link">Acceuil</a>
                        <a href="#" class="nav-item nav-link">à Propos</a>
                        <a href="#" class="nav-item nav-link">Evènements</a>
                        <a href="quiz.php" class="nav-item nav-link active">Quiz</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Cours</a>
                            <div class="dropdown-menu m-0">
                                <a href="#" class="dropdown-item">Cours (Modules)</a>
                                <a href="#" class="dropdown-item">Videos</a>
                                <a href="#" class="dropdown-item">Ateliers</a>
                            </div>
                        </div>
                        <a href="#" class="nav-item nav-link">Contact</a>
                    </div>
                    <a href="#" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Commencer</a>
                </div>
            </nav>

        <div class="container-xxl bg-primary hero-header">
            <div class="container px-lg-5">
                <div class="row g-5 align-items-end">
                   <!--   <h1 class="text-white mb-4 animated slideInDown" >Welcome to the quiz</h1>    -->
                     
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->
    <!-- Quiz Section -->

    <!-- Filter Form -->
    <form method="GET" class="mb-4 text-center">
                <label for="category" class="me-2">Filtrer par Catégorie:</label>
                <select name="category" id="category" class="form-select d-inline-block w-auto">
                    <option value="">Toutes les catégories</option>
                    <?php
                    // Assume $controller->listCategories() returns all unique categories
                    $categories = $controller->listCategories();
                    foreach ($categories as $category):
                    ?>
                        <option value="<?= htmlspecialchars($category['name']) ?>" <?= $selected_category === $category['name'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary ms-2">Appliquer</button>
            </form>
    <div class="container my-5">
    <h1 class="text-center text-primary fw-bold mb-4">Les Quizzes Disponibles</h1>
    
        <div class="row">
            <?php foreach ($quizzes as $quiz): ?>
                <div class="col-md-6 mb-4">
                    <div class="service-item border rounded shadow-sm p-4 bg-white">
                        <!-- Title -->
                        <h3 class="fw-semi-bold text-secondary"><?= htmlspecialchars($quiz['title']) ?></h3>
                        <!-- Description -->
                        <p class="text-muted"><?= htmlspecialchars($quiz['description']) ?></p>
                        <!-- Author and Date -->
                        <small class="d-block mb-3">
                            Fait par <span class="text-primary"><?= htmlspecialchars($quiz['author']) ?></span> 
                            le <span class="text-secondary"><?= htmlspecialchars($quiz['creation_date']) ?></span>
                        </small>
                        <!-- Quiz Details -->
                        <ul class="list-unstyled">
                            <li><strong class="text-primary">Durée:</strong> <span class="text-dark"><?= htmlspecialchars($quiz['time_limit']) ?> minutes</span></li>
                            <li><strong class="text-primary">Difficulté:</strong> <span class="text-dark"><?= htmlspecialchars($quiz['difficulty']) ?></span></li>
                            <li><strong class="text-primary">Catégorie:</strong> <span class="text-dark"><?= htmlspecialchars($quiz['category']) ?></span></li>
                            <li><strong class="text-primary">Nombre de Questions:</strong> <span class="text-dark"><?= htmlspecialchars($quiz['total_questions']) ?></span></li>
                        </ul>

                        <!-- Button -->
                        <a class="btn" href="question.php?id=<?= $quiz['id'] ?>">Commencer Quiz</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Pagination -->
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php if ($current_page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $current_page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Précédent</span>
                    </a>
                </li>
            <?php endif; ?>
                    
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
                    
            <?php if ($current_page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $current_page + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Suivant</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
 
      <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="template/lib/wow/wow.min.js"></script>
    <script src="template/lib/easing/easing.min.js"></script>
    <script src="template/lib/waypoints/waypoints.min.js"></script>
    <script src="template/lib/counterup/counterup.min.js"></script>
    <script src="template/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="template/lib/isotope/isotope.pkgd.min.js"></script>
    <script src="template/lib/lightbox/js/lightbox.min.js"></script>
    
    <script src="template/js/main.js"></script>
    
</body>
</html>