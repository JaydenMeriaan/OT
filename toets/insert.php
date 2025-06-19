<?php

require 'db.php';
global $db;
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['titel'], $_POST['genre'], $_POST['cijfer'])) {
    $title = $_POST['titel'];
    $genre = $_POST['genre'];
    $cijfer = $_POST['cijfer'];

    if (empty($title) || empty($genre) || empty($cijfer)) {
        $error = "Zowel de titel, genre als het cijfer moeten ingevuld worden!";
    } else {


        $stmt = $db->prepare("SELECT * FROM film WHERE titel = :titel");
        $stmt->bindParam(':titel', $title);
        $stmt->execute();
        $film = $stmt->fetch();

        if ($film) {
            $error = "Deze film bestaat al!";
        } else {


            $stmt = $db->prepare("INSERT INTO film (titel, genre) VALUES (:titel, :genre)");
            $stmt->bindParam(":titel", $title);
            $stmt->bindParam(":genre", $genre);

            if ($stmt->execute()) {
                $filmId = $db->lastInsertId();

                $stmtBeoordeling = $db->prepare("INSERT INTO beoordeling (film_id, cijfer) VALUES (:film_id, :cijfer)");
                $stmtBeoordeling->bindParam(":film_id", $filmId);
                $stmtBeoordeling->bindParam(":cijfer", $cijfer);

                if ($stmtBeoordeling->execute()) {
                    $success = "Film '$title' van genre '$genre' is succesvol toegevoegd met cijfer '$cijfer'!";

                    header("Location: index.php?");
                    exit;
                } else {
                    $error = "Er is iets misgegaan bij het opslaan van de beoordeling.";
                }
            } else {
                $error = "Er is iets misgegaan bij het opslaan van de film.";
            }
        }
    }
}
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film Toevoegen</title>
</head>
<body>

<h1>Voeg een Film Toe</h1>

<form method="post">
    <label for="title">Filmtitel:</label>
    <input type="text" name="titel" id="title" required><br>

    <label for="genre">Genre:</label>
    <input type="text" name="genre" id="genre" required><br>

    <label for="cijfer">Cijfer:</label>
    <input type="number" name="cijfer" id="cijfer" min="1" max="10" required><br>

    <button type="submit">Film Toevoegen</button>
    <br>
    <a href="index.php">Terug naar overzicht</a>
</form>

<?php
// Als er een fout is, toon de foutmelding
if ($error) {
    echo "<p>$error</p>";
}

if ($success) {
    echo "<p>$success</p>";
}
?>

</body>
</html>
