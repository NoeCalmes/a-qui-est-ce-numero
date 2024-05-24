function toggleReplyForm(formId) {
    var form = document.getElementById(formId);
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

function cancelReply(formId) {
    var form = document.getElementById(formId);
    form.style.display = 'none';
}


/* COCHER INPUT RADIO  */


/* INPUT RADIO DEBUT */
function cocherRadio(idRadio) {
    // Désélectionnez tous les radios du même nom
    document.querySelectorAll('input[name="rating"]').forEach(function (radio) {
        radio.checked = false;
        radio.parentNode.classList.remove('checked');
    });

    // Cochez le radio avec l'id spécifié
    const radio = document.getElementById(idRadio);
    radio.checked = true;
    radio.parentNode.classList.add('checked');

    // Ajoutez une classe spéciale au label lorsque le radio est coché
    document.querySelectorAll('.form-check-label').forEach(function (label) {
        label.classList.remove('checked-label');
    });
    const label = radio.parentNode.querySelector('.form-check-label');
    label.classList.add('checked-label');
}

/* INPUT RADIO FIN */

/* FERMER FOMULAIRE REPONSE SI DEJA OUVERT DEBUT */
function toggleReplyForm(formId) {
    var form = document.getElementById(formId);

    // Fermez tous les formulaires de réponse
    document.querySelectorAll('.reponse-form').forEach(function (otherForm) {
        otherForm.style.display = 'none';
    });

    // Basculez l'affichage du formulaire associé au commentaire cliqué
    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
}

/* FERMER FOMULAIRE REPONSE SI DEJA OUVERT FIN */

/* FAQ OUVRIR ET FERMER */
document.addEventListener("DOMContentLoaded", function () {
    const faqQuestions = document.querySelectorAll(".faq-question");

    faqQuestions.forEach(function (faqQuestion) {
        faqQuestion.addEventListener("click", function () {
            const faqAnswer = this.nextElementSibling;

            // Toggle the max-height to show/hide the answer with a slide effect
            if (faqAnswer.style.maxHeight) {
                faqAnswer.style.maxHeight = null;
            } else {
                faqAnswer.style.maxHeight = faqAnswer.scrollHeight + "px";
            }

            // Rotate the chevron icon
            const faqIcon = this.querySelector(".faq-icon i");
            faqIcon.classList.toggle("fa-chevron-down");
            faqIcon.classList.toggle("fa-chevron-up");
        });
    });
});


/* RADIO NIVEAU DE DANGER DEBUT */

document.addEventListener('DOMContentLoaded', function () {
    // Sélectionner l'élément du bouton "Neutre" par défaut
    var neutreButton = document.querySelector('.form-check.neutre');
    var neutreRadio = document.getElementById('neutre');

    // Ajouter la classe "checked" au bouton "Neutre" et à son radio correspondant
    neutreButton.classList.add('checked');
    neutreRadio.checked = true;

    // Ajouter un écouteur d'événements sur chaque radio
    var radios = document.getElementsByName('rating');
    radios.forEach(function (radio) {
        radio.addEventListener('click', function () {
            // Retirer la classe spéciale de tous les radios
            radios.forEach(function (r) {
                r.parentNode.classList.remove('checked');
            });

            // Ajouter la classe spéciale au radio sélectionné
            if (this.checked) {
                this.parentNode.classList.add('checked');
            }
        });
    });
});
/* RADIO NIVEAU DE DANGER FIN */


/* FILTRE DEBUT */
document.addEventListener('DOMContentLoaded', function () {
    var choixFiltres = document.querySelectorAll('.choix-filtre');
    var resetFilters = document.querySelectorAll('.reset-filter');

    // Ajoutez un gestionnaire d'événements à chaque filtre
    choixFiltres.forEach(function (filtre) {
        filtre.addEventListener('click', function () {
            choixFiltres.forEach(function (autreFiltre) {
                autreFiltre.classList.remove('active');
            });

            filtre.classList.add('active');
            var choix = filtre.getAttribute('data-choix');
            filtrerEtAfficherCommentaires(choix);
        });
    });

    resetFilters.forEach(function (resetFilter) {
        resetFilter.addEventListener('click', function () {
            console.log('Clic sur la croix');
            window.location.reload();
        });
    });

    // Fonction pour filtrer et afficher les commentaires
    function filtrerEtAfficherCommentaires(choix) {
        console.log('Filtrage avec choix :', choix);
        // Sélectionnez tous les commentaires
        var commentaires = document.querySelectorAll('.blocseparation');


        commentaires.forEach(function (commentaire) {
            var choixCommentaire = commentaire.querySelector('.niveaudanger').textContent.trim().toLowerCase();
            if (choix === 'tous' || choix === choixCommentaire) {
                commentaire.style.display = 'block';

                var sousCommentaires = commentaire.querySelector('.sous-com');
                if (sousCommentaires) {
                    sousCommentaires.style.display = 'block';
                }
            } else {
                commentaire.style.display = 'none';
            }
        });
    }
});

/* FILTRE FIN */


