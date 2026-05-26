# TD7/TP7 - Requêtes asynchrones avec Fetch

Je vais compléter tous les fichiers pour réaliser les parties demandées.

## 3.3. Filtrage d'un tableau avec Fetch

### `index_ETU.php` (complété)

```php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="Fetch_ETU.js"></script>
    <title>Module WEB2 TD7 JS Fetch</title>
</head>
<body>
<header>
    <h1>Module WEB2 TD7 JS Fetch</h1>
    <h1>Lister les utilisateurs par ville avec fetch</h1>
</header>

<nav>
    <?php
        require('formulaires_ETU.php');
        require('fonctions_ETU.php');
        afficheFormulaireEtudiantParVille();
    ?>
</nav>

<article>
    <!-- Zone qui recevra la réponse fetch -->
    <div id="zone_resultat">
        <p>Sélectionnez une ville pour afficher les étudiants.</p>
    </div>
</article>

<footer>
    <p>IUT Lannion - Module WEB2</p>
</footer>

</body>
</html>
```

---

### `formulaires_ETU.php` (modifié - ajout onchange)

```php
<?php
function afficheFormulaireEtudiantParVille(){
    $madb = new PDO('sqlite:bdd/IUT.sqlite');   
    $requete = 'SELECT DISTINCT (e.insee), commune, cp 
                FROM etudiants e, villes v 
                WHERE e.insee=v.insee';
    $resultat = $madb->query($requete);
    $tableau_assoc = $resultat->fetchAll(PDO::FETCH_ASSOC);
?>

<form id="form1">
    <fieldset> 
        <label for="id_ville">Rechercher Etudiant par Ville</label> 
        <select id="id_ville" 
                name="ville" 
                size="1"  
                onchange="listeFiltreUtilisateurs(this.value)">
            <option value="0">Choisir une Ville</option>
            <?php
            foreach ($tableau_assoc as $ligne) {   
                echo '<option value="' . $ligne["insee"] . '">'
                   . $ligne["cp"] . " " 
                   . $ligne["commune"] 
                   . "</option>\n";         
            }
            ?>
        </select>
    </fieldset>
</form>
<br/>

<?php
}// fin afficheFormulaireEtudiantParVille
?>
```

---

### `Fetch_ETU.js` (complété)

```javascript
/*****************************************************************/
/*
 * Fonction déclenchée lors du changement de sélection dans le <select>
 * @param {string} ville - le code insee de la ville sélectionnée
 */
async function listeFiltreUtilisateurs(ville) {

    // Si l'utilisateur choisit "Choisir une Ville" on ne fait rien
    if (ville === "0") {
        document.getElementById("zone_resultat").innerHTML = 
            "<p>Sélectionnez une ville pour afficher les étudiants.</p>";
        return;
    }

    try {
        // 1. On prépare les paramètres à envoyer en POST
        const parametres = new URLSearchParams();
        parametres.append("choix", ville);

        // 2. On lance la requête fetch vers le script PHP
        const reponse = await fetch("listeUtilisateurs_ETU.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: parametres
        });

        // 3. On vérifie que la requête s'est bien passée
        if (!reponse.ok) {
            throw new Error("Erreur HTTP : " + reponse.status);
        }

        // 4. On récupère la réponse en texte HTML
        const texteHTML = await reponse.text();

        // 5. On insère le résultat dans la zone dédiée de la page
        document.getElementById("zone_resultat").innerHTML = texteHTML;

    } catch (error) {
        console.error("Erreur fetch :", error);
        document.getElementById("zone_resultat").innerHTML = 
            "<p style='color:red;'>Erreur lors de la récupération des données.</p>";
    }

} // fin fonction listeFiltreUtilisateurs()
```

---

### `listeUtilisateurs_ETU.php` (complété)

```php
<?php

require('fonctions_ETU.php');

if (!empty($_POST) && isset($_POST["choix"])) {
    
    // On récupère le code insee envoyé en POST
    $insee = $_POST["choix"];
    
    // On appelle la fonction qui retourne le tableau des étudiants
    $tableau = listeEtudiantParVille($insee);
    
    // Si le tableau contient des données on l'affiche
    if ($tableau) {
        afficheTableau($tableau);
    } else {
        echo "<p>Aucun étudiant trouvé pour cette ville.</p>";
    }

} else {
    echo "<p>Erreur : paramètre manquant.</p>";
}
?>
```

---

### `fonctions_ETU.php` (complété)

```php
<?php

/************************************************************
 * Affiche un tableau HTML à partir d'un tableau PHP associatif
 ************************************************************/
function afficheTableau($tab) {
    echo '<table>';
    // En-têtes : on lit les clés du premier élément
    echo '<tr>';
    foreach ($tab[0] as $colonne => $valeur) {
        echo "<th>$colonne</th>";
    }
    echo "</tr>\n";

    // Corps du tableau
    foreach ($tab as $ligne) {
        echo '<tr>';
        foreach ($ligne as $cellule) {
            echo "<td>$cellule</td>";
        }
        echo "</tr>\n";
    }
    echo '</table>';
}

/************************************************************
 * Retourne la liste des étudiants habitant dans la ville
 * dont le code insee est passé en paramètre
 * @param {string} $insee - code insee de la ville
 * @return {array|false} - tableau associatif ou false
 ************************************************************/
function listeEtudiantParVille($insee) {
    $retour = false;

    try {
        // Connexion à la base de données SQLite
        $madb = new PDO('sqlite:bdd/IUT.sqlite');

        // Activation des exceptions PDO pour gérer les erreurs
        $madb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête préparée pour éviter les injections SQL
        $requete = $madb->prepare(
            'SELECT e.nom, e.prenom, v.commune, v.cp 
             FROM etudiants e 
             JOIN villes v ON e.insee = v.insee 
             WHERE e.insee = :insee'
        );

        // On lie le paramètre et on exécute
        $requete->bindParam(':insee', $insee, PDO::PARAM_STR);
        $requete->execute();

        // On récupère tous les résultats
        $tableau = $requete->fetchAll(PDO::FETCH_ASSOC);

        // Si le tableau n'est pas vide on le retourne
        if (!empty($tableau)) {
            $retour = $tableau;
        }

    } catch (PDOException $e) {
        echo "Erreur BDD : " . $e->getMessage();
    }

    return $retour;
}

?>
```

---

## 4. Météo de la ville

### `get-weather.html` (complété)

```html
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="get-weather.js"></script>
    <title>Météo ETU 2025-2026</title>
</head>
<body>
    <header>
        <h1>Météo ETU 2025-2026</h1>
    </header>

    <article>
        <!-- Formulaire de saisie de la ville -->
        <form id="form_meteo">
            <fieldset>
                <label for="id_ville">Saisir une ville :</label>
                <input type="text" 
                       id="id_ville" 
                       name="ville" 
                       placeholder="Ex: Lannion" />
                <button type="button" onclick="afficherMeteo()">
                    Voir la météo
                </button>
            </fieldset>
        </form>

        <br/>

        <!-- Zone d'affichage des résultats -->
        <div id="zone_meteo"></div>
    </article>

</body>
</html>
```

---

### `get-weather.js` (complété)

```javascript
// 0. Clé API générée depuis https://home.openweathermap.org/api_keys
var API_KEY = '034f371f42a06e2c2d11bc4ec55f0996';

/************************************************************
 * Fonction déclenchée au clic sur le bouton
 * Récupère la ville saisie et lance la requête fetch météo
 ************************************************************/
async function afficherMeteo() {

    // 1. On récupère la valeur saisie dans le champ texte
    const ville = document.getElementById("id_ville").value;

    // 2. On vérifie que le champ n'est pas vide
    if (ville.trim() === "") {
        document.getElementById("zone_meteo").innerHTML = 
            "<p style='color:red;'>Veuillez saisir une ville.</p>";
        return;
    }

    // 3. Affichage dans la console pour vérification
    console.log("Ville saisie :", ville);

    // 4. Construction de l'URL de l'API OpenWeatherMap
    //    units=metric pour avoir la température en Celsius
    //    lang=fr pour les descriptions en français
    const url = `https://api.openweathermap.org/data/2.5/weather?q=${ville}&appid=${API_KEY}&units=metric&lang=fr`;

    console.log("URL requête :", url);

    try {
        // 5. Lancement de la requête fetch (GET par défaut)
        const reponse = await fetch(url);

        // 6. Vérification que la requête a réussi
        if (!reponse.ok) {
            throw new Error("Ville introuvable ou erreur API (code " + reponse.status + ")");
        }

        // 7. On parse la réponse JSON (BONUS)
        const donnees = await reponse.json();

        // Affichage brut dans la console
        console.log("Réponse API :", donnees);

        // 8. Extraction des informations utiles
        const nomVille      = donnees.name;
        const pays          = donnees.sys.country;
        const temperature   = donnees.main.temp;        // en °C grâce à units=metric
        const tempRessentie = donnees.main.feels_like;
        const tempMin       = donnees.main.temp_min;
        const tempMax       = donnees.main.temp_max;
        const humidite      = donnees.main.humidity;
        const description   = donnees.weather[0].description;
        const icone         = donnees.weather[0].icon;
        const iconUrl       = `https://openweathermap.org/img/wn/${icone}@2x.png`;

        // 9. Affichage dans la page
        document.getElementById("zone_meteo").innerHTML = `
            <h2>Météo à ${nomVille} (${pays})</h2>
            <img src="${iconUrl}" alt="${description}" />
            <p><strong>Description :</strong> ${description}</p>
            <p><strong>Température :</strong> ${temperature} °C</p>
            <p><strong>Température ressentie :</strong> ${tempRessentie} °C</p>
            <p><strong>Min / Max :</strong> ${tempMin} °C / ${tempMax} °C</p>
            <p><strong>Humidité :</strong> ${humidite} %</p>
        `;

    } catch (error) {
        console.error("Erreur :", error);
        document.getElementById("zone_meteo").innerHTML = 
            `<p style='color:red;'>Erreur : ${error.message}</p>`;
    }
}
```

---

## Schéma récapitulatif du fonctionnement Fetch (partie 3.3)

```
┌─────────────────────────────────────────────────────────┐
│                    NAVIGATEUR CLIENT                     │
│                                                          │
│  index_ETU.php                                          │
│  ┌─────────────────────────────────────────────────┐   │
│  │  <select onchange="listeFiltreUtilisateurs()">  │   │
│  │                                                  │   │
│  │  <div id="zone_resultat">  ◄── résultat HTML    │   │
│  └─────────────────────────────────────────────────┘   │
│                        │                                 │
│              Fetch_ETU.js                               │
│         fetch POST (choix=insee)                        │
└─────────────────────────┼───────────────────────────────┘
                          │ HTTP POST
                          ▼
┌─────────────────────────────────────────────────────────┐
│                    SERVEUR PHP                           │
│                                                          │
│  listeUtilisateurs_ETU.php                              │
│    → reçoit $_POST["choix"]                             │
│    → appelle listeEtudiantParVille($insee)              │
│    → appelle afficheTableau($tableau)                   │
│    → retourne du HTML au client                         │
└─────────────────────────────────────────────────────────┘
```