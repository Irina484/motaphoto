
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

// menu burger pour le responsive //
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




// Requête Ajax front-page // 

jQuery(document).ready(function($) {
    let photosPerPage = $('#photos-per-page').val();
    let categorieSlug = $('#categorie-slug').val() || '';
    let formatSlug = $('#format-slug').val() || '';
    let orderBy = $('#select-ordre').val() || 'DESC';
    let page = 0;
    let photosArray = [];

    function photosPagin(reset = false) {
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
                sortPhotos(orderBy);
            } else {
                console.error('Error:', data.data);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    }

    function generatePhotos(photos) {
        const container = $('.photo_type');
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
            survolEffets(photoBlock[0], photo, index);
        });
    }

    function survolEffets(photoElement, photo, index) {
        photoElement.querySelector('.img-photo').addEventListener('click', function() {
            openLightbox(photo, index);
        });
        photoElement.querySelector('.info-icon').addEventListener('click', function(event) {
            event.stopPropagation();
            showPhotoInfo(photo);
        });
        photoElement.querySelector('.fullscreen-icon').addEventListener('click', function(event) {
            event.stopPropagation();
            openLightbox(photo, index);
        });
    }

    function showPhotoInfo(photo) {
        window.location.href = photo.permalink;
    }

    let currentPhotoIndex = 0;

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

    $('#select-categorie').on('change', function() {
        categorieSlug = $(this).val();
        $('#categorie-slug').val(categorieSlug);
        photosPagin(true);
    });

    $('#select-format').on('change', function() {
        formatSlug = $(this).val();
        $('#format-slug').val(formatSlug);
        photosPagin(true);
    });

    $('#select-ordre').on('change', function() {
        orderBy = $(this).val();
        sortPhotos(orderBy);
    });

    function sortPhotos(orderBy) {
        if (orderBy === 'ASC') {
            photosArray.sort((a, b) => new Date(a.date) - new Date(b.date));
        } else if (orderBy === 'DESC') {
            photosArray.sort((a, b) => new Date(b.date) - new Date(a.date));
        }
        generatePhotos(photosArray);
    }

    photosPagin(true);

    $('#load-more-button').on('click', function() {
        photosPagin();
    });
});



// Requête Ajax single_photo // 
jQuery(document).ready(function($) {
    let photosPerPage = $('#photos-per-page').val();
    let categorieSlug = $('#categorie-slug').val();
    let photosArray = []; // Initialisation globale

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
            photosArray = data.data; // Mise à jour avec les photos récupérées
            generatePhotos(photosArray);
        } else {
            console.error('Error:', data.data);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });

    function generatePhotos(photos) {
        const container = $('.recommandations_images');
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

            // Attacher les effets de survol et autres événements
            survolEffets(photoBlock[0], photo, index);
        });
    }

    function survolEffets(photoElement, photo, index) {
        photoElement.querySelector('.img-photo').addEventListener('click', function() {
            openLightbox(photo, index);
        });

        photoElement.querySelector('.info-icon').addEventListener('click', function(event) {
            event.stopPropagation();
            showPhotoInfo(photo);
        });

        photoElement.querySelector('.fullscreen-icon').addEventListener('click', function(event) {
            event.stopPropagation();
            openLightbox(photo, index);
        });
    }

    function showPhotoInfo(photo) {
        window.location.href = photo.permalink; // Redirige vers la page de la photo
    }

    // Fonction pour ouvrir la photo en plein écran dans une lightbox
    let currentPhotoIndex = 0;

function openLightbox(photo, index) {
    currentPhotoIndex = index;

    const lightbox = document.querySelector('.lightbox');
    const lightboxImage = lightbox.querySelector('.lightbox-image');
    const lightboxReference = lightbox.querySelector('.lightbox-reference');
    const lightboxCategories = lightbox.querySelector('.lightbox-categories');
    const spinner = lightbox.querySelector('.spinner');

    // Afficher le spinner
    spinner.style.display = 'block';

    // Cacher l'image jusqu'à ce qu'elle soit chargée
    lightboxImage.style.display = 'none';

    lightboxImage.src = photo.thumbnail;
    lightboxImage.alt = photo.title;
    lightboxReference.textContent = photo.reference;
    lightboxCategories.textContent = photo.categories;
    lightbox.classList.add('open');

    // Attendre que l'image soit complètement chargée
    lightboxImage.onload = () => {
        // Cacher le spinner
        spinner.style.display = 'none';

        // Afficher l'image
        lightboxImage.style.display = 'block';
    };

    // Gérer le cas où l'image ne peut pas être chargée
    lightboxImage.onerror = () => {
        // Cacher le spinner même si l'image ne se charge pas
        spinner.style.display = 'none';
        // Vous pouvez également afficher un message d'erreur ici si nécessaire
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

document.querySelector('.lightbox-prev').addEventListener('click', afficherPhotoPrecedente);
document.querySelector('.lightbox-next').addEventListener('click', afficherPhotoSuivante);
document.querySelector('.lightbox-close').addEventListener('click', () => {
    document.querySelector('.lightbox').classList.remove('open');
});

// Fermeture de la lightbox lorsqu'on clique en dehors du contenu
document.querySelector('.lightbox').addEventListener('click', (event) => {
    if (event.target === event.currentTarget) {
        event.currentTarget.classList.remove('open');
    }
});

});


