<?php 
function addDomaines($nom, $description, $competence, $image)
{
    if (domaineNameExists($nom)) {
        return false; // Domain name already exists
    }

    $db = config::getConnexion();

    $stmt = $db->prepare("INSERT INTO domaines (nom, description, competence, image) VALUES (:nom, :description, :competence, :image)");

    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':competence', $competence);
    $stmt->bindParam(':image', $image);

    return $stmt->execute();
}
function deleteDomaines($id)
{
    $db = config::getConnexion();

    $stmt = $db->prepare("DELETE FROM domaines WHERE id = :id");

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
}

function readDomaines($page = 1, $itemsPerPage = 4) {
    $db = config::getConnexion();

    if (!$db) {
        return [];
    }

    $offset = ($page - 1) * $itemsPerPage;
    $stmt = $db->prepare("SELECT * FROM domaines LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $itemsPerPage, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalDomaines() {
    $db = config::getConnexion();

    if (!$db) {
        return 0;
    }

    return $db->query("SELECT COUNT(*) FROM domaines")->fetchColumn();
}
function getDomaineById($id)
{
    $db = config::getConnexion();

    if (!$db) {
        return "Database connection failed.";
    }

    $stmt = $db->prepare("SELECT * FROM domaines WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        return null;
    }
}

function updateDomaines($id, $nom, $description, $competence, $image = null)
{
    $db = config::getConnexion();

    if (!$db) {
        return "Database connection failed.";
    }

    if ($image !== null) {
        // Update query with image
        $stmt = $db->prepare("UPDATE domaines SET nom = :nom, description = :description, competence = :competence, image = :image WHERE id = :id");
        // Bind parameters
        $stmt->bindParam(':image', $image);
    } else {
        // Update query without image
        $stmt = $db->prepare("UPDATE domaines SET nom = :nom, description = :description, competence = :competence WHERE id = :id");
    }

    // Bind remaining parameters and execute the statement
    if ($stmt) {
        // Bind parameters
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':competence', $competence);

        // Bind ID
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    } else {
        return "Failed to prepare SQL statement.";
    }
}


function addCours($domaine_id, $nom, $fichier)
{
    $db = config::getConnexion();

    $stmt = $db->prepare("INSERT INTO cours (domaine_id, nom, fichier) VALUES (:domaine_id, :nom, :fichier)");
    $stmt->bindParam(':domaine_id', $domaine_id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':fichier', $fichier);

    return $stmt->execute();
}
function deleteCours($id_cours)
{
    $db = config::getConnexion();

    $stmt = $db->prepare("DELETE FROM cours WHERE id_cours = :id_cours");
    $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);

    return $stmt->execute();
}
// Remove this function from catalogue.php
function getCoursByDomaineId($domaineId)
{
    $db = config::getConnexion();

    $stmt = $db->prepare("SELECT * FROM cours WHERE domaine_id = :domaine_id");
    $stmt->bindParam(':domaine_id', $domaineId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return [];
    }
}
function readCours($page = 1, $itemsPerPage = 4) {
    $db = config::getConnexion();

    $offset = ($page - 1) * $itemsPerPage;
    $stmt = $db->prepare("SELECT * FROM cours LIMIT :offset, :itemsPerPage");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCoursById($id_cours)
{
    $db = config::getConnexion();

    $stmt = $db->prepare("SELECT * FROM cours WHERE id_cours = :id_cours");
    $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateCours($id_cours, $domaine_id, $nom, $fichier)
{
    $db = config::getConnexion();

    $stmt = $db->prepare("UPDATE cours SET domaine_id = :domaine_id, nom = :nom, fichier = :fichier WHERE id_cours = :id_cours");
    $stmt->bindParam(':domaine_id', $domaine_id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':fichier', $fichier);
    $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);

    return $stmt->execute();
}
function searchCours($query) {
    $db = config::getConnexion();

    $stmt = $db->prepare("SELECT * FROM cours WHERE nom LIKE :query");
    $searchTerm = "%" . $query . "%";
    $stmt->bindParam(':query', $searchTerm);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalCours() {
    $db = config::getConnexion();
    $stmt = $db->query("SELECT COUNT(*) FROM cours");
    return $stmt->fetchColumn();
}

function getAllDomaines() {
    global $conn; // Use the global $conn variable

    $query = "SELECT * FROM domaines";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function domaineNameExists($nom)
{
    $db = config::getConnexion();

    $stmt = $db->prepare("SELECT COUNT(*) FROM domaines WHERE nom = :nom");
    $stmt->bindParam(':nom', $nom);
    $stmt->execute();
    return (bool)$stmt->fetchColumn();
}
// Function to get the total number of courses
function getTotalCourses() {
    // Assume you have a database connection established
    global $db; // Your database connection
    $query = "SELECT COUNT(*) as total FROM courses"; // Adjust the table name as necessary
    $result = $db->query($query);
    return $result->fetch_assoc()['total'];
}

// Function to get the number of courses per domain
function getCoursesPerDomaine() {
    global $db;
    $query = "SELECT domaine.nom, COUNT(courses.id) as count 
              FROM courses 
              JOIN domaine ON courses.domaine_id = domaine.id 
              GROUP BY domaine.nom"; // Adjust table names as necessary
    $result = $db->query($query);
    $coursesPerDomaine = [];
    while ($row = $result->fetch_assoc()) {
        $coursesPerDomaine[$row['nom']] = $row['count'];
    }
    return $coursesPerDomaine;
}

function getCoursesPerDomain() {
    global $pdo;
    
    $sql = "SELECT d.nom as domain_name, COUNT(c.id_cours) as course_count
            FROM domaines d
            LEFT JOIN cours c ON d.id = c.domaine_id
            GROUP BY d.id, d.nom";
    
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
} 
function getLatestDomaine() {
    $db = config::getConnexion();

    $stmt = $db->query("SELECT * FROM domaines ORDER BY id DESC LIMIT 1");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getStatistics() {
    $db = config::getConnexion();

    try {
        // Get total domains and courses
        $totalDomaines = getTotalDomaines();
        $totalCours = getTotalCours();

        // Get most active domain
        $stmt = $db->query("
            SELECT d.nom as domain_name, COUNT(c.id_cours) as course_count
            FROM domaines d
            LEFT JOIN cours c ON d.id = c.domaine_id
            GROUP BY d.id, d.nom
            ORDER BY course_count DESC
            LIMIT 1
        ");
        $mostActiveDomain = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get latest domain
        $latestDomaine = getLatestDomaine();

        return [
            'totalDomaines' => $totalDomaines,
            'totalCours' => $totalCours,
            'averageCoursPerDomain' => $totalDomaines > 0 ? round($totalCours / $totalDomaines, 1) : 0,
            'mostActiveDomain' => $mostActiveDomain,
            'latestDomaine' => $latestDomaine
        ];
    } catch (PDOException $e) {
        // Handle any database errors
        error_log("Database Error: " . $e->getMessage());
        return [
            'totalDomaines' => 0,
            'totalCours' => 0,
            'averageCoursPerDomain' => 0,
            'mostActiveDomain' => null,
            'latestDomaine' => null
        ];
    }
}