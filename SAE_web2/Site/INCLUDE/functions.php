<?php
function get_bdd_comptes($path){
	$retour = false;
		$madb = new PDO('sqlite:'.$path);
		$requete = "SELECT u.EMAIL, u.PASS, u.STATUT
		            FROM utilisateurs u";
		$resultat = $madb->query($requete);
		$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
		if (sizeof($tableau) != 0) {
			$retour = $tableau;
		}
		return $retour;
};

function get_liste_vins($path){
	$retour = false;
		$madb = new PDO('sqlite:'.$path);
		$requete = "SELECT vins.CRU, vins.COULEUR, vins.ORIGINE, negociants.NOM as 'NOM NEGOCIANT', negociants.REGION as 'REGION NEGOCIANT'
		            FROM cave
					JOIN negociants ON negociants.noN=cave.noN
					JOIN vins on vins.noV=cave.noV";
		$resultat = $madb->query($requete);
		$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
		if (sizeof($tableau) != 0) {
			$retour = $tableau;
		}
		return $retour;
};

function is_admin($mail, $path){
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

function afficheTableau($tab){
    echo '<table>';	
    echo '<tr>';
    foreach($tab[0] as $colonne => $valeur){
        echo "<th>$colonne</th>";
    }
    echo "</tr>\n";

    foreach($tab as $ligne){
        echo '<tr>';
        foreach($ligne as $colonne => $cellule){
            if($colonne == 'CRU'){
                echo "<td><img src='IMAGES/".$cellule.".jpg' width='100px'/>" . $cellule . "</td>";
            } else {
                echo "<td>" . $cellule . "</td>";
            }
        }
        echo "</tr>\n";
    }
    echo '</table>';
}

?>
