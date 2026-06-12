
function isEmailValid(email) {
    $retour = true;
    const regex = /^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,}$/;
    if (!regex.test(email)) {
        ChangeDisplay('formatemail');
        $retour = false;
    } else {
        document.getElementById('formatemail').style.display = 'none';
    }
    return $retour;
}

function ChangeDisplay(el) {
    document.getElementById(el).style.display = 'block';
}

async function modifier(form, nego, cru, coord, nb_prec) {

    let Nb_bouteilles = form.elements["Nb_bouteilles"].value;

    let scase = form.elements["case"].value;

    console.log(form.elements["case"].value);

    if (Nb_bouteilles==""){
        ChangeDisplay('remp');
    } else if (scase=="" || coord !== scase){
        ChangeDisplay('ercap');
    } else if (Nb_bouteilles == nb_prec){
        ChangeDisplay('erch');
    }
    else{
        try {

            const reponse = await fetch('INCLUDE/fetch_modif.php', {
                method: 'POST',
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "Nb_bouteilles="+Nb_bouteilles+"&NAME="+nego+"&CRU="+cru
            });

            const retour = await reponse.text();
            document.getElementById('resultat').innerHTML = retour;
            console.log(reponse);

        } catch (error) {
            console.error('Erreur :', error);
        }
    }
}

