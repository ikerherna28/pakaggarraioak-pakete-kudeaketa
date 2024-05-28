<?php
session_start(); // Saioa hasi

// Saioa hasi duen ala ez egiaztatu
if (!isset($_SESSION['user_id'])) {
    header("Location: verify.php");
    exit();
}

// Erabiltzailearen datuak sesioan gordeta dauden ala ez egiaztatu eta beraien existentzia egiaztatu
$izena = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
$lehenengo_abizena = isset($_SESSION['user_surname']) ? $_SESSION['user_surname'] : '';
$bigarren_abizena = isset($_SESSION['user_second_surname']) ? $_SESSION['user_second_surname'] : ''; // Bigarren abizena
$posta = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
$telefonoa = isset($_SESSION['user_phone']) ? $_SESSION['user_phone'] : '';
$nan = isset($_SESSION['user_nid']) ? $_SESSION['user_nid'] : ''; // NAN kodea
$jaiotze_data = isset($_SESSION['user_birthdate']) ? $_SESSION['user_birthdate'] : ''; // Jaiotze data
$helbidea = isset($_SESSION['user_address']) ? $_SESSION['user_address'] : ''; // Helbidea
$herria = isset($_SESSION['user_city']) ? $_SESSION['user_city'] : ''; // Herria
$posta_kodea = isset($_SESSION['user_zip']) ? $_SESSION['user_zip'] : ''; // Posta kodea

$profile_image_url = "https://randomuser.me/api/portraits/men/" . rand(1, 99) . ".jpg";
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erabiltzaile informazioa</title>
    <link rel="stylesheet" href="./styles/perfila.css"> 
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
        <div><i>Langile kodea: </i><?php echo substr($nan, -4); ?></div>
    </div>
    <div class="profile-card">
        <img src="<?php echo htmlspecialchars($profile_image_url); ?>" alt="Perfilaren argazkia">
        <h1><?php echo htmlspecialchars($izena) . " " . htmlspecialchars($lehenengo_abizena) . " " . htmlspecialchars($bigarren_abizena); ?></h1>
        <h3><?php echo htmlspecialchars($posta); ?></h3>
        <h4><strong>+34 </strong><?php echo htmlspecialchars($telefonoa); ?></h4><br>
        <div class="info">
            <p><strong>NAN:</strong> <?php echo htmlspecialchars($nan); ?></p>        
            <p><strong>Jaiotze data:</strong> <?php echo htmlspecialchars($jaiotze_data); ?></p><br>
            <p><strong>Langile mota:</strong> Banatzailea</p><br>
            <p><strong>Helbidea:</strong> <?php echo htmlspecialchars($helbidea); ?></p>
            <p><strong>Herria:</strong> <?php echo htmlspecialchars($herria); ?></p>
            <p><strong>Posta Kodea:</strong> <?php echo htmlspecialchars($posta_kodea); ?></p>
        </div>
    </div>
</div>
</body>
</html>

