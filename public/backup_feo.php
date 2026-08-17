
<?php

require_once '../src/HeartRateCalculator.php';
require_once '../src/KarvonenCalculator.php';

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $age = (int) $_POST['age'];
    $resting = (int) $_POST['resting'];

    $fcm = HeartRateCalculator::calculateTanaka($age);

    $result = [
        'fcm' => $fcm,
        'zones' => KarvonenCalculator::calculateZones(
            $fcm,
            $resting
        )
    ];
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Running Zones Calculator</title>
<style>

body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: auto;
}

table {
    border-collapse: collapse;
}

td, th {
    border:1px solid #ccc;
    padding:8px;
}

</style>
</head>

<body>

<h1>Calculadora de Zonas Running</h1>

<form method="post">

<label>Edad:</label>
<input type="number" name="age" required>

<br><br>

<label>FC Reposo:</label>
<input type="number" name="resting" required>

<br><br>

<button type="submit">
Calcular
</button>

</form>

<?php if ($result): ?>

<h2>FCM Estimada: <?= $result['fcm'] ?></h2>

<table>

<tr>
<th>Zona</th>
<th>Mínimo</th>
<th>Máximo</th>
</tr>

<?php foreach($result['zones'] as $zone => $values): ?>

<tr>
<td><?= $zone ?></td>
<td><?= $values[0] ?></td>
<td><?= $values[1] ?></td>
</tr>

<?php endforeach; ?>

</table>

<?php endif; ?>

</body>
</html>