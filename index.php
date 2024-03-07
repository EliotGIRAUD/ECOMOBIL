<?php
/* Fichier index pour TP_SIO2_1 migré vers le modèle  MVC */
require('controller/controller.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_COOKIE["nom"]) && isset($_COOKIE["prenom"]) && empty($_SESSION["prenom"])) {
    $_SESSION["prenom"] = $_COOKIE["prenom"];
    $_SESSION["nom"] = $_COOKIE["nom"];
    echo "Content de vous revoir " . $_SESSION["nom"] . " " . $_SESSION["prenom"];
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'Login') {
        if (Login($_POST['Email'], $_POST['Mdp']) == True){
            require('menuprincipal.php');
        }
        else{
            require('View/Login.php');
        }
    } else if ($_GET['action'] == 'AddClient') {
        if (isset($_POST['Prenom'], $_POST['Nom'], $_POST['Email'], $_POST['Mdp'])) {
            AddClient($_POST['Prenom'], $_POST['Nom'], $_POST['Email'], $_POST['Mdp']);
        } else {
            echo "Manque un champ du formulaire";
        }
    } else if ($_GET['action'] == 'Agence'){
        if (isset($_POST['Agence'])) {    
            $_SESSION['IdAgence'] = getIdAgence($_POST['Agence']);
            require('View/Reservation.php');
        } else {
            echo "Manque un champ du formulaire";
            require('View/ReservationAgence.php');
        }        

    }else if ($_GET['action'] == 'AddReservation') {
        if (isset($_POST['Date'], $_POST['Heure'], $_POST['Duree'], $_POST['NbParticipants'], $_POST['DemandeSpeciale'])) {
            AddReservation($_POST['Date'], $_POST['Heure'], $_POST['Duree'], $_POST['NbParticipants'], $_POST['DemandeSpeciale']);
            require('View/ReservationTypeVehicule.php');
        } 
        else {
            echo "Manque un champ du formulaire";
            require('View/Reservation.php');
        }
    }else if ($_GET['action'] == 'AddVehicule'){
        if ($_SESSION['count'] < $_SESSION["NbPersonne"]){
            if (isset($_POST["TypeVehiculeParticipant"])){
                $_SESSION["TypeVehiculeParticipant"][$_SESSION['count']] = $_POST["TypeVehiculeParticipant"];
                if (isset($_SESSION['count'])){
                    $_SESSION['count'] = 0;
                }else {
                    $_SESSION['count']+= 1;
                }
                require('View/ReservationTypeVehicule.php');
            }else {
                echo "Veuillez selectionner un véhicule.";
                require('View/ReservationTypeVehicule.php');
            }
        }
        if ($_SESSION['count'] == $_SESSION["NbPersonne"]) {
            if (isset($_POST["PrenomParticipant"]) && is_array($_POST["PrenomParticipant"]) && isset($_POST["TypeVehiculeParticipant"]) && is_array($_POST["TypeVehiculeParticipant"])) {
                for ($i = 0; $i <= $_SESSION["NbPersonne"]; $i++) {
                    echo isset($_POST["PrenomParticipant"][$i]) ? $_POST["PrenomParticipant"][$i] : 'Undefined';
                    echo isset($_POST["TypeVehiculeParticipant"][$i]) ? $_POST["TypeVehiculeParticipant"][$i] : 'Undefined';
                    AddParticipant(isset($_POST["PrenomParticipant"][$i]) ? $_POST["PrenomParticipant"][$i] : null, isset($_POST["TypeVehiculeParticipant"][$i]) ? $_POST["TypeVehiculeParticipant"][$i] : null);
                    require('View/ReservationCheck.php');
                }
            }else{
                echo "Manque un champ du formulaire";
            }
        }else {
            echo "Les clés ne sont pas définies correctement dans \$_POST.";
        }
    }
}
else {
        require('Menuprincipal.php');
}
/*?> ommis car PHP only */

