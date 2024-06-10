document.addEventListener('DOMContentLoaded', function() {
    var contactLinks = document.querySelectorAll('.contact-link, .btn-modale'); // Ajoutez d'autres classes ici
    var modal = document.getElementById('myModal');

    contactLinks.forEach(function(contactLink) {
        contactLink.addEventListener('click', function(event) {
            event.preventDefault();
            if (modal) {
                modal.style.display = 'block';
                var reference = document.getElementById('reference-photo').innerText;
                // Utilisation de jQuery pour pré-remplir le champ
                jQuery('#photo_ref').val(reference);
            }
        });
    });

    // Fermer la modale lorsqu'on clique en dehors du contenu de la modale
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});

