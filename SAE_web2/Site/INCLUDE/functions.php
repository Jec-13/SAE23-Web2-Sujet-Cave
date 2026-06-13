<?php
function get_bdd_comptes($path){
	// retourne un tableau contenant les information de tout les utilisateurs
	// $path est le chemin de la base
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT u.EMAIL, u.PASS, u.STATUT
				FROM utilisateurs u";
	$resultat = $madb->query($requete);
	$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
	if (sizeof($tableau) != 0) { // vérification que le tableau ne soit pas vide (que la base est bien été lu)
		$retour = $tableau;
	}
	return $retour;
};

function get_liste_vins($path){
	// retourne un tableau contenant les information des vins avec leur négociant et nombre en stocke
	// $path est le chemin de la base
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT vins.CRU, vins.COULEUR, vins.ORIGINE, negociants.NOM as 'NOM NEGOCIANT', negociants.REGION as 'REGION NEGOCIANT', cave.NB_BOUTEILLES as 'nombre de bouteilels en stock'
				FROM cave
				JOIN negociants ON negociants.noN=cave.noN
				JOIN vins on vins.noV=cave.noV";
	$resultat = $madb->query($requete);
	$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
	if (sizeof($tableau) != 0) { // vérification que le tableau ne soit pas vide (que la base est bien été lu)
		$retour = $tableau;
	}
	return $retour;
};

function get_liste_vins_one($path, $cru, $nego){
	// retourne un tableau contenant les information du vins qui a comme cru $cru et comme négociant $negociant avec leur négociant et nombre en stocke
	// $path est le chemin de la base
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT vins.CRU, vins.COULEUR, vins.ORIGINE, negociants.NOM as 'NOM NEGOCIANT', negociants.REGION as 'REGION NEGOCIANT', cave.NB_BOUTEILLES as 'nombre de bouteilles en stock'
				FROM cave
				JOIN negociants ON negociants.noN=cave.noN
				JOIN vins on vins.noV=cave.noV
				WHERE vins.CRU='$cru' AND negociants.NOM='$nego'";
	$resultat = $madb->query($requete);
	$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
	if (sizeof($tableau) != 0) { // vérification que le tableau ne soit pas vide (que la base est bien été lu)
		$retour = $tableau;
	}
	return $retour;
};

function get_element_list($path, $el){
	// retournes que les élément de la colone $el (ici utiliser pour avoir l'origine)
	// $path est le chemin de la base
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT DISTINCT ".$el." FROM vins";
	$resultat = $madb->query($requete);
	$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
	if (sizeof($tableau) != 0) { // vérification que le tableau ne soit pas vide (que la base est bien été lu)
		$retour = $tableau;
	}
	return $retour;
}

function get_element_by_name($path, $name){
	// retournes que l'élément où le cru = $name dans la base vins
	// $path est le chemin de la base
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT DISTINCT *
				FROM vins
				WHERE CRU='".$name."'";
	$resultat = $madb->query($requete);
	$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
	if (sizeof($tableau) != 0) { // vérification que le tableau ne soit pas vide (que la base est bien été lu)
		$retour = $tableau;
	}
	return $retour;
}

function get_negoc_by_name($path, $name){
	// retournes que l'élément où le NOM = $name dans la base négociant
	// $path est le chemin de la base
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT DISTINCT *
				FROM negociants
				WHERE NOM='".$name."'";
	$resultat = $madb->query($requete);
	$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
	if (sizeof($tableau) != 0) { // vérification que le tableau ne soit pas vide (que la base est bien été lu)
		$retour = $tableau;
	}
	return $retour;
}

function get_vins_by_origin($path, $origine){
	// retournes les vins avec un origine = $origine
	// $path est le chemin de la base
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT vins.CRU, vins.COULEUR, vins.ORIGINE, negociants.NOM as 'NOM NEGOCIANT', negociants.REGION as 'REGION NEGOCIANT', cave.NB_BOUTEILLES as 'nombre de bouteilels en stock'
				FROM cave
				JOIN negociants ON negociants.noN=cave.noN
				JOIN vins on vins.noV=cave.noV
				WHERE vins.ORIGINE='".$origine."'";
	$resultat = $madb->query($requete);
	$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
	if (sizeof($tableau) != 0) { // vérification que le tableau ne soit pas vide (que la base est bien été lu)
		$retour = $tableau;
	}
	return $retour;
}

function get_liste_vinsnegoc($path){
	// $path est le chemin de la base
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT vins.CRU, vins.COULEUR ,negociants.NOM, cave.NB_BOUTEILLES
				FROM cave
				JOIN negociants ON negociants.noN=cave.noN
				JOIN vins on vins.noV=cave.noV";
	$resultat = $madb->query($requete);
	$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
	if (sizeof($tableau) != 0) { // vérification que le tableau ne soit pas vide (que la base est bien été lu)
		$retour = $tableau;
	}
	return $retour;
};


function is_admin($mail, $path){
	// vérifie que l'adresse mail qui ce connecter est une adress administrateur
	// $path est le chemin de la base
	$liste_util=get_bdd_comptes($path);
	$retour=false;
	foreach ($liste_util as $key => $val){
		if ($mail == $val["EMAIL"] && $val["STATUT"] == "admin"){
			$retour = true;
		}
    }
	return $retour;
}

function test_connexion($mail, $pass, $path){
	// vérification que l'email existe bel et bien dans la base et que le mot de passe est bon
	// $path est le chemin de la base
	$liste_util=get_bdd_comptes($path);
	$retour="nomail";
	foreach ($liste_util as $key => $val){
		if ($mail == $val["EMAIL"] && $val["PASS"] == $pass){
			$retour = "ok";
		}
		elseif ($mail == $val["EMAIL"]){
			$retour = "nopass";
		}
    }
	return $retour;
}

function modif_element($path, $nb, $cru, $negoc){
	// modification du nombre de bouteilles dans la base
	// $path est le chemin de la base
	$retour = 0;
	$noV = get_element_by_name($path, $cru)[0]['noV']; // récupération de l'id du vin avec ce cru 
	$noN = get_negoc_by_name($path, $negoc)[0]['noN']; // récupération de l'id du négociant avec sont nom
	try {
		$madb = new PDO('sqlite:'.$path);
		$madb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $madb->prepare("UPDATE cave SET NB_BOUTEILLES = :NB_BOUTEILLES WHERE noV = :noV AND noN = :noN");
		// requette préparer
		$stmt->bindParam(':NB_BOUTEILLES', $nb);
		$stmt->bindParam(':noV', $noV);
		$stmt->bindParam(':noN', $noN);
		$stmt->execute();
		if ($stmt->rowCount() > 0) $retour = 1;
	} catch (PDOException $e) { // si la base n'a pas pue être modifier on renvoie le code d'erreur 
		$retour = 0;
	}
	return $retour;
}

function afficheTableau($tab){
	// affiche le tableau de la base vin
	echo '<div id="tableau">';
    echo '<table>';	
    echo '<tr>';
    foreach($tab[0] as $colonne => $valeur){
        echo "<th>$colonne</th>"; // affichage du header du tableau
    }
    echo "</tr>\n";

    foreach($tab as $ligne){
        echo '<tr>';
        foreach($ligne as $colonne => $cellule){
            if($colonne == 'CRU'){ // si la colone est cru alors on affiche une image
                echo "<td><img src='IMAGES/".$cellule.".jpg' width='100px'/>" . $cellule . "</td>";
            } else {
                echo "<td>" . $cellule . "</td>";
            }
        }
        echo "</tr>\n";
    }
    echo '</table>';
	echo '</div>';
}

?>
