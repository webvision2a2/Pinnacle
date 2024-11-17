<?php
include '../../Controller/UserController.php';
$userController = new UserController();
$userController->deleteUser($_GET["id"]);
header('Location:users.php');
?>