<!DOCTYPE html>
<html>
<head>
    <p><a href="/Projet/ECOMOBIL/index.php">Retour à l'index </a></p>

    <meta charset="utf-8" />
    <title>Connexion</title>
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
<h2>Connexion</h2>
<form action="/Projet/ECOMOBIL/index.php?action=Login" method="POST">
    <label for="Email">Email :</label>
    <input type="text" id="Email" name="Email" required><br><br>

    <label for="Mdp">Mot de passe :</label>
    <input type="password" id="Mdp" name="Mdp" required><br><br>
    
    <div class="g-recaptcha" data-sitekey="6LenaDUpAAAAAFLivcrOISI_0CyCIOLW_lubGLgn"></div>

    <input type="submit" value="Se Connecter">

    <p><a href="AddClient.php">Se créer un compte</a></p>

</form>


<?php
?>
</body>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</html>
