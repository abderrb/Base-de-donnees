<?php
// On se connecte à la base de données
require_once 'inc/connect.php';

// On vérifie que POST n'est pas vide
if (!empty($_POST)) {
    // POST n'est pas vide, on vérifie touts les champs obligatoires
    if (
        isset($_POST['nom']) && !empty($_POST['nom'])
        && isset($_POST['prenom']) && !empty($_POST['prenom'])
        && isset($_POST['age']) && !empty($_POST['age'])
    ) {
        // Tous les champs sont valides   1ere etape de sécurité
        $nom = strip_tags($_POST['nom']);
        $lastname = htmlspecialchars($_POST['prenom']);
        $age = htmlentities($_POST['age']);

        // On écrit la requête 2nd etape de sécurité
        $sql = "INSERT INTO `liste`(`nom`,`prenom`,`age`) VALUES (:nom,:prenom, :age);";
        
        // On prépare la requête 3eme etape de sécurité
        $query = $db->prepare($sql);

        // On injecte les valeurs dans les paramètres 4eme etape de sécurité
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':age', $age, PDO::PARAM_INT);

        // On exécute la requête
        $query->execute();

       
    } else {
        // Aumoins 1 champ est invalide
        $erreur = "le formulaire est incomplet";
    }
}

$sql = 'SELECT * FROM `liste`;';

// On exécute la requête
$query = $db->query($sql);

// On récupère les données
$liste = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // On verifie que nom existe dans post et qu'il n'est pas vide

    ?>
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>nom</th>
                <th>prenom</th>
                <th>age</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($liste as $personne) :
            ?>
                <tr>
                    <td><?= $personne['id'] ?></td>
                    <td><?= $personne['nom'] ?></td>
                    <td><?= $personne['prenom'] ?></td>
                    <td><?= $personne['age'] ?></td>
                    <td><a href="modifier.php?id=<?= $personne['id'] ?>">Modifier</a></td>
                </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
    <h1>Ajouter une personne</h1>
    <form method="post">
        <div>
            <label for="nom">Nom </label>
            <input type="text" id="nom" name="nom">
        </div>
        <div>
            <label for="prenom">Prénom </label>
            <input type="text" id="prenom" name="prenom">
        </div>
        <div>
            <label for="age">Age </label>
            <input type="number" id="age" name="age">
        </div>
        <button>valider</button>
    </form>
</body>

</html>