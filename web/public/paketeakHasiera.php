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

// Saioa hasi den erabiltzailearen paketeak lortzeko SQL kontsulta
$user_id = $_SESSION['user_id'];
$sql = "SELECT p.Id_paketea, p.Helbidea, p.Estado
        FROM Paketeak p
        INNER JOIN Langileak_Paketeak lp ON p.Id_paketea = lp.Id_paketea
        WHERE lp.Id_langilea = $user_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasiera Kudeaketa</title>
    <link rel="stylesheet" href="./styles/paketeakHasiera.css">
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
            <div>Erabiltzailea: <span id="username"><?php echo htmlspecialchars($_SESSION['user_name'] . ' ' . $_SESSION['user_surname']); ?></span></div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Paketearen ID-a</th>
                        <th>Helbidea</th>
                        <th>Egoera</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Emaitzak aurkitu diren edo ez aztertu
                    if ($result->num_rows > 0) {
                        // Datuak taulan erakutsi
                        while ($row = $result->fetch_assoc()) {
                            $status_class = '';
                            switch ($row['Estado']) {
                                case 'Entregatuta':
                                    $status_class = 'status-delivered';
                                    break;
                                case 'Prozesuan':
                                    $status_class = 'status-in-process';
                                    break;
                                case 'Intzidentziarekin':
                                    $status_class = 'status-issue';
                                    break;
                                default:
                                    $status_class = '';
                                    break;
                            }
                            echo "<tr class='$status_class'>";
                            echo "<td>" . $row['Id_paketea'] . "</td>";
                            echo "<td>" . $row['Helbidea'] . "</td>";
                            echo "<td>" . $row['Estado'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Erabiltzaile honentzako ez dago paketerik.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Konexioa itxi
$conn->close();
?>
