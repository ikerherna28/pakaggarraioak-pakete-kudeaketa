<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: verify.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['package_id'])) {
    $package_id = $_POST['package_id'];

    $host = "mysql";
    $username = "root";
    $password = "root";
    $database = "webapp";

    // Datu basearekin konexioa
    $conn = new mysqli($host, $username, $password, $database);

    // Konexioa egiaztatu
    if ($conn->connect_error) {
        die("Konexio errorea: " . $conn->connect_error);
    }

    // Paketearen egoera "Entregatuta" gisa eguneratu
    $sql = "UPDATE Paketeak SET Estado = 'Entregatuta' WHERE Id_paketea = $package_id";

    if ($conn->query($sql) === TRUE) {
        echo "Paketearen egoera zuzenki eguneratu da 'Entregatuta' izatera";
    } else {
        echo "Paketearen egoera eguneratzean errorea: " . $conn->error;
    }

    $conn->close();
}
?>
