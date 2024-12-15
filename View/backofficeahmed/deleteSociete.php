<?php
require_once '../../Controller/SocieteController.php';
$societeController = new SocieteController();
$societeController->deleteSociete($_GET["id"]);
header('Location:main2.php');
?>
