<?php
session_start(); // Saioa hasi

// Saioa hasi duen ala ez egiaztatu
if (!isset($_SESSION['user_id'])) {
    header("Location: verify.php"); // Beraiekin bat egiteko
    exit();
}

// Datu basearekin konexioa ezarri (balio egokienekin ordezkatu)
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

// Datuak bidali diren ala ez egiaztatu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $package_id = $_POST['package_id'];

    // Erabiltzaileak entregaren aukera hautatu duen ala ez egiaztatu
    if (isset($_POST['delivery'])) {
        // Paketearen egoera "Entregatuta" gisa eguneratu
        $sql_update_package = "UPDATE Paketeak SET Estado = 'Entregatuta' WHERE Id_paketea = $package_id";
        if ($conn->query($sql_update_package) === TRUE) {
            echo "Paketea ondo entregatu da.";
        } else {
            echo "Errorea: " . $conn->error;
        }
    }

    // Intzidentzia deskribapena bidali bada ala ez egiaztatu
    if (isset($_POST['incident_description'])) {
        $incident_description = $_POST['incident_description'];

        // Intzidentzia deskribapena Paketeak_Intzidentzia taulan txertatu
        $sql_insert_incident = "INSERT INTO Paketeak_Intzidentzia (Id_paketea, Intzidentzia_deskribapena) VALUES ('$package_id', '$incident_description')";
        if ($conn->query($sql_insert_incident) === TRUE) {
            echo "Intzidentzia ondo gorde da.";

            // Paketearen egoera "Intzidentziarekin" gisa eguneratu
            $sql_update_package = "UPDATE Paketeak SET Estado = 'Intzidentziarekin' WHERE Id_paketea = $package_id";
            if ($conn->query($sql_update_package) === TRUE) {
                echo " Paketea Intzidentziarekin gorde da.";
            } else {
                echo "Errorea: " . $conn->error;
            }
        } else {
            echo "Errorea: " . $conn->error;
        }
    }
}

$conn->close();
?>
