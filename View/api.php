<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gemini Pack Description Generator</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom right, #4e54c8, #8f94fb);
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      height: 100vh;
      color: #fff;
    }

    h1 {
      font-size: 2.5rem;
      margin-bottom: 20px;
      text-align: center;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    form {
      background: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 500px;
      text-align: center;
    }

    label {
      font-size: 1.2rem;
      margin-bottom: 10px;
      display: block;
    }

    input[type="text"] {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: none;
      font-size: 1rem;
      margin-bottom: 15px;
    }

    button {
      background: #4e54c8;
      color: #fff;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #6c6ffa;
    }

    #responseOutput {
      margin-top: 20px;
      background: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      max-width: 500px;
      width: 100%;
      color: #fff;
      text-align: center;
    }

    .back-button {
      margin-top: 20px;
      padding: 10px 15px;
      background-color: #ff6f61;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .back-button:hover {
      background-color: #d04b3e;
    }
  </style>
</head>
<body>
  <h1>Générateur de Description Gemini</h1>
  <form action="" method="POST">
    <label for="inputText">Entrez le nom du pack :</label>
    <input type="text" id="inputText" name="inputText" placeholder="Exemple : Super Pack AI" required>
    <button type="submit">Générer</button>
  </form>

  <div id="responseOutput">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputText = $_POST['inputText'] ?? ''; // Récupère le texte envoyé depuis le formulaire
        if (!empty($inputText)) {
            // Clé API et URL de l'API
            $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=AIzaSyAv64s5nslfAFRUoTkcelrvgdWz_eh3bxo";

            // Préparer le corps de la requête pour une réponse courte
            $requestBody = [
                "contents" => [
                    [
                        "parts" => [
                            ["text" => "Create a short description for the following pack: " . $inputText]
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
                    echo htmlspecialchars($data['candidates'][0]['content']['parts'][0]['text']);
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
  <button class="back-button" onclick="window.location.href='dach.html';">Retour</button>
</body>
</html>