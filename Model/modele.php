<?php

/* -------------------------*/
/* Db connection à AIRSIO   */
/* -------------------------*/
function dbconnect()
{
	try
	{
  		$bdd = new PDO('mysql:host=localhost;dbname=ecomobile', 'root', '',
               array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  		//echo "CONNECTION a AIRSIO OK " . '</br>';
  		return $bdd;
	}
	catch (Exception $e)
	{
        die('Erreur de connection à la base : ' . $e->getMessage());
	}
}

function InsertClient($Prenom, $Nom, $Email, $Mdp){
    $bdd = dbconnect();
    $insert_query = $bdd->prepare("INSERT INTO client (Prenom, Nom, Email, Mdp) VALUES (:Prenom, :Nom, :Email, :Mdp)");
    $insert_query->execute(array('Prenom' => $Prenom,
            'Nom' => $Nom,
            'Email' => $Email,
            'Mdp' => $Mdp));

    return $insert_query;
}

function CheckEmailExists($Email) {
    $bdd = dbconnect();
    $select_query = $bdd->prepare("SELECT COUNT(*) FROM client WHERE Email = :Email");
    $select_query->execute(array('Email' => $Email));
    $result = $select_query->fetchColumn();

    return $result; // Si le résultat est supérieur à 0, l'e-mail existe déjà.
}


function RecupClient($Email) {
    $bdd = dbconnect();
    $select_query = $bdd->prepare("SELECT * FROM client WHERE Email = :Email");
    $select_query->execute(array(
        'Email' => $Email
    ));
    $result = $select_query->fetch();

    return $result;
}

function GetPassword($Email){
    $bdd = dbconnect();
    $insert_query = $bdd->prepare("SELECT Mdp from client WHERE Email = :Email");
    $insert_query->execute(array(
        'Email' => $Email
    ));

    return $insert_query;
}

function getNomAgence(){
    $bdd = dbconnect();
    $Agence_result = $bdd -> query('SELECT NomAgence from agence' );
    return $Agence_result;
}

function getIdAgence($NomAgence){
    $bdd = dbconnect();
    $insert_query = $bdd->prepare("SELECT IdAgence from agence WHERE NomAgence = :NomAgence");
    $insert_query->execute(array(
        'NomAgence' => $NomAgence
    ));
    $result = $insert_query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

/**************************reservation******************************* */

function InsertReservation($DateReservation, $HeureReservation, $TypeReservation, $NbPersonne, $DemandeSpeciale)
{
    $bdd = dbconnect();
    $IdClient = $_SESSION["IdClient"];
    $insert_query = $bdd->prepare("INSERT INTO Reservation (IdClient, DateReservation, HeureReservation, TypeReservation, NbPersonne, DemandeSpeciale) VALUES (:IdClient, :DateReservation, :HeureReservation, :TypeReservation, :NbPersonne, :DemandeSpeciale)");
    $insert_query->bindParam(":IdClient", $IdClient, PDO::PARAM_INT);
    $insert_query->bindParam(":DateReservation", $DateReservation, PDO::PARAM_STR);
    $insert_query->bindParam(":HeureReservation", $HeureReservation, PDO::PARAM_STR);
    $insert_query->bindParam(":TypeReservation", $TypeReservation, PDO::PARAM_STR);
    $insert_query->bindParam(":NbPersonne", $NbPersonne, PDO::PARAM_INT);
    $insert_query->bindParam(":DemandeSpeciale", $DemandeSpeciale, PDO::PARAM_STR);

    $insert_query->execute();
    $IdReservation = $bdd->lastInsertId();
    return  $IdReservation;
}

function InsertParticipant($Prenom, $TypeVehicule, $IdReservation)
{
    $bdd = dbconnect();
    $insert_query = $bdd->prepare("INSERT INTO Participant (Prenom, TypeVehicule, IdReservation) VALUES (:Prenom, :TypeVehicule, :IdReservation)");
    $insert_query->bindParam(":Prenom", $Prenom, PDO::PARAM_STR);
    $insert_query->bindParam(":TypeVehicule", $TypeVehicule, PDO::PARAM_STR);
    $insert_query->bindParam(":IdReservation", $_SESSION["IdReservation"], PDO::PARAM_INT);

    $insert_query->execute();
    return  $insert_query;
}

function InsertVehicule()
{
    $Disponibilte = "Indisponible";
    $bdd = dbconnect();
    $insert_query = $bdd->prepare("INSERT INTO Vehicule (Disponibilte) VALUES (:Disponibilte)");
    $insert_query->bindParam(":Disponibilte", $Disponibilte, PDO::PARAM_STR);

    $insert_query->execute();
    return  $insert_query;
}

/**************************reservation******************************* */

function CheckClientExists($IdClient) {
    $bdd = dbconnect();
    $select_query = $bdd->prepare("SELECT COUNT(*) FROM client WHERE IdClient = :IdClient");
    $select_query->execute(array('IdClient' => $IdClient));
    $result = $select_query->fetchColumn();

    return $result; // Si le résultat est supérieur à 0, le client existe.
}

function getVehicule($IdAgence){
    try {
        $bdd = dbconnect();
        $query = "SELECT DISTINCT typevehicule.Libelle 
                  FROM typevehicule
                  INNER JOIN vehicule ON typevehicule.IdTypeVehicule = vehicule.IdTypeVehicule
                  WHERE vehicule.IdAgence = :IdAgence";
        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':IdAgence', $IdAgence, PDO::PARAM_INT);
        $stmt->execute();
        $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $vehicles;
    } catch (PDOException $e) {
        die('Database Error: ' . $e->getMessage());
    }
}
?>