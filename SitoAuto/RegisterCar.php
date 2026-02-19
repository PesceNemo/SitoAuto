<?php session_start();
if(!isset($_SESSION["User"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("192.168.60.144", "noemi_basaglia", "incenerisci.stradello.", "noemi_basaglia_auto");
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
if(isset($_POST["Marca"]) && isset($_POST["Modello"]) && isset($_POST["Cilindrata"]) && isset($_POST["Potenza"]) && isset($_POST["Lunghezza"]) && isset($_POST["Larghezza"])) {
    $marca = $_POST["Marca"];
    $modello = $_POST["Modello"];
    $cilindrata = $_POST["Cilindrata"];
    $potenza = $_POST["Potenza"];
    $lunghezza = $_POST["Lunghezza"];
    $larghezza = $_POST["Larghezza"];
    $proprietario = $_SESSION["User"]; // <- qui il proprietario è l'utente loggato

    $stmt = $conn->prepare("INSERT INTO Auto (Marca, Modello, Cilindrata, Potenza, Lunghezza, Larghezza, Proprietario) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiiis", $marca, $modello, $cilindrata, $potenza, $lunghezza, $larghezza, $proprietario );

    if($stmt->execute()) {
        $messaggio = "Auto registrata con successo!";
    } else {
        $messaggio = "Errore durante l'inserimento";
    }
}

?>



<<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registra Auto</title>
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

    <h2>Registra Auto</h2>

    <?php
    if(isset($messaggio)) {
        $classe = ($messaggio == "Auto registrata con successo!") ? "success" : "error";
        echo "<div class='$classe'>$messaggio</div>";
    }
    ?>

    <form method="POST">

        Marca
        <input type="text" name="Marca" required>

        Modello
        <input type="text" name="Modello" required>

        Cilindrata (cc)
        <input type="number" name="Cilindrata" required>

        Potenza (CV)
        <input type="number" name="Potenza" required>

        Lunghezza (mm)
        <input type="number" name="Lunghezza" required>

        Larghezza (mm)
        <input type="number" name="Larghezza" required>


        <input type="submit" value="Salva Auto">

    </form>

    <a href="home.php">Torna alla Home</a>

</div>

</body>
</html>
