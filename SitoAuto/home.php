<?php
session_start();

// Se non sei loggato → login
if(!isset($_SESSION["User"])) {
    header("Location: login.php");
    exit();
}

// Logout
if(isset($_GET["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$conn = new mysqli("192.168.60.144", "noemi_basaglia", "incenerisci.stradello.", "noemi_basaglia_auto");
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$utente = $_SESSION["User"];

// Prendi tutte le auto dell'utente
$stmt = $conn->prepare("SELECT Marca, Modello, Cilindrata, Potenza, Lunghezza, Larghezza FROM Auto WHERE Proprietario = ?");
$stmt->bind_param("s", $utente);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <style>
        * { box-sizing:border-box; margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; }
        body { background:#f4f6f9; display:flex; flex-direction:column; align-items:center; padding:40px 0; }

        /* CARD PRINCIPALE */
        .card {
            background: #fff;
            width: 400px;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            display:flex;
            flex-direction:column;
            align-items:center;
            margin-bottom: 30px;
        }

        h2 { text-align:center; margin-bottom:20px; font-weight:600; color:#333; }
        p { text-align:center; margin-bottom:20px; color:#444; font-size:15px; }

        input[type="text"], input[type="password"], input[type="number"] {
            width: 100%; padding:10px; margin-top:5px; margin-bottom:15px; border:1px solid #ddd; border-radius:6px; font-size:14px;
        }
        input:focus { outline:none; border-color:#4a90e2; }

        input[type="submit"], button {
            width: 100%; padding:10px; background:#4a90e2; border:none; border-radius:6px; color:white; font-size:14px; cursor:pointer; transition:0.2s; margin-top:10px;
        }
        input[type="submit"]:hover, button:hover { background:#357abd; }

        a { display:block; text-align:center; margin-top:10px; color:#4a90e2; text-decoration:none; font-size:14px; }
        a:hover { text-decoration:underline; }

        .error { color:red; text-align:center; margin-bottom:15px; font-size:14px; }
        .success { color:green; text-align:center; margin-bottom:15px; font-size:14px; }

        /* RIQUADRO AUTO */
        .auto-card {
            background:#fff;
            width:800px;
            padding:20px 30px;
            border-radius:10px;
            box-shadow:0 10px 25px rgba(0,0,0,0.08);
        }
        .auto-card h2 { margin-bottom:15px; }
        .auto-card table { width:100%; border-collapse:collapse; }
        .auto-card th, .auto-card td { border:1px solid #ddd; padding:8px; text-align:center; font-size:14px; }
        .auto-card th { background:#4a90e2; color:white; }
        .auto-card tr:nth-child(even) { background:#f9f9f9; }
        .no-auto { text-align:center; color:#555; padding:15px; }
    </style>
</head>
<body>

<div class="card">
    <h2>Home</h2>

    <p>Benvenuto <strong><?php echo $utente; ?></strong></p>

    <a href="RegisterCar.php"><button>Registra Auto</button></a>

    <form method="get">
        <input type="hidden" name="logout" value="true">
        <input type="submit" value="Logout">
    </form>
</div>

<!-- Riquadro lista auto -->
<div class="auto-card">
    <h2>Le tue Auto</h2>
    <table>
        <tr>
            <th>Marca</th>
            <th>Modello</th>
            <th>Cilindrata (cc)</th>
            <th>Potenza (CV)</th>
            <th>Lunghezza (mm)</th>
            <th>Larghezza (mm)</th>
        </tr>

        <?php
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Marca']}</td>
                        <td>{$row['Modello']}</td>
                        <td>{$row['Cilindrata']}</td>
                        <td>{$row['Potenza']}</td>
                        <td>{$row['Lunghezza']}</td>
                        <td>{$row['Larghezza']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='no-auto'>Non hai auto registrate</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
