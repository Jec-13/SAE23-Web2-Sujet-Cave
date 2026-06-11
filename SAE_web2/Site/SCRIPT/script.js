
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

function modifier(event, el, type) {
    event.preventDefault();
    const data = new FormData();
    data.append(el, document.getElementById(el).value);
    data.append('ajax', '1');

    fetch('?type=' + type, { method: 'POST', body: data })
    .then(r => r.text())
    .then(txt => {
        document.getElementById('tableau').outerHTML = txt;
    })
    .catch(e => console.error(e));
}

