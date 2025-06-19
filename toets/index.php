<?php
require 'db.php';
global $db;

// Haal alle films op
$query = $db->prepare("SELECT * FROM film");
$query->execute();
$films = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films Overzicht</title>
</head>
<body>
<h1>Films Overzicht</h1>

<?php foreach ($films as $film): ?>
    <article class="movie">
        <div class="film">
            <hr>
            <h1 class="movie-counter"><?php echo $film['id']; ?></h1>
            <h1 class="movie-name"><?php echo $film['titel']; ?></h1>
            <a href="detail.php?id=<?php echo $film['id']; ?>">Bekijk beoordelingen</a>
            <a href="delete.php?id=<?php echo $film['id']; ?>">Verwijder film</a>
            <a href="update.php?id=<?php echo $film['id']; ?>">Bewerk film</a>
        </div>
    </article>
<?php endforeach; ?>
<hr>
<a href="insert.php">Eigen film toevoegen</a>
</body>
</html>
