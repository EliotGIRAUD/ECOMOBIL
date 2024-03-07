<!DOCTYPE html>
<html>
<head>
    <p><a href="/Projet/ECOMOBIL/index.php">Retour à l'index </a></p>

    <meta charset="utf-8" />
    <title>Inscription</title>
    <style>
        body {
            flex-direction: column;

            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            gap: 1em;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            justify-content: center;
            display: flex;
            flex-direction: column;
            width: 500px;
        }
        label, input {
            display: block;
            margin: 10px 0;
        }
        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        h2{
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
<form action="/Projet/ECOMOBIL/index.php?action=AddClient" method="POST">
    <h2>Inscription</h2>
    <label for="Prenom">Prénom</label>
    <input type="text" id="Prenom" name="Prenom" required>

    <label for="Nom">Nom</label>
    <input type="text" id="Nom" name="Nom" required>

    <label for="Email">Email</label>
    <input type="email" id="Email" name="Email" required>

    <label for="Mdp">Mot de passe</label>
    <input type="password" id="Mdp" name="Mdp" required minlength="8" maxlength="100">

    <input type="submit" value="Inscription">

    <p><a href="Login.php">Se connecter</a></p>

</form>

<?php
if (isset($_SESSION["insertClient"]) && $_SESSION["insertClient"] === 0) {
    echo "Le mail ". $_SESSION["Email"] ." déjà existant ";
}
if (isset($_SESSION["insertClient"]) && $_SESSION["insertClient"] === 1) {
    echo "Bienvenue chez EcoMobil " . $_SESSION["Prenom"] . " " . $_SESSION["Nom"];
}
?>
</body>
</html>

