<?php
include_once '../../Controller/feedbackController.php';
include_once '../../Model/feedback.php';

// Get feedback ID from the URL
$id = $_GET['id'];

// Create a new FeedbackController instance
$controller = new FeedbackController();

// Delete feedback
$controller->deleteFeedback($id);

// Redirect to feedback listing page
header('Location: feedbacks.php');
exit;