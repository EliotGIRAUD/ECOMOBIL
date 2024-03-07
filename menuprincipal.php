<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Accueil AIRSIO</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px;
            font-size: 24px;
        }

        main {
            margin: 20px;
        }

        p {
            font-size: 18px;
            margin: 10px;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
<header>
    <?php

    if (isset($_SESSION["Prenom"]) && isset($_SESSION["Nom"])) {
        echo "Bonjour " . $_SESSION["Prenom"] . " " . $_SESSION["Nom"] . " ! <br>Bienvenue sur ECOMOBIL";
    }
    ?>
</header>

<main>
    <p><a href="View/AddClient.php">Création compte client</a></p>
    <p><a href="View/Login.php">Login</a></p>
    <p><a href="View/ReservationAgence.php">Réservation</a></p>
</main>
</body>

</html>
