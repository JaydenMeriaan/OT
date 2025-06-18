<?php
require 'db.php';
global $db;

if (isset($_GET['id'])) {
    $filmId = $_GET['id'];


    $deleteBeoordeling = $db->prepare("DELETE FROM beoordelingen WHERE film_id = :film_id");
    $deleteBeoordeling->bindParam(':film_id', $filmId);
    $deleteBeoordeling->execute();


    $deleteFilm = $db->prepare("DELETE FROM film WHERE id = :id");
    $deleteFilm->bindParam(':id', $filmId);
    $deleteFilm->execute();


    header("Location: index.php");
    exit();
} else {
    echo "Geen film ID opgegeven.";
}
