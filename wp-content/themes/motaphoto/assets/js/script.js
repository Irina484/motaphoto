
// Déclenché l'ouverture de la modale de contact //
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

    // Fermer la modale de contact lorsqu'on clique en dehors du contenu de la modale
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});

// Menu burger pour le responsive //
document.addEventListener('DOMContentLoaded', function() {
    const burgerButton = document.querySelector('.burger-button');
    const mobileMenu = document.querySelector('.mobile-menu');
    const body = document.body; // Sélectionner le body directement

    burgerButton.addEventListener('click', function() {
        mobileMenu.classList.toggle('active');
        burgerButton.classList.toggle('open');
        body.classList.toggle('no-scroll'); // Ajouter ou supprimer la classe no-scroll du body
    });
});




const LightboxModule = (function() {
    let currentPhotoIndex = 0;
    let photosArray = [];

    function openLightbox(photo, index) {
        currentPhotoIndex = index;

        const lightbox = document.querySelector('.lightbox');
        const lightboxImage = lightbox.querySelector('.lightbox-image');
        const lightboxReference = lightbox.querySelector('.lightbox-reference');
        const lightboxCategories = lightbox.querySelector('.lightbox-categories');
        const spinner = lightbox.querySelector('.spinner');

        spinner.style.display = 'block';
        lightboxImage.style.display = 'none';

        lightboxImage.src = photo.thumbnail;
        lightboxImage.alt = photo.title;
        lightboxReference.textContent = photo.reference;
        lightboxCategories.textContent = photo.categories;
        lightbox.classList.add('open');

        lightboxImage.onload = () => {
            spinner.style.display = 'none';
            lightboxImage.style.display = 'block';
        };

        lightboxImage.onerror = () => {
            spinner.style.display = 'none';
        };
    }

    function afficherPhotoPrecedente() {
        if (currentPhotoIndex > 0) {
            currentPhotoIndex--;
            openLightbox(photosArray[currentPhotoIndex], currentPhotoIndex);
        }
    }

    function afficherPhotoSuivante() {
        if (currentPhotoIndex < photosArray.length - 1) {
            currentPhotoIndex++;
            openLightbox(photosArray[currentPhotoIndex], currentPhotoIndex);
        }
    }

    function initLightboxEvents() {
        document.querySelector('.lightbox-prev').addEventListener('click', afficherPhotoPrecedente);
        document.querySelector('.lightbox-next').addEventListener('click', afficherPhotoSuivante);
        document.querySelector('.lightbox-close').addEventListener('click', () => {
            document.querySelector('.lightbox').classList.remove('open');
        });

        document.querySelector('.lightbox').addEventListener('click', (event) => {
            if (event.target === event.currentTarget) {
                event.currentTarget.classList.remove('open');
            }
        });
    }

    function setPhotosArray(array) {
        photosArray = array;
    }

    return {
        openLightbox,
        initLightboxEvents,
        setPhotosArray
    };
})();

const SurvolModule = (function(LightboxModule) {

    function survolEffets(photoElement, photo, index) {
        photoElement.querySelector('.img-photo').addEventListener('click', function() {
            LightboxModule.openLightbox(photo, index);
        });

        photoElement.querySelector('.info-icon').addEventListener('click', function(event) {
            event.stopPropagation();
            showPhotoInfo(photo);
        });

        photoElement.querySelector('.fullscreen-icon').addEventListener('click', function(event) {
            event.stopPropagation();
            LightboxModule.openLightbox(photo, index);
        });
    }

    function showPhotoInfo(photo) {
        window.location.href = photo.permalink;
    }

    return {
        survolEffets,
        showPhotoInfo
    };
})(LightboxModule);

// Requête Ajax front-page
jQuery(document).ready(function($) {
    // Initialisation des variables
    let photosPerPage = $('#photos-per-page').val();
    let categorieSlug = $('#categorie-slug').val() || '';
    let formatSlug = $('#format-slug').val() || '';
    let orderBy = $('#select-ordre').val() || 'DESC';
    let page = 0;
    let photosArray = [];

    // Fonction pour charger la page suivante
    function loadnextPage(reset = false) {
        if (reset) {
            page = 0;
            photosArray = [];
            $('.photo_type').empty();
        } else {
            page++;
        }

        let data = new URLSearchParams({
            action: 'frontpage_photo',
            posts_per_page: photosPerPage,
            categorie_slug: categorieSlug,
            format_slug: formatSlug,
            page: page,
            security: motaphoto_ajax.nonce
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
            return response.json();
        })
        .then(data => {
            if (data.success) {
                photosArray = photosArray.concat(data.data);
                LightboxModule.setPhotosArray(photosArray);
                sortPhotos(orderBy);
            } else {
                console.error('Error:', data.data);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    }

    // Fonction pour générer les photos
    function generatePhotos(photos, containerSelector = '.photo_type') {
        const container = $(containerSelector);
        container.empty();
        photos.forEach((photo, index) => {
            const photoBlock = $(`
                <div class="photo-post">
                    <div class="photo-container">
                        <img class="img-photo" 
                            src="${photo.thumbnail}" 
                            alt="${photo.title}" 
                            data-ref="${photo.reference}"
                            data-categorie="${photo.categories}" />
                        <div class="photo-overlay">
                            <div class="info-icon">i</div>
                            <div class="fullscreen-icon">⤢</div>
                        </div>
                    </div>
                </div>
            `);
            container.append(photoBlock);
            SurvolModule.survolEffets(photoBlock[0], photo, index);
        });
    }

    // Fonction pour trier les photos
    function sortPhotos(orderBy) {
        if (orderBy === 'ASC') {
            photosArray.sort((a, b) => new Date(a.date) - new Date(b.date));
        } else if (orderBy === 'DESC') {
            photosArray.sort((a, b) => new Date(b.date) - new Date(a.date));
        }
        generatePhotos(photosArray);
    }

    // Charger la première page au démarrage
    loadnextPage(true);

    // Gestion des événements
    $('#load-more-button').on('click', function() {
        loadnextPage();
    });

    $('#select-categorie').on('change', function() {
        categorieSlug = $(this).val();
        $('#categorie-slug').val(categorieSlug);
        loadnextPage(true);
    });

    $('#select-format').on('change', function() {
        formatSlug = $(this).val();
        $('#format-slug').val(formatSlug);
        loadnextPage(true);
    });

    $('#select-ordre').on('change', function() {
        orderBy = $(this).val();
        sortPhotos(orderBy);
    });

    LightboxModule.initLightboxEvents();

    // Requête Ajax single_photo
    function loadSinglePhoto() {
        let data = new URLSearchParams({
            action: 'single_photo',
            posts_per_page: photosPerPage,
            categorie_slug: categorieSlug,
            security: motaphoto_ajax.nonce
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
            return response.json();
        })
        .then(data => {
            if (data.success) {
                let singlePhotosArray = data.data;
                LightboxModule.setPhotosArray(singlePhotosArray);
                generatePhotos(singlePhotosArray, '.recommandations_images');
            } else {
                console.error('Error:', data.data);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    }

    // Charger les photos initialement pour single_photo
    loadSinglePhoto();
});


  (function ($) {
    'use strict'; 
    $(document).ready(function() {
        // Lorsqu'une option est sélectionnée
        $('#select-categorie').change(function() {
          // Supprimer la classe "selected" de toutes les options
          $('.js-categorie').removeClass('selected');
          // Ajouter la classe "selected" à l'option sélectionnée
          $(this).find(':selected').addClass('selected');
        });
        $('#select-format').change(function() {
          // Supprimer la classe "selected" de toutes les options
          $('.js-format').removeClass('selected');
          // Ajouter la classe "selected" à l'option sélectionnée
          $(this).find(':selected').addClass('selected');
        });
      });
      $('.contact-link').click(function () {
        $('.burger-button').removeClass("open");
        $('.mobile-menu').removeClass("active");
    });
  })(jQuery);