<?php
require 'db.php';
global $db;

if (isset($_GET['id'])) {
    $film_id = $_GET['id'];

    $deleteReviewsQuery = $db->prepare("DELETE FROM beoordeling WHERE film_id = :film_id");
    $deleteReviewsQuery->bindParam(':film_id', $film_id, PDO::PARAM_INT);
    $deleteReviewsQuery->execute();

    $deleteFilmQuery = $db->prepare("DELETE FROM film WHERE id = :id");
    $deleteFilmQuery->bindParam(':id', $film_id, PDO::PARAM_INT);

    if ($deleteFilmQuery->execute()) {
        echo "Film succesvol verwijderd!";
    } else {
        echo "Er is een fout opgetreden bij het verwijderen van de film.";
    }
} else {
    echo "Geen film ID opgegeven.";
}

?>

<p><a href="index.php">Terug naar films overzicht</a></p>

<?php
header("refresh:2;url=index.php");
?>
