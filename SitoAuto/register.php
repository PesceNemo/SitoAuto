<?php
session_start();

$conn = new mysqli("192.168.60.144", "noemi_basaglia", "incenerisci.stradello.", "noemi_basaglia_auto");

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Controllo invio form
if(isset($_POST["ID"]) && isset($_POST["User"]) && isset($_POST["PW"])) {

    $id = $_POST["ID"];
    $username = $_POST["User"];
    $password = $_POST["PW"];

    // Inserimento nel database
    $stmt = $conn->prepare("INSERT INTO Utenti (ID, User, PW) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $id, $username, $password);

    if($stmt->execute()) {
        echo "Utente registrato con successo!<br>";
        echo "<a href='login.php'>Vai al login</a>";
    } else {
        echo "Errore durante la registrazione: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione</title>
</head>
<body>

<h2>Registrazione utente</h2>

<form method="POST">
    <label>ID:</label><br>
    <input type="number" name="ID" required><br><br>

    <label>Username:</label><br>
    <input type="text" name="User" required><br><br>

    <label>Password:</label><br>
    <input type="text" name="PW" required><br><br>

    <button type="submit">Registrati</button>
</form>

</body>
</html>
