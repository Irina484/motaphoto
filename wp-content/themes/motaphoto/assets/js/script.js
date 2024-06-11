
// Déclenché l'ouverture de la modale //
document.addEventListener('DOMContentLoaded', function() {
    var contactLinks = document.querySelectorAll('.contact-link, .btn-modale'); 
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

// menu burger //
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggle');
    const navMenu = document.getElementById('nav_header');

    toggleButton.addEventListener('click', function() {
        navMenu.classList.toggle('visible'); 
    });
});

// flèches de navigation //
(function($) {
  $(document).ready(function () {
      navigationPhotos($('.fleche-gauche'), $('.previous-image'));
      navigationPhotos($('.fleche-droite'), $('.next-image'));

      function navigationPhotos(arrow, image) {
          arrow.hover(
              function () {
                  image.css('opacity', '1');
              },
              function () {
                  image.css('opacity', '0');
              }
          );
      }
  });
})(jQuery);
