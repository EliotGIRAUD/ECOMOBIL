<?php
require_once __DIR__. '/../controller/controller.php';
/*require ('../controller/controller.php');*/

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <p><a href="/Projet/ECOMOBIL/index.php">Retour à l'index </a></p>

    <meta charset="utf-8" />
    <title>Réservation véhicule</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            display: flex;
            flex-direction: column;
            padding: 50px 0;
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
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
            overflow: auto; /* Ajout de l'option de défilement */
            min-width: 400px;
        }
        label, input {
            display: block;
            margin: 10px 0;
            box-sizing: border-box;
        }
        input {
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px;
            width: auto;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        h2 {
            display: flex;
            justify-content: center;
        }

        /* Media queries */
        @media screen and (max-width: 600px) {
            form {
                max-width: 100%;
            }
        }

        #participantFields{
            display: flex;
            justify-content: center;
            gap: 3em;
        }
    </style>
</head>
<body>
<h2>Réservation</h2>

<form action="/Projet/ECOMOBIL/index.php?action=AddVehicule" method="POST">
    <div class="class-input">
        <label for="Vehicule"><i class="fa-solid fa-plane"></i>Type de véhicules :</label>
        <select name="Vehicule">
            <?php
            $vehicules = SelectVehicule($_SESSION['IdAgence']);
            foreach ($vehicules as $vehicule) {
                $nomVehicule = $vehicule['Libelle'];
                if (isset($nomVehiculePre)){
                    if ($nomVehiculePre == $nomVehicule){
                        
                    }else{
                        echo "<option value='$nomVehicule'>$nomVehicule</option>";
                        $nomVehiculePre = $nomVehicule;
                    }
                }else{
                    $nomVehiculePre = $nomVehicule;
                    echo "<option value='$nomVehicule'>$nomVehicule</option>";
                }
            }
            ?>
            
        </select>
    </div>
    <input type="submit" value="Réserver">
</form>
</body>
</html>
