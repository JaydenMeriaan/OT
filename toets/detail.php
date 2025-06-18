<?php
require "db.php";
global $db;

$id = $_GET['id'];

$query = $db->prepare("SELECT * FROM film WHERE id = :id");
$query->bindParam(":id", $id);
$query->execute();
$filmDetails = $query->fetch(PDO::FETCH_ASSOC);

$query = $db->prepare("SELECT * FROM beoordeling WHERE film_id = :id");
$query->bindParam(":id", $id);
$query->execute();
$filmgrades = $query->fetchAll(PDO::FETCH_ASSOC);

$gemiddeldCijfer = 0;
if ($filmgrades) {
    $totaalCijfer = 0;
    foreach ($filmgrades as $grade) {
        $totaalCijfer += $grade['cijfer'];
    }
    $gemiddeldCijfer = $totaalCijfer / count($filmgrades);
}
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailpagina Film</title>
</head>
<body>
<h1><?php echo($filmDetails['titel']); ?></h1>
<p><strong>Genre:</strong> <?php echo ($filmDetails['genre']); ?></p>

<?php foreach ($filmgrades as $grade): ?>
    <p><strong>Cijfer:</strong> <?php echo($grade['cijfer']); ?>/10</p>
<?php endforeach; ?>

<?php if ($gemiddeldCijfer > 0): ?>
    <p><strong>Gemiddeld cijfer:</strong> <?php echo number_format($gemiddeldCijfer, 1); ?>/10</p>
<?php endif; ?>

<br>
<a href="index.php">Terug naar overzicht</a>
</body>
</html>

