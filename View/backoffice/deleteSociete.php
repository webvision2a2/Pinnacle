<?php
require_once '../../controller/SocieteController.php';
$societeController = new SocieteController();
$societeController->deleteSociete($_GET["id"]);
header('Location:societeList.php');
?>
