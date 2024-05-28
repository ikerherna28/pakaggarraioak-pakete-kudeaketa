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


function enviar_mail($to, $codigo_verificacion) {
    $subject = "PackaGarraioak Berifikazio Kodea";
    $txt = "Berifikazio kodea da:" . $codigo_verificacion;
    $headers = "From: pakaggarraioak@gmail.com" . "\r\n" .
    "CC: 1ag3.ikerhern@tolosaldealh.eus, 1ag3.xikesanc@tolosaldealh.eus";

    $ret = mail($to,$subject,$txt,$headers);
}

// Formularioa bidali den edo ez egiaztatu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formularioko datuak eskuratu
    $Posta = $_POST["email"];
    $Pasahitza = $_POST["Password"];

    // Kredentzialak egiaztatu nahi diren SQL kontsulta
    $sql = "SELECT * FROM Langileak WHERE Posta = ? AND Pasahitza = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $Posta, $Pasahitza);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Kredentzialak zuzenak dira, berifikazio kodea sortu eta posta bidali
        $user = $result->fetch_assoc();
        $codigo_verificacion = rand(100000, 999999); // 6 digituko kodea sortu

        // Erabiltzailearen eta kodearen informazioa sesioan gorde
        $_SESSION['user_id'] = $user['Id_langilea'];
        $_SESSION['user_email'] = $user['Posta'];
        $_SESSION['codigo_verificacion'] = $codigo_verificacion;

        // Posta bidaltzeko Java aplikazioa deitu
        // $command = "java -jar EmailSender.jar " . escapeshellarg($user['Posta']) . " " . escapeshellarg($codigo_verificacion);
        // shell_exec($command);  
        enviar_mail($user['Posta'], $codigo_verificacion);

        // Berifikazio orrialdera bideratu
        header("Location: verify.php");
        exit();
    } else {
        // Kredentzialak okerrak
        $mensaje = "Erabiltzaile edo pasahitza ez da zuzena";
    }

    $stmt->close();
}

// Datu-basearekin konexioa itxi
$conn->close();
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="utf-8">
    <title>PAKAG</title>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="https://assets-global.website-files.com/6647183ad715b3f33f1e8cfd/css/pakag.webflow.1195e8aaa.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed:regular,700" media="all">
</head>
<body class="body">
    <div class="container w-container">
        <h1 class="logo">PAKAG</h1>
        <div class="join-wrapper w-clearfix">
            <br><br><br><br><div class="beta-line"></div>
            <p class="join">SESIOA HASI</p>
            <div class="beta-line"></div>
        </div>
        <br><div class="sign-up-form w-form">
            <form name="wf-form-signup-form" data-name="Signup Form" id="email-form" method="post" data-wf-page-id="6647183ad715b3f33f1e8d2e" data-wf-element-id="02427346-5a5f-c275-bcc6-b3278940ad8e" aria-label="Signup Form">
                <input class="field w-input" maxlength="256" name="email" data-name="Email" placeholder="POSTA HELBIDEA" type="email" id="field" required="">
                <input class="field w-input" maxlength="256" name="Password" data-name="Password" placeholder="PASAHITZA" type="password" id="Password" required="">
                <input type="submit" data-wait="Piztu pixkat..." class="button w-button" value="HASI">
            </form>
        </div>
    </div>
</body>
</html>
