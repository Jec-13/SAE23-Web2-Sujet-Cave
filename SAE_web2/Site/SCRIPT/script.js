
function isEmailValid(email) {
    // vérification que le format de l'email est bon
    $retour = true;
    const regex = /^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,}$/; // adress email format caractères@caractères.lettres(2 ou +)
    if (!regex.test(email)) {
        ChangeDisplay('formatemail'); // si l'email n'est pas bon on affiche l'erreur et on renvoie false
        $retour = false;
    } else {
        document.getElementById('formatemail').style.display = 'none';
    }
    return $retour;
}

function ChangeDisplay(el) {
    // afficher les message d'erreur avec l'id el
    document.getElementById(el).style.display = 'block';
}

async function modifier(form, nego, cru, coord, nb_prec) {
    // form = le formulaire
    // nego = nom du négociant à modifier
    // cru = nom du cru à modifier
    // coord = coordonnée du bonne élément du capcha
    // nb_prec = nombre avant modification de bouteille

    // récupération du nombre de bouteilles et la case cocher
    let Nb_bouteilles = form.elements["Nb_bouteilles"].value;
    let scase = form.elements["case"].value;

    if (Nb_bouteilles==""){ // vérification que le champs bouteilles n'est pas vide
        ChangeDisplay('remp');
        document.getElementById('succès').style.display = 'none'; // pas de succès donc si avant il y en avait un on l'enlève
    } else if (scase==""){ // vérification qu'une case à bien été cliqué
        ChangeDisplay('ercap');
        document.getElementById('succès').style.display = 'none'; // pas de succès donc si avant il y en avait un on l'enlève
    } else if (Nb_bouteilles == nb_prec || Nb_bouteilles<0){ // vérification que le nombre de bouteille à modifier est bien différent de l'ancient et qu'il soit positif
        ChangeDisplay('erch');
        document.getElementById('succès').style.display = 'none'; // pas de succès donc si avant il y en avait un on l'enlève
    }
    else{
        try {
            const reponse = await fetch('INCLUDE/fetch_modif.php', { // construction de la requête fetch
                method: 'POST', // methode du formulaire
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "Nb_bouteilles="+Nb_bouteilles+"&NAME="+nego+"&CRU="+cru+"&scase="+scase+"&coord="+coord // element nécessaire pour la modification
            });

            const retour = await reponse.text(); // lecture de la réponse
            document.getElementById('resultat').innerHTML = retour; // affichage de la réponse dans la balise div id : resultat

            // on enlève les erreurs si on réussie
            document.getElementById('erch').style.display = 'none';
            document.getElementById('remp').style.display = 'none';
            document.getElementById('ercap').style.display = 'none';

            // on affiche le message de succès
            document.getElementById('succès').style.display = 'block';

        } catch (error) { // en cas d'erreur de la requête fetch on renvoie en console l'erreur
            console.error('Erreur :', error);
        }
    }
}

