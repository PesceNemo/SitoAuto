<?php
session_start();

$conn = new mysqli("192.168.60.144", "noemi_basaglia", "incenerisci.stradello.", "noemi_basaglia_auto");

if ($conn->connect_error) {
    die("Errore connessione");
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
        $errore = "Credenziali errate!";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            background: #ffffff;
            width: 400px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            color: #333;
        }

        p {
            text-align: center;
            margin-bottom: 20px;
            color: #444;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #4a90e2;
        }

        input[type="submit"], button {
            width: 100%;
            padding: 10px;
            background: #4a90e2;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 14px;
            cursor: pointer;
            transition: 0.2s;
        }

        input[type="submit"]:hover, button:hover {
            background: #357abd;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #4a90e2;
            text-decoration: none;
            font-size: 14px;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>

</head>
<body>

<div class="card">

    <h2>Login</h2>

    <?php if(isset($errore)) echo "<div class='error'>$errore</div>"; ?>

    <form method="POST">

        Username
        <input type="text" name="User" required>

        Password
        <input type="password" name="PW" required>

        <input type="submit" value="Accedi">

    </form>

    <a href="Register.php">Non hai un account? Registrati</a>

</div>

</body>
</html>
