<?php

require_once __DIR__. '/../Model/modele.php';

function LoginUser(){
    if (isset($_SESSION["prenom"]) && isset($_SESSION["nom"])) {
        if (strcmp($_SESSION["prenom"], $_POST["prenom"])==0  &&  strcmp($_SESSION["nom"], $_POST["nom"])==0){
            echo "Vous êtes déjà connecté " . $_SESSION["prenom"] . " " . $_SESSION["nom"];
        }
        else {
            $prenom = $_POST["prenom"];
            $nom = $_POST["nom"];
            $_SESSION["prenom"] = $prenom;
            $_SESSION["nom"] = $nom;
            echo "Bienvenue " . $_SESSION["prenom"] . " " . $_SESSION["nom"];
            setcookie("prenom", $prenom , time() + 365*24*3600);
            setcookie("nom", $nom , time() + 365*24*3600);

        }
    }
    else {
        if (isset($_POST["prenom"]) && isset($_POST["nom"])) {
            $prenom = $_POST["prenom"];
            $nom = $_POST["nom"];
            $_SESSION["prenom"] = $prenom;
            $_SESSION["nom"] = $nom;
            echo "Bienvenue " . $_SESSION["prenom"] . " " . $_SESSION["nom"];
            setcookie("prenom", $prenom , time() + 365*24*3600);
            setcookie("nom", $nom , time() + 365*24*3600);
        }
    }
}

function AddClient($Prenom, $Nom, $Email, $Mdp){

    if (CheckEmailExists($Email) > 0) {
        $_SESSION["insertClient"] = 0;
        $_SESSION["Email"] = $Email;
        require('View/AddClient.php');
    }
    else if (CheckEmailExists($Email) == 0) {
        if (CheckContent($Mdp) == false){
            echo "Veuillez créer un mot de passe avec plus de 8 carractère, moins de 20 carractère, une majuscule, une minuscule, un chiffre et un carractère spéciale. <br>";
            require('View/AddClient.php');
        }
        if (CheckContent($Mdp) == true){
            $Mdp = password_hash($Mdp , PASSWORD_DEFAULT);
            $AddClient_result = InsertClient($Prenom, $Nom, $Email, $Mdp);
            $_SESSION["insertClient"] = 1;
            $_SESSION["Nom"] = $Nom;
            $_SESSION["Prenom"] = $Prenom;
            echo "Nous avons bien créé votre compte ! <br>";
            require('View/AddClient.php');
            
        }
    }
}

/*
*Check si le mot de passe est conforme
*/
function CheckContent($Mdp){
    if (strlen($Mdp) < 8 ||
     !preg_match('/[A-Z]/',$Mdp) ||
      !preg_match('/[a-z]/',$Mdp) ||
       !preg_match('/[0-9]/',$Mdp) ||
        !preg_match('/[&~#{(-|_^@)=}¤$£%µ*?,.;:§!]/',$Mdp)){
        return false;
    }
    else{
        return true;
    }

}

function Login($Email, $Mdp) {
    try {
        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            $secretAPIkey = '6LenaDUpAAAAAJ5wmNoSVUEkzw8l38drt3crxmZH';

            // reCAPTCHA response verification
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretAPIkey.'&response='.$_POST['g-recaptcha-response']);
            // Decode JSON data
            $response = json_decode($verifyResponse);

            if($response->success){
                if (isset($_SESSION['echec']) == false){
                    $_SESSION['echec'] = 0;
                    $_SESSION['bloque'] = False;
                }
                if (isset($_SESSION['echec']) && $_SESSION['echec'] > 3){
                    $_SESSION['timeout'] = time() + 20;
                    echo "Trop de tentative vous étes suspendus 20 secondes";
                    $_SESSION['bloque'] = True;
                    $_SESSION['echec'] = 0;
                    return False;
                    
                }
                if ($_SESSION['bloque'] == False){
                    $row = RecupClient($Email);
                    $Mdp_result = GetPassword($Email);
                    
                    if ($Mdp_result) {
                        $Mdp_result = $Mdp_result->fetch(PDO::FETCH_ASSOC);
                        if ($Mdp_result && isset($Mdp_result['Mdp'])) {
                            $hashMdp = $Mdp_result['Mdp'];
                            if (password_verify($Mdp, $hashMdp)) {
                                $_SESSION["Email"] = $Email;
                                $_SESSION["Nom"] = $row['Nom'];
                                $_SESSION["Prenom"] = $row['Prenom'];
                                $_SESSION["IdClient"] = $row['IdClient'];
                                return True;
                            } else {
                                echo "Veuillez créer un compte";
                                $_SESSION['echec'] += 1;
                                return False;
                            }
                        } else {
                            echo "Erreur lors de la récupération du mot de passe pour l'email $Email.";
                            $_SESSION['echec'] += 1;
                            return False;
                        }
                    } else {
                        echo "Erreur lors de la récupération des informations du client pour l'email $Email.";
                        $_SESSION['echec'] += 1;
                        return False;
                    }
                }
                
                if ($_SESSION['bloque'] == True){
                    if (time() > $_SESSION['timeout']){
                        unset($_SESSION['echec']);
                        unset($_SESSION['bloque']);
                        return False;
                    }
                    else{
                        echo "Vous etes supendus jusqu'a " . date("H:i:s", $_SESSION['timeout']) ;
                        return False;
                    }
                }
            } else {
                echo "Robot verification failed, please try again.";
                return False;
            } 
        }else{ 
            echo "Plese check on the reCAPTCHA box.";
            return False;
        }
    } catch (PDOException $e) {
        echo "Erreur PDO : " . $e->getMessage();
    }
}


function AddReservation($DateReservation, $HeureReservation, $Duree, $NbPersonne, $DemandeSpeciale){
    if (CheckClientExists($_SESSION["IdClient"]) > 0) {
        $IdReservation = InsertReservation($_POST['Date'], $_POST['Heure'], $_POST['Duree'], $_POST['NbParticipants'], $_POST['DemandeSpeciale']);
        //print_r($AddClient_result);
        $_SESSION["DateReservation"] = $DateReservation;
        $_SESSION["HeureReservation"] = $HeureReservation;
        $_SESSION["Duree"] = $Duree;
        $_SESSION["NbPersonne"] = $NbPersonne;
        $_SESSION["DemandeSpeciale"] = $DemandeSpeciale;
        $_SESSION["IdReservation"] = $IdReservation;
    }
    else if (CheckClientExists($_SESSION["IdClient"]) == 0) {
        $_SESSION["insertClient"] = 0;
        require('View/Login.php');
        echo "Veillez vous connecter !";
    }
}

function AddParticipant($Prenom, $TypeVehicule){
    if (isset($_SESSION["IdReservation"], $_SESSION["IdClient"])) {
        $IdReservation = $_SESSION["IdReservation"];
        $AddClient_result = InsertParticipant($Prenom, $TypeVehicule, $IdReservation);
        $_SESSION["$Prenom"] = $Prenom;
        $_SESSION["$TypeVehicule"] = $TypeVehicule;
    } else {
        require('View/Reservation.php');
        echo "Les clés IdReservation ou IdClient ne sont pas définies dans \$_SESSION.";
    }
}

function SelectVehicule($Agence){
    if (isset($Agence)) {
        $_SESSION['Agence'] = $Agence;
        return getVehicule($Agence);
    } else {
        require('View/ReservationAgence.php');
        echo "Il faut selectionner une agence.";
    }
}

function getAllAgence(){
    return getNomAgence();
}

/*?> ommis car PHP only */