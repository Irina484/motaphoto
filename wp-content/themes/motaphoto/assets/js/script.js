
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


// Requête Ajax single_photo // 
jQuery(document).ready(function($) {
    let photosPerPage = $('#photos-per-page').val();
    let categorieSlug = $('#categorie-slug').val();
    let data = new URLSearchParams({
        action: 'single_photo',
        posts_per_page: photosPerPage,
        categorie_slug: categorieSlug,
        security: motaphoto_ajax.nonce
    });

    console.log(motaphoto_ajax.nonce);

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
        return response.json();
    })
    .then(data => {
        if (data.success) {
            let photos = data.data;
            console.log(photos);

            photos.forEach((photo, index) => {
                // Création de l'élément de photo
                let photoElement = document.createElement('div');
                photoElement.classList.add('photo-post');
                photoElement.innerHTML = `
                    <div class="photo-container">
                        <img class="img-photo"
                            src="${photo.thumbnail}"
                            alt="${photo.title}"
                            data-index="${index}"
                            data-ref="${photo.reference}"
                            data-categorie="${photo.categories}"
                        />
                        <div class="photo-overlay">
                            <div class="icon info-icon" title="Voir les informations"></div>
                            <div class="icon fullscreen-icon" title="Afficher en plein écran"></div>
                        </div>
                    </div>
                `;

                // Ajout de la photo au DOM
                document.querySelector('.recommandations_images').appendChild(photoElement);

                // Attacher les événements de survol et de clic à la photo
                attachHoverActions(photoElement, photo, index);
            });

            // Mise à jour des photos dans la lightbox
            lightbox.setPhotos(photos);
        } else {
            console.error('Error:', data.data);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });

    // Fonction pour attacher les événements de survol et de clic aux éléments de photo
    function attachHoverActions(photoElement, photo, index) {
        // Attacher un événement de clic à la photo pour ouvrir la lightbox
        photoElement.querySelector('.img-photo').addEventListener('click', function() {
            lightbox.openLightbox(index);
        });

        // Attacher un événement au survol de la photo pour afficher les icônes
        photoElement.addEventListener('mouseenter', function() {
            photoElement.querySelector('.photo-overlay').classList.add('show');
        });

        photoElement.addEventListener('mouseleave', function() {
            photoElement.querySelector('.photo-overlay').classList.remove('show');
        });

        // Attacher un événement de clic à l'icône d'informations
        photoElement.querySelector('.info-icon').addEventListener('click', function(event) {
            event.stopPropagation(); // Empêche la propagation du clic à l'image parente
            showPhotoInfo(photo);
        });

        // Attacher un événement de clic à l'icône de plein écran
        photoElement.querySelector('.fullscreen-icon').addEventListener('click', function(event) {
            event.stopPropagation(); // Empêche la propagation du clic à l'image parente
            openFullScreen(photo);
        });
    }

    // Fonction pour afficher les informations de la photo
    function showPhotoInfo(photo) {
        console.log(`Informations de la photo :`);
        console.log(`Titre : ${photo.title}`);
        console.log(`Référence : ${photo.reference}`);
        console.log(`Catégories : ${photo.categories}`);
    }

    // Fonction pour ouvrir la photo en plein écran dans une lightbox
    function openFullScreen(photo) {
        console.log(`Affichage de la photo en plein écran :`);
        console.log(`URL de la photo : ${photo.thumbnail}`);
        // Ajoutez ici votre code pour ouvrir la lightbox en plein écran
    }
});
