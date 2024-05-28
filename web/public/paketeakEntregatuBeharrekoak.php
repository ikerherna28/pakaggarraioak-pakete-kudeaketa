<?php
session_start(); // Saioa hasi

// Saioa hasi duen edo ez aztertu
if (!isset($_SESSION['user_id'])) {
    header("Location: verify.php");
    exit();
}

// Datu-basearekin konexioa ezarri (balio egokiak ordezkatu)
$host = "mysql";
$username = "root";
$password = "root";
$database = "webapp";

// Datu-basearekin konexioa
$conn = new mysqli($host, $username, $password, $database);

// Konexioa egiaztatu
if ($conn->connect_error) {
    die("Konexio errorea: " . $conn->connect_error);
}

// Saioa hasi den erabiltzailearen 'Prozesuan' egoerako paketeak lortzeko SQL kontsulta
$user_id = $_SESSION['user_id'];
$sql = "SELECT p.Id_paketea, p.Deskribapena, p.Helbidea, p.Pisua, p.Estado
        FROM Paketeak p
        INNER JOIN Langileak_Paketeak lp ON p.Id_paketea = lp.Id_paketea
        WHERE lp.Id_langilea = $user_id AND p.Estado = 'Prozesuan'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entregatzeko</title>
    <link rel="stylesheet" href="./styles/paketeakEntregatuBeharrekoak.css">
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
    <a href="index.php" class="logout-btn">SAIOA ITXI</a>
    
</div>
<div class="main-content">
    <div class="header">
        <img src="./img/Logoa.png" alt="Enpresaren Logotipoa">
        <div>Erabiltzailea: <span id="username"><?php echo htmlspecialchars($_SESSION['user_name'] . ' ' . $_SESSION['user_surname']); ?></span></div>
    </div>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>Paketearen ID-a</th>
                <th>Deskribapena</th>
                <th>Bidalketako Helbidea</th>
                <th>Pisua</th>
                <th>Intzidentzia</th>
                <th>Entregatua</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Emaitzak aurkitu diren edo ez aztertu
            if ($result->num_rows > 0) {
                // Datuak taulan erakutsi
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Id_paketea'] . "</td>";
                    echo "<td>" . $row['Deskribapena'] . "</td>";
                    echo "<td>" . $row['Helbidea'] . "</td>";
                    echo "<td>" . $row['Pisua'] . "</td>";
                    echo "<td><button onclick=\"toggleIncidentForm('".$row['Id_paketea']."')\">Gehitu</button></td>";
                    echo "<td><input type=\"checkbox\" onchange=\"updatePackageStatus('".$row['Id_paketea']."')\"> Entregatua</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Ez da paketerik aurkitu erabiltzaile honentzat 'Prozesuan' egoeran.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="incident-form" id="incident-form" style="display:none;">
        <h3>Intzidentzia Gehitu</h3>
        <form action="add_incident.php" method="POST">
            <input type="hidden" name="package_id" id="package_id">
            <label for="incident-description">Intzidentziaren Deskribapena:</label>
            <textarea id="incident-description" name="incident_description" rows="4"></textarea>
            <button type="submit">Intzidentzia Bidali</button>
        </form>
    </div>
</div>

<div class="overlay" id="overlay"></div>
<div class="confirmation-box" id="confirmation-box" style="display:none;">
    <h3 id="package-id"></h3>
    <h3>Ondo entregatu al da paketea?</h3>
    <h4>Gorabeheraren bat izan baduzu, gogoratu idatzi behar duzula.</h4>
    <p>"Bai" botoia sakatuz gero, ezin izango duzu paketearen entrega bertan behera utzi.</p>
    <form action="update_package_status.php" method="POST" id="confirmation-form">
        <input type="hidden" name="package_id" id="delivery-package-id">
        <input type="hidden" name="delivery" value="1">
        <button type="button" class="yes" onclick="confirmDelivery()">BAI</button>

    </form>
    <button class="no" onclick="cancelDelivery()">EZ</button>
</div>
<script src="./js/paketeakEntregatuBeharrekoak.js"></script>
</body>
</html>
