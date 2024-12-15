<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Générateur une description</title>

  <!-- Custom fonts for this template-->
  <link href="./backoffice/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="./backoffice/css/sb-admin-2.min.css" rel="stylesheet">

  <style>
    /* Add some custom styles for better appearance */
    body {
      font-family: 'Nunito', sans-serif;
      background-color: #f8f9fc;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 100%;
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      font-size: 2rem;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-control {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ced4da;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #4e73df;
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #2e59d9;
    }

    #responseOutput {
      margin-top: 20px;
      padding: 20px;
      background-color: #e9ecef;
      border-radius: 5px;
      font-size: 1.1rem;
    }

    #generatedText {
      font-weight: bold;
    }

    .back-button {
      margin-top: 20px;
      padding: 12px;
      background-color: #ff6b6b;
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .back-button:hover {
      background-color: #e75f5f;
    }
  </style>
</head>


</head>

<body>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
          <img class="logo" src="../frontOffice_zeineb/Template/img/LOGO white.png" alt="Pinnacle Logo"
            style="max-width: 30px;">
        </div>
        <div class="sidebar-brand-text mx-3" style="font-size: 1.5rem; font-weight: bold;">Pinnacle</div>
      </a>


      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Tableau de Bord</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item - Utilisateurs -->
      <li class="nav-item">
        <a class="nav-link" href="../backOffice_zeineb/users.php">
          <i class="fas fa-fw fa-user"></i>
          <span>Utilisateurs</span>
        </a>
      </li>

      <!-- Nav Item - Catalogue -->
      <li class="nav-item active">
        <a class="nav-link" href="../backoff/dashboard.php">
          <i class="fas fa-fw fa-book"></i>
          <span>Catalogue</span>
        </a>
      </li>

      <!-- Nav Item - Entretien -->
      <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                    aria-controls="collapsePages">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Enretiens</span>
                </a>
                <div id="collapsePages" class="collapse show" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item active" href="../backOfficeChams/listQuiz.php">Quiz</a>
                        <a class="collapse-item" href="../backOfficeChams/listUserQuiz.php">Utilisateurs</a>
                        <a class="collapse-item" href="../backOfficeChams/listFeedback.php">Feedbacks</a>
                    </div>
                </div>
            </li>

      <!-- Nav Item - Ateliers -->
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
          aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Psychologie</span>
        </a>
        <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="topicsList.php">Topics List</a>
            <a class="collapse-item active" href="createTopic.php">Create Topic</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Stages -->
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
          aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Reseaux</span>
        </a>
        <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="../backofficeahmed/main.php">Stages</a>
            <a class="collapse-item" href="../backofficeahmed/main2.php">Societes</a>
          </div>
        </div>
      </li>


      <li class="nav-item">
        <a class="nav-link" href="../BackOffice/tables.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables des evennements</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../BackOffice/events_participants.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables des participants</span></a>
      </li>




      <!-- Spacer to push items to top -->
      <div class="flex-grow-1">

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Se Déconnecter Button -->
        <li class="nav-item">
          <a class="nav-link" href="../frontOffice_zeineb/logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Se Déconnecter</span>
          </a>
        </li>
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


          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">



            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                <img class="img-profile rounded-circle" src="./backoffice/img/undraw_profile.svg">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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


        <h1 class="text-center m-2">Générateur de Description </h1>
        <form action="" method="POST" align="center">
          <br><br>
          <p>Enter un titre</p>

          <div class="form-group text-center">
            <textarea class="form-control form-control-user" id="inputText" name="inputText"
              placeholder="Exemple : Super Pack AI" required
              style="width: 50%; height: 100px; margin: 0 auto;"></textarea>
          </div>

          <button type="submit" class="btn btn-primary btn-user"
            style="width: auto; height: auto; padding: 8px 16px; font-size: 14px; display: block; margin: 20px auto;">Générer</button>

        </form>

        <div id="responseOutput">
          <?php
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputText = $_POST['inputText'] ?? ''; // Récupère le texte envoyé depuis le formulaire
            if (!empty($inputText)) {
              // Clé API et URL de l'API
              $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=AIzaSyAv64s5nslfAFRUoTkcelrvgdWz_eh3bxo";

              // Préparer le corps de la requête pour une réponse en français
              $requestBody = [
                "contents" => [
                  [
                    "parts" => [
                      ["text" => "Créer une description courte pour le pack suivant en français : " . $inputText]
                    ]
                  ]
                ]
              ];

              // Initialiser cURL
              $ch = curl_init($apiUrl);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json"
              ]);
              curl_setopt($ch, CURLOPT_POST, true);
              curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));

              // Exécuter la requête et récupérer la réponse
              $response = curl_exec($ch);

              if ($response === false) {
                echo "Erreur cURL : " . curl_error($ch);
              } else {
                // Traiter la réponse API
                $data = json_decode($response, true);

                // Vérifier si la réponse contient le texte généré
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                  $generatedText = $data['candidates'][0]['content']['parts'][0]['text'];
                  echo "<p id='generatedText'>" . htmlspecialchars($generatedText) . "</p>";
                  echo "<button onclick='copyToClipboard()' style='width: auto; height: auto; padding: 8px 16px; font-size: 14px; display: block; '>Copier le texte</button>";

                } else {
                  echo "Erreur : Réponse inattendue de l'API.";
                }
              }
              curl_close($ch);
            } else {
              echo "Erreur : aucun texte fourni.";
            }
          } else {
            echo "Aucune description générée pour l'instant...";
          }
          ?>
        </div>

        <!-- Bouton retour -->

        <button class="btn btn-primary btn-user" onclick="window.location.href='createTopic.php';"
          style="width: auto; height: auto; padding: 8px 16px; font-size: 14px; display: block; margin: 20px auto;">Retour</button>


        <script>
          function copyToClipboard() {
            const text = document.getElementById('generatedText').innerText;
            navigator.clipboard.writeText(text)
              .then(() => {
                alert('Texte copié dans le presse-papiers !');
              })
              .catch(err => {
                alert('Erreur lors de la copie : ' + err);
              });
          }
        </script>
      </div>
</body>


</html>