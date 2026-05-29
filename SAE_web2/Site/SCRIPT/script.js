
document.addEventListener('DOMContentLoaded', function () {
    const mailInput = document.getElementById('id_mail');
    if (mailInput) {
        mailInput.addEventListener('blur', function () {
            checkMailFetch(this.value);
        });
    }
});

let mailValide = false;

function checkMailFetch(email) {
    document.getElementById('formatemail').style.display = 'none';
    document.getElementById('noemail').style.display = 'none';

    if (email === '') {
        mailValide = false;
        return;
    }

    const formData = new FormData();
    formData.append('mail', email);

    fetch('INCLUDE/check_mail.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.valid) {
            mailValide = true;
        } else {
            mailValide = false;
            if (data.message === 'format') {
                document.getElementById('formatemail').style.display = 'block';
            } else if (data.message === 'nomail') {
                document.getElementById('noemail').style.display = 'block';
            }
        }
    })
    .catch(error => {
        console.error('Erreur fetch :', error);
        mailValide = false;
    });
}

function isEmailValid(email) {
    if (!mailValide) {
        checkMailFetch(email);
        return false;
    }
    return true;
}

function ChangeDisplay(el) {
    document.getElementById(el).style.display = 'block';
}
