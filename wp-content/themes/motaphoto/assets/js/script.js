

document.addEventListener('DOMContentLoaded', function() {
    var contactLink = document.querySelector('.contact-link');
    var modal = document.getElementById('myModal');
    if (contactLink) {
        contactLink.addEventListener('click', function(event) {
            event.preventDefault();
            if (modal) {
                modal.style.display = 'block';
            }
        });
    }

    // Fermer la modale lorsqu'on clique en dehors du contenu de la modale
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});

