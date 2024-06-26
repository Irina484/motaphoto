
// Déclenché l'ouverture de la modale //
document.addEventListener('DOMContentLoaded', function() {
    var contactLinks = document.querySelectorAll('.contact-link'); 
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
function toggleMenu() {
    const navMenu = document.getElementById('main-menu');
    navMenu.classList.toggle('visible');
}


// Les flèches de navigation //
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

// Requête Ajax front-page // 
jQuery(document).ready(function($) {
    // Fonction pour charger les photos
    function chargerPhotos(categorie = '', format = '', ordre = 'DESC', paged = 1, chargerPlus = false) {
        // Construire les données de la requête
        const data = new URLSearchParams();
        data.append('action', 'motaphoto_photos');
        data.append('categorie', categorie);
        data.append('format', format);
        data.append('ordre', ordre);
        data.append('paged', paged);

        // Utiliser fetch pour faire la requête
        fetch(motaphoto_ajax.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-WP-Nonce': motaphoto_ajax.nonce
            },
            body: data
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(response => {
            // Insérer la réponse dans #photo-container
            if (chargerPlus) {
                $('#photo-container').append(response);
            } else {
                $('#photo-container').html(response);
            }
        })
        .catch(error => {
            console.log('Error:', error);
            // Afficher un message d'erreur à l'utilisateur
            $('#photo-container').html('<p class="error-message">Erreur lors du chargement des photos. Veuillez réessayer.</p>');
        });
    }

    // Fonction pour initialiser le chargement des photos avec les filtres actuels
    function initChargementPhotos() {
        chargerPhotos($('#select-categorie').val(), $('#select-format').val(), $('#select-ordre').val(), 1);
    }

    // Gérer les changements de sélection de catégorie
    $('#select-categorie').on('change', function() {
        initChargementPhotos();
    });

    // Gérer les changements de sélection de format
    $('#select-format').on('change', function() {
        initChargementPhotos();
    });

    // Gérer les changements d'ordre de tri
    $('#select-ordre').on('change', function() {
        initChargementPhotos();
    });

    // Gérer le chargement de la page suivante
    $('#load-more-button').on('click', function(e) {
        e.preventDefault();
        var nextPage = parseInt($(this).data('paged')) + 1;
        chargerPhotos($('#select-categorie').val(), $('#select-format').val(), $('#select-ordre').val(), nextPage, true);
        $(this).data('paged', nextPage);
    });

    // Charger les photos au chargement initial de la page
    initChargementPhotos();
});


// Requête Ajax single-post // 
jQuery(document).ready(function($) {
    var photosPerPage = $('#photos-per-page').val();
    var categorieSlug = $('#categorie-slug').val();

    var data = new URLSearchParams({
        action: 'single_post',
        posts_per_page: photosPerPage,
        categorie_slug: categorieSlug,
        nonce: motaphoto_ajax.nonce
    });

    fetch(motaphoto_ajax.ajax_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: data
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text(); // Récupérer le texte HTML directement
    })
    .then(data => {
        var recommandationsImages = $('.recommandations_images');
        recommandationsImages.html(data); // Insérer le contenu HTML dans .recommandations_images
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });
});

jQuery(document).ready(function($) {
    $('.nav-link').hover(function() {
        var thumbnail = $(this).data('thumbnail');
        if (thumbnail) {
            $('#photo-preview-img').attr('src', thumbnail);
            $('.photo-preview').show();
        } else {
            $('.photo-preview').hide();
        }
    }, function() {
        $('.photo-preview').hide();
    });
});

