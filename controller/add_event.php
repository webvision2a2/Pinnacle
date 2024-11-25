<?php
// add_event.php
include '../controller/contolleradmin.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $date = $_POST['event_date'];
    $id = $_POST['id'];

    AddEvent($title, $date, $id);
    header("../view/BackOffice/tables.php");
    exit();
}
?>
