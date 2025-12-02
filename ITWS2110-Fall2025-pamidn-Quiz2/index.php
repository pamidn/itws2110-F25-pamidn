<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}
?>

<h2>Welcome!</h2>
<a href="project.php">Add a Project</a> | 
<a href="viewProjects.php">View Projects</a> | 
<a href="logout.php">Logout</a>
