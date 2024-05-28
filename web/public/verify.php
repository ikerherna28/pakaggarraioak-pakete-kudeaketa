<?php
session_start(); // Saioa hasi

$servername = "mysql";
$username = "root";
$password = "root"; 
$dbname = "webapp";

// Konexioa ezarri
$conn = new mysqli($servername, $username, $password, $dbname);

// Konexioa egiaztatu
if ($conn->connect_error) {
    die("Konexioak huts egin du: " . $conn->connect_error);
}

// Erabiltzailea egiaztatu
if (!isset($_SESSION['user_email']) || !isset($_SESSION['codigo_verificacion'])) {
    header("Location: index.php");
    exit();
}

// Mezuaren mezuaren kontuaren informazioa
$mensaje = "";

// Egiaztapen formularioa bidali den ala ez egiaztatu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_ingresado = $_POST["codigo_verificacion"];

    // Berifikazio kodea egiaztatu
    if ($codigo_ingresado == $_SESSION['codigo_verificacion']) {
        // Kodea zuzena, erabiltzailearen datuak datu-baseatik eskuratu
        $sql = "SELECT * FROM Langileak WHERE Posta = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['user_email']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Erabiltzailearen informazioa sesioan gorde
            $_SESSION['user_name'] = $user['Izena'];
            $_SESSION['user_surname'] = $user['Lehenengo_abizena'];
            $_SESSION['user_second_surname'] = $user['Bigarren_abizena'];
            $_SESSION['user_email'] = $user['Posta'];
            $_SESSION['user_phone'] = $user['Telefonoa'];
            $_SESSION['user_nid'] = $user['NAN'];
            $_SESSION['user_birthdate'] = $user['Jaiotze_data'];
            $_SESSION['user_address'] = $user['Helbidea'];
            $_SESSION['user_city'] = $user['Herria'];
            $_SESSION['user_zip'] = $user['Posta_kodea'];
            
            // Profila orrialdera bideratu
            header("Location: paketeakHasiera.php");
            exit();
        } else {
            $mensaje = "Erabiltzailea ez da aurkitu.";
        }

        $stmt->close();
    } else {
        // Kodea okerra
        $mensaje = "Berifikazio kodea okerra.";
    }
}

// Datu-basearekin konexioa itxi
$conn->close();
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="utf-8">
    <title>Berifikazioa</title>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="https://assets-global.website-files.com/6647183ad715b3f33f1e8cfd/css/pakag.webflow.1195e8aaa.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed:regular,700" media="all">
    <style>
        .mensaje {
            position: fixed;
            color: black;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }
    </style>
</head>
<body class="body">
    <div class="container w-container">
        <h1 class="logo">PAKAG</h1>
        <div class="join-wrapper w-clearfix">
            <br><br><br><br><div class="beta-line"></div>
            <p class="join">BERIFIKATU KODEA</p>
            <div class="beta-line"></div>
        </div>
        <br><div class="sign-up-form w-form">
            <form name="wf-form-verification-form" data-name="Verification Form" id="verification-form" method="post" data-wf-page-id="6647183ad715b3f33f1e8d2e" data-wf-element-id="02427346-5a5f-c275-bcc6-b3278940ad8e" aria-label="Verification Form">
                <input class="field w-input" maxlength="6" name="codigo_verificacion" data-name="Codigo Verificacion" placeholder="BERIFIKAZIO KODEA" type="text" id="codigo_verificacion" required="">
                <input type="submit" data-wait="Itxaron pixkat..." class="button w-button" value="BERIFIKATU">
            </form>
        </div>
    </div>
    
    <?php if (!empty($mensaje)): ?>
        <div class="mensaje">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>
</body>
</html>
