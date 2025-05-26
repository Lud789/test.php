<?php
// Connexion à la base de données
$host = "localhost";
$user = "root";
$password = "";
$dbname = "base"; // Remplace par le nom réel de ta base
$conn = new mysqli($host, $user, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Récupérer les données
$utilisateurs = $conn->query("SELECT k_utilisateurs, nom, prenom, id_chambre FROM utilisateurs");
$chambres = $conn->query("SELECT k_chambres, numero_chambre, id_nb_élève, lot1, lot2, lot3, lot4 FROM chambres");
$materiels = $conn->query("SELECT k_materiels, type, nom, FROM materiels JOIN utilisateurs u ON m.id_utilisateur = u.k_utilisateurs");
$lots = $conn->query("
    SELECT l.k_lots, l.nom_lot, m.nom_materiel
    FROM lots l
    JOIN materiels m ON l.id_materiel = m.k_materiels
");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion</title>
</head>
<body>
    <h2>Gestion des éléments</h2>

    <form method="post">
        <label for="utilisateur">Sélectionnez un utilisateur :</label>
        <select name="utilisateur" id="utilisateur">
            <?php while($u = $utilisateurs->fetch_assoc()): ?>
                <option value="<?= $u['k_utilisateurs'] ?>">
                    <?= $u['prenom'] . " " . $u['nom'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="voir_utilisateur">Voir</button>
    </form>

    <form method="post">
        <label for="chambre">Sélectionnez une chambre :</label>
        <select name="chambre" id="chambre">
            <?php while($c = $chambres->fetch_assoc()): ?>
                <option value="<?= $c['k_chambres'] ?>">
                    <?= $c['nom_chambre'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="voir_chambre">Voir</button>
    </form>

    <form method="post">
        <label for="materiel">Matériels des utilisateurs :</label>
        <select name="materiel" id="materiel">
            <?php while($m = $materiels->fetch_assoc()): ?>
                <option value="<?= $m['k_materiels'] ?>">
                    <?= $m['nom_materiel'] ?> (<?= $m['prenom'] . " " . $m['nom'] ?>)
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="voir_materiel">Voir</button>
    </form>

    <form method="post">
        <label for="lot">Lots par matériel :</label>
        <select name="lot" id="lot">
            <?php while($l = $lots->fetch_assoc()): ?>
                <option value="<?= $l['k_lots'] ?>">
                    <?= $l['nom_lot'] ?> (<?= $l['nom_materiel'] ?>)
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="voir_lot">Voir</button>
    </form>

    <hr>

    <?php
    if (isset($_POST['voir_utilisateur'])) {
        echo "<p>Utilisateur sélectionné : " . $_POST['utilisateur'] . "</p>";
    } elseif (isset($_POST['voir_chambre'])) {
        echo "<p>Chambre sélectionnée : " . $_POST['chambre'] . "</p>";
    } elseif (isset($_POST['voir_materiel'])) {
        echo "<p>Matériel sélectionné : " . $_POST['materiel'] . "</p>";
    } elseif (isset($_POST['voir_lot'])) {
        echo "<p>Lot sélectionné : " . $_POST['lot'] . "</p>";
    }
    ?>

</body>
</html>