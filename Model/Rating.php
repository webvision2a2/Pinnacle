<?php
require_once __DIR__ . '/../config_zeineb.php';

class Rating {
    

    // Ajouter un rating pour un cours
    public function AddOrModifyRating($course_id, $rating,$user_id) {
        $db = config::getConnexion();
        // Check if the user has already rated the course
        $sql = "SELECT rating FROM ratings WHERE cours_id = :cours_id AND user_id = :user_id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':cours_id' => $course_id, ':user_id' => $user_id]);
        $existingRating = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingRating) {
            // Update existing rating
            $sql = "UPDATE ratings SET rating = :rating WHERE cours_id = :cours_id AND user_id = :user_id";
        } else {
            // Add new rating
            $sql = "INSERT INTO ratings (cours_id, user_id, rating) VALUES (:cours_id, :user_id, :rating)";
        }

        $stmt = $db->prepare($sql);
        $stmt->execute([':cours_id' => $course_id, ':user_id' => $user_id, ':rating' => $rating]);

        return json_encode(["status" => "success", "rating" => $rating]);
    }

    // Obtenir la moyenne des ratings pour un cours
    public function getAverageRating(int $domainId): ?float {
        $db = config::getConnexion();
        $sqlGetCoursIds = "SELECT id_cours FROM cours WHERE domaine_id = :domain_id";
        $stmtCoursIds = $db->prepare($sqlGetCoursIds);
        $stmtCoursIds->execute([':domain_id' => $domainId]);
        $coursIds = $stmtCoursIds->fetchAll(PDO::FETCH_COLUMN);

        if (empty($coursIds)) {
            return 0; // No courses found for the domain
        }

    // Get the average rating across all these courses
        $sql = "SELECT AVG(rating) as average FROM ratings WHERE cours_id IN (" . implode(',', $coursIds) . ")";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['average'] ?? 0;
    }
    public function getRatingForCourse($course_id) {
        $db = config::getConnexion();
        $stmt = $db->prepare("SELECT AVG(rating) AS average FROM ratings WHERE course_id = ?");
        $stmt->execute([$course_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getUserCourseRating($user_id, $course_id){
        $db = config::getConnexion();
        $sql = "SELECT rating FROM ratings WHERE cours_id = :cours_id AND user_id = :user_id";
        $stmtCoursIds = $db->prepare($sql);
        $stmtCoursIds->execute([':cours_id' => $course_id, ':user_id' => $user_id]);
        $rating = 0;
        if ($stmtCoursIds->rowCount() > 0) {
            $rating = $stmtCoursIds->fetchColumn();
        }
        return $rating;
    }
  
}
?>
