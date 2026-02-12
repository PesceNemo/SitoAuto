<?php
session_start();

$conn = new mysqli("192.168.60.144", "noemi_basaglia", "incenerisci.stradello.", "noemi_basaglia_auto");

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
} else {
    echo "Connessione al database riuscita!<br><br>";
}

if(isset($_POST["User"]) && isset($_POST["PW"])) {

    $username = $_POST["User"];
    $password = $_POST["PW"];

    $stmt = $conn->prepare("SELECT * FROM Utenti WHERE User = ? AND PW = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows === 1) {

        $_SESSION["User"] = $username;
        header("Location: home.php");
        exit();

    } else {
        echo "Credenziali errate";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<form method="POST">
    <input type="text" name="User" placeholder="Username" required><br><br>
    <input type="password" name="PW" placeholder="Password" required><br><br>
    <button type="submit">Accedi</button>
</form>

</body>
</html>
