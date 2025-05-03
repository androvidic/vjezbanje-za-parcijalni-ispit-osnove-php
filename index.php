<?php
define('FILE_PATH', 'words.json');
$rijeci = citajJsonDatoteku(FILE_PATH);

function izracunajBrojSlova($nekaRijec){
    return strlen($nekaRijec);
    }
function izracunajBrojSamoglasnika ($nekaRijec){
    $rijec =strtolower($nekaRijec);
    $samoglasnici = ['a', 'e', 'i', 'o', 'u',];
   $slovaURijeci = preg_split('//u', $rijec);
  $brojSamoglasnika = 0;
  foreach ($slovaURijeci as $slovo) {
    if (in_array($slovo, $samoglasnici)) {
        $brojSamoglasnika++;
    }
}
    return $brojSamoglasnika;
  }

function izracunajBrojSuglasnika ($nekaRijec){
    return izracunajBrojSlova($nekaRijec) - izracunajBrojSamoglasnika($nekaRijec);
}
function citajJsonDatoteku($filePath){
    $wordsJson = file_get_contents($filePath, false);
    $nizRijeci = json_decode($wordsJson);
    return $nizRijeci;
}
function dodajRijec($word, $nizRijeci){
    $r = htmlspecialchars($word);
    $trimmedRijec = trim($r);
    if (strlen($trimmedRijec) ===0) return;

$brojSlova = izracunajBrojSlova($trimmedRijec);

$brojSamoglasnika = izracunajBrojSamoglasnika($trimmedRijec);

$brojSuglasnika = izracunajBrojSuglasnika($trimmedRijec);

$nizRijeci[] = $trimmedRijec;

$rijeciJson = json_encode($nizRijeci);

file_put_contents(FILE_PATH, $rijeciJson);
header ('Location: ' . $_SERVER['PHP_SELF']);
}

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
        $rijec = $_POST['rijec'];

        dodajRijec($rijec, $rijeci, FILE_PATH);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vježba za parcijalni ispit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Vježba zadatka za parcijalni ispit</h1>
    <hr>
    <main class="main">
        <form method="POST" action="index.php">
            <label> Upišite riječ:
                <input type="text" name="rijec" required>
            </label>
            <br><br>
            <input type="submit" value="Pošalji">
        </form>
        <table border="1">
            <tr>
                <th>Riječi</th>
                <th>Broj slova</th>
                <th>Broj samoglasnika</th>
                <th>Broj suglasnika</th>
            </tr>
<?php
    foreach ($rijeci as $rijecUNizu) {
        echo '<tr>';
        echo '<td>' . $rijecUNizu . '</td>';
        echo '<td>' . izracunajBrojSlova($rijecUNizu) . '</td>';
        echo '<td>' . izracunajBrojSamoglasnika($rijecUNizu) . '</td>';
        echo '<td>' . izracunajBrojSuglasnika($rijecUNizu) . '</td>';
        echo '</tr>';
    }
?>
        </table>
    </main>
</body>
</html>