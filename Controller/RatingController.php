<?php
include '../config_zeineb.php';
include_once '../Model/Rating.php';

// Fetch the course ID and rating from the request
$course_id = $_POST['course_id'];
$rating_value = $_POST['rating'];
$user_id = $_POST['user_id'];

// Create an instance of the Rating class and call the function
$rating = new Rating();
$response = $rating->AddOrModifyRating($course_id, $rating_value,$user_id);

//echo $response; // Output the result (success message or error message)


?>