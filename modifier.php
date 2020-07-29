<?php
// On vérifie si on a un id dans l'URL
if(isset($_GET['id'])&& !empty($_GET['id'])){
    // On a un id, on va chercher la personne dans la base
    // On se connecte
    require_once'inc/connect.php';

    // On écrit la requête
    $sql = 'SELECT * FROM `liste` WHERE `id` = :id';
    
    // On prépare la requête
    $query = $db->prepare($sql);

    // On accroche les valeurs aux paramètres
    $query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère les données
    $personne= $query->fetch(PDO::FETCH_ASSOC); //fect assoc permet d'eviter le doublement des infos

    if(!$personne){
        // Pas d'id ou id vide, on retourne à la page index
        header('location: index.php');
    }

    // Ici $personne contient un enregistrement de la base de données
    // On vérifie que POST contient des données
    if(empty($_POST)){
        // Onvérifie que tous les champs obligatoires sont remplis
        if(isset($_POST['nom']) && !empty($_POST['nom'])
        &&isset($_POST['prenom']) && !empty($_POST['prenom'] 
        &&isset($_POST['age']) && !empty($_POST['age']   
    )}
        // Le formulaire est complet
        // On récupère et on nettoit les données
        $nom = strip_tags($_POST['nom']);
        $prenom = strip_tags($_POST['prenom']);
        $age = strip_tags($_POST['age']);

        // On stocke les données en base
        //1ere chose on écrit la requête
        $sql = "UPDATE `liste` SET `nom`= :nom,`prenom`= :prenom,`age`= :age WHERE `id` = {$personne['id]}";
 
        // On prépare la reqûete
        $query = $db->prepare($sql);

        // On injecte les paramètres
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':age', $age, PDO::PARAM_INT);

        // On exécute
        $query->execute();

        // On redirige l'utilisateur vers l'index
        header('Location: index.php')


    }else{
        // Le formulaire est incomplet
        $erreur = "Le formulaire est incomplet"
    }

    var_dump($personne);
}else{
    // Pas d'id ou id vide, on retourne à la page index
    header('Location: index.php');

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Modifier </h1>
    <form method="post">
        <div>
            <label for="nom">Nom </label>
            <input type="text" id="nom" name="nom" value="<?= $personne['nom'] ?>">
        </div>
        <div>
            <label for="prenom">Prénom </label>
            <input type="text" id="prenom" name="prenom" value="<?= $personne['prenom'] ?>">
        </div>
        <div>
            <label for="age"> Age </label>
            <input type="number" id="age" name="age" value="<?= $personne['age'] ?>">
        </div>
        <button>valider</button>
    </form>
</body>
</html>