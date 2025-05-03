<?php
define('PEOPLE_PATH', 'people.json');
$imena = citajJsonDatoteku(PEOPLE_PATH);

function izracunajBrojSlova($nekoIme){
    return strlen($nekoIme);
}

function izracunajBrojSlovaA($nekoIme){
    return substr_count(strtolower($nekoIme), 'a');
}

function izracunajBrojPonavljajucihSlova($nekoIme){
    $rijec = strtolower($nekoIme);
    $slovaURijeci = str_split($rijec);
    return count($slovaURijeci) - count(array_unique($slovaURijeci));
}

function jeLiImeSimetricno($nekoIme) {
    $nekoIme = trim (mb_strtolower($nekoIme, 'UTF-8')); 
    $simetricnoIme = strrev($nekoIme);

    return ($simetricnoIme === $nekoIme) ? "Ime je simetricno" : "Ime nije simetricno";
}
function citajJsonDatoteku($filePath){
    $imenaJson = file_get_contents($filePath, false);
    $nizImena = json_decode($imenaJson);
    return $nizImena;
}

function dodajIme($ime, $nizImena){
    $i = htmlspecialchars($ime);
    $trimmedIme = trim($i);
    if (strlen($trimmedIme) ===0) return;
    $brojSlova = izracunajBrojSlova($trimmedIme);
    $brojSlovaA = izracunajBrojSlovaA($trimmedIme);
    $brojponavljajucihSlova = izracunajBrojPonavljajucihSlova($trimmedIme);
    $jeLiImeSimetricno = jeLiImeSimetricno($trimmedIme);
    $nizImena[] = $trimmedIme;
    $imenaJson = json_encode($nizImena);
    file_put_contents(PEOPLE_PATH, $imenaJson);
    header ('Location: ' . $_SERVER['PHP_SELF']);
}

?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $ime = $_POST['ime'];
        dodajIme($ime, $imena, PEOPLE_PATH);
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Vjezba Copilot zadatak</title>
</head>
<body>
    <h1>Vjezba Copilot zadatak</h1>
    <hr>
    <main class="main">

        <form method="POST" action="index2.php">
            <label> Upišite ime:
                <input type="text" name="ime" required>
            </label>
            <br><br>
            <input type="submit" value="Pošalji">
        </form>

        <table border="1">
            <tr>
                <th>Ime</th>
                <th>Broj slova imena</th>
                <th>Broj slova A u imenu</th>
                <th>Broj ponavljajucih slova u imenu</th>
                <th>Je li ime simetricno</th>
            </tr>
            <?php
        foreach ($imena as $ime) {
            echo "<tr>";
            echo "<td>" . $ime . "</td>";
            echo "<td>" . izracunajBrojSlova($ime) . "</td>";
            echo "<td>" . izracunajBrojSlovaA($ime) . "</td>";
            echo "<td>" . izracunajBrojPonavljajucihSlova($ime) . "</td>";
            echo "<td>" . jeLiImeSimetricno($ime) . "</td>";
            echo "</tr>";
        }

            ?>
    </main>
</body>
</html>