<?php
session_start();

// Se non è loggato torna al login
if(!isset($_SESSION["User"])) {
    header("Location: login.php");
    exit();
}

// Logout semplice
if(isset($_GET["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>

<h1>Login riuscito!</h1>

<p>Benvenuto <strong><?php echo $_SESSION["User"]; ?></strong></p>

<br>

<a href="home.php?logout=true">
    <button>Logout</button>
</a>

</body>
</html>
