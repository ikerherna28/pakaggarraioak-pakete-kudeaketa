<?php
session_start(); // Saioa hasi

// Erabiltzailea saioa hasi duen egiaztatu
if (!isset($_SESSION['user_id'])) {
    header("Location: verify.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historikoa</title>
    <link rel="stylesheet" href="./styles/paketeakHistorikoa.css">
    <style>
        /* Estiloa botoiarentzako */
        .logout-btn {
            border: 3px solid black;
            margin-top: 425px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Pakete Kudeaketa</h2>
            <a href="paketeakHasiera.php">Hasiera</a>
            <a href="paketeakEntregatuBeharrekoak.php">Entregatzeko</a>
            <a href="paketeakArazoak.php">Intzidentziak</a>
            <a href="paketeakHistorikoa.php">Historikoa</a><br><br>
            <a href="perfila.php">Perfila</a>
            <!-- Saioa itxi botoia -->
            <a href="index.php" class="logout-btn">SAIOA ITXI</a>
        </div>
    <div class="main-content">
        <div class="header">
            <img src="./img/Logoa.png" alt="Enpresaren Logotipoa">
            <div>Erabiltzailea: <span id="username"><?php echo htmlspecialchars($_SESSION['user_name'] . ' ' . $_SESSION['user_surname']); ?></span></div>
        </div>
            <h1>Paketeen Historia</h1>
            
            <h2>Intzidentziadun Paketeak</h2>
            <table id="incidence-packages">
                <thead>
                    <tr>
                        <th>Paketearen ID-a</th>
                        <th>Deskribapena</th>
                        <th>Neurriak</th>
                        <th>Intzidentziaren ID-a</th>
                        <th>Intzidentzia</th>
                        <th>Intzidentziaren Data</th>
                        <th>Intzidentzia Konponduta</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Hemen paketeak dinamikoki kargatuko dira intzidentziarekin -->
                </tbody>
            </table>

            <br><h2>Intzidentziarik Gabeko Paketeak</h2>
            <table id="no-incidence-packages">
                <thead>
                    <tr>
                        <th>Paketearen ID-a</th>
                        <th>Deskribapena</th>
                        <th>Neurriak</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Hemen paketeak dinamikoki kargatuko dira intzidentziarik gabe -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="./js/paketeakHistorikoa.js"></script>
</body>
</html>
