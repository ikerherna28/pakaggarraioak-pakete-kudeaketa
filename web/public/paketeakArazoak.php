<?php
session_start(); // Saioa hasi

// Saioa hasi duen erabiltzailea egiaztatu
if (!isset($_SESSION['user_id'])) {
    header("Location: verify.php");
    exit();
}

// Datu-basearekin konexioa ezarri (balio egokiak aldatu)
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

// Saioa hasi duen erabiltzailearen IDa eskuratu
$user_id = $_SESSION['user_id'];

// Erabiltzailearen "Intzidentziarekin" egoerako paketen informazioa kontsultatu
$sql = "SELECT p.Id_paketea, p.Helbidea, p.Deskribapena, p.Pisua, pi.Id_intzidentzia, pi.Intzidentzia_deskribapena
        FROM Paketeak p
        JOIN Paketeak_Intzidentzia pi ON p.Id_paketea = pi.Id_paketea
        WHERE p.Id_paketea IN (
            SELECT lp.Id_paketea
            FROM Langileak_Paketeak lp
            WHERE lp.Id_langilea = ?)
        AND p.Estado = 'Intzidentziarekin'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$paketeak = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $paketeak[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intzidentziak</title>
    <link rel="stylesheet" href="./styles/paketeak.css">
    <style>
        .incident {
            color: red;
        }
        
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
                    <th>Intzidentziaren ID-a</th>
                    <th>Deskribapena</th>
                    <th>Bidalketa helbidea</th>
                    <th>Pisua</th>
                    <th>Arazoa</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($paketeak) > 0): ?>
                    <?php foreach ($paketeak as $pakete): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pakete['Id_paketea']); ?></td>
                            <td><?php echo htmlspecialchars($pakete['Id_intzidentzia']); ?></td>
                            <td><?php echo htmlspecialchars($pakete['Deskribapena']); ?></td>
                            <td><?php echo htmlspecialchars($pakete['Helbidea']); ?></td>
                            <td><?php echo htmlspecialchars($pakete['Pisua']); ?> kg</td>
                            <td class="incident"><?php echo htmlspecialchars($pakete['Intzidentzia_deskribapena']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Intzidentziarik ez dago.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
