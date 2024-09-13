//---------------------------------------------scriot Modale ontact---------------------------------------------------------------------------------
const popupOverlay = document.querySelector(".popup-overlay");
const refPhotoInput = document.querySelector(".refPhoto");
const referenceElement = document.querySelector(".reference");

// Ouverture de la pop-up au clic sur un lien contact
document.querySelectorAll(".contact-button").forEach((contact) => {
  contact.addEventListener("click", () => {
    //console.log("Bouton de contact cliqué"); // Vérifie si le bouton est bien cliqué
    popupOverlay.classList.remove("hidden");
    popupOverlay.classList.add("show");
    //console.log("Classes après ouverture :", popupOverlay.classList); // Affiche les classes appliquées à l'overlay

    if (referenceElement) {
      let ref = referenceElement.innerText.substring(11).trim();
      //console.log("Référence trouvée :", ref); // Vérifie la valeur de la référence
      if (refPhotoInput) {
        refPhotoInput.value = ref;
        //console.log("Champ refPhoto mis à jour avec :", ref); // Vérifie que la référence est bien assignée
      }
    }
  });
});

// Fermeture de la modale au clic sur l'overlay (zone extérieure)
popupOverlay.addEventListener("click", function (e) {
  if (e.target === popupOverlay) {
    //console.log("Overlay cliqué, fermeture de la modale"); // Vérifie si l'overlay est cliqué
    popupOverlay.classList.remove("show");
    popupOverlay.classList.add("hidden");
    //console.log("Classes après fermeture :", popupOverlay.classList); // Vérifie les classes appliquées après fermeture
  }
});
//----------------------------------Script lien element  modale contact menu Accueil---------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
  // Sélectionne l'élément du menu avec l'ID 'menu-item-189'
  document.getElementById('menu-item-189').addEventListener('click', function(event) {
      event.preventDefault(); // Empêche le comportement par défaut du lien
      // Affiche le popup de contact
      document.getElementById('contact-popup').classList.remove('hidden');
  });

  // Ajouter un événement pour fermer le popup si clic en dehors du contenu
  document.querySelector('.popup-overlay').addEventListener('click', function(event) {
      if (event.target === this) { // Vérifie si le clic est en dehors du contenu du popup
        this.classList.remove('show');
        this.classList.add('hidden');
      }
  });
});

// inicializezr la varaible
let Photos = [];
//---------------------------------------------lightbox et lightbox-trigger combiner---------------------------------------------------------------------------------
// Attends que le document soit complètement chargé
document.addEventListener("DOMContentLoaded", function () {
  let currentIndex = 0; // Index actuel de l'image dans la lightbox

  // Définir les icônes pour la lightbox
  const closeIcon = '/wp-content/themes/Nathalie Mota/assets/img/croix.png'; // Chemin pour l'icône de fermeture
  const prevIcon = '/wp-content/themes/Nathalie Mota/assets/img/prev_white.svg'; // Chemin pour l'icône de l'image précédente
  const nextIcon = '/wp-content/themes/Nathalie Mota/assets/img/next_white.svg'; // Chemin pour l'icône de l'image suivante

  // Fonction pour attacher les événements d'overlay et mettre à jour les tableaux des Photos, références, et catégories
  function attachOverlayEvents() {
    // Sélectionner tous les éléments ayant la classe 'lightbox-trigger'
    lightboxElements = document.querySelectorAll('.lightbox-trigger');
    //console.log(lightboxElements);
    

    // ramplir la variable Photos avec chaque image
    lightboxElements.forEach(photoElem=>{
      Photos.push(photoElem.querySelector('.post_img').src)
          })
    
          // console.log(Photos);
          
    references = Array.from(lightboxElements).map(el => el.dataset.reference);
    categories = Array.from(lightboxElements).map(el => el.dataset.category);

    // Boucle à travers chaque élément 'lightbox-trigger'
    lightboxElements.forEach((element, index) => {
      const fullscreen = element.querySelector('.fullscreen'); // Sélectionner l'élément pour l'icône fullscreen
      if (fullscreen) {
        fullscreen.addEventListener('click', function (event) {
          event.preventDefault(); // Empêcher le comportement par défaut du lien
          currentIndex = index; // Mettre à jour l'index actuel
          showLightbox(currentIndex); // Afficher la lightbox avec l'image actuelle
        });
      }

      // Sélectionner les éléments pour la catégorie et la référence dans l'overlay
      const category = element.dataset.category;
      const reference = element.dataset.reference;
      const overlay = element.querySelector('.overlay');
      const categoryElem = overlay.querySelector('.category');
      const referenceElem = overlay.querySelector('.reference');

      // Mettre à jour le texte de la catégorie et de la référence dans l'overlay
      if (categoryElem) categoryElem.textContent = category;
      if (referenceElem) referenceElem.textContent = reference;
    });
  }

  // Fonction pour afficher la lightbox
  function showLightbox(index) {
    const lightboxContainer = document.createElement('div'); // Créer un conteneur pour la lightbox
    lightboxContainer.classList.add('lightbox'); // Ajouter la classe 'lightbox'
    lightboxContainer.innerHTML = `
      <div class="lightbox-content">
        <img src="${Photos[index]}" alt="Lightbox Photo" class="lightbox-photo">
        <div class="lightbox-info">
          <div class="lightbox-reference">${references[index]}</div>
          <div class="lightbox-category">${categories[index]}</div>
        </div>
        <div class="lightbox-close"><img src="${closeIcon}" alt="Fermer" /></div>
        <div class="lightbox-prev">
          <img src="${prevIcon}" alt="Précédent" />
          <span class="Précédent">Précédent</span> <!-- Ajout du texte "Précédent" -->
        </div>
        <div class="lightbox-next">
          <span class="Suivant">Suivant</span> <!-- Ajout du texte "Suivant" -->
          <img src="${nextIcon}" alt="Suivant" />
        </div>
      </div>
    `;

    document.body.appendChild(lightboxContainer); // Ajouter la lightbox au body

    // Gestion de la fermeture de la lightbox
    lightboxContainer.querySelector('.lightbox-close').addEventListener('click', function () {
      lightboxContainer.remove(); // Supprimer la lightbox
    });

    // Fermeture de la lightbox en cliquant à l'extérieur
    lightboxContainer.addEventListener('click', function (event) {
      if (event.target === lightboxContainer) {
        lightboxContainer.remove(); // Supprimer la lightbox si on clique en dehors
      }
    });

    // Navigation vers la phpto suivante
    lightboxContainer.querySelector('.lightbox-next').addEventListener('click', function () {
      currentIndex = (currentIndex + 1) % Photos.length; // Passer à l'image suivante
      updateLightboxContent(currentIndex); // Mettre à jour le contenu de la lightbox
    });

    // Navigation vers la phpto précédente
    lightboxContainer.querySelector('.lightbox-prev').addEventListener('click', function () {
      currentIndex = (currentIndex - 1 + Photos.length) % Photos.length; // Passer à l'image précédente
      updateLightboxContent(currentIndex); // Mettre à jour le contenu de la lightbox
    });


    // Mettre à jour le contenu initial de la lightbox
    updateLightboxContent(currentIndex);
  }

  // Fonction pour mettre à jour le contenu de la lightbox
  function updateLightboxContent(index) {
    // Sélectionne l'élément ayant la classe 'lightbox-photo'
    const lightboxPhoto = document.querySelector('.lightbox-photo');
    // Sélectionne l'élément ayant la classe 'lightbox-reference'
    const lightboxReference = document.querySelector('.lightbox-reference');
    // Sélectionne l'élément ayant la classe 'lightbox-category'
    const lightboxCategory = document.querySelector('.lightbox-category');

    // Vérifie que l'élément 'lightboxPhoto' existe avant de définir son 'src'
    if (lightboxPhoto) {
      lightboxPhoto.src = Photos[index]; // Mettre à jour l'image dans la lightbox
    } else {
      //console.error("L'élément .lightbox-photo n'a pas été trouvé dans le DOM.");
    }

    // Vérifie que 'lightboxReference' n'est pas null avant d'attribuer une valeur
    if (lightboxReference) {
      lightboxReference.textContent = references[index]; // Mettre à jour la référence dans la lightbox
    } else {
      console.error("L'élément .lightbox-reference n'a pas été trouvé dans le DOM.");
    }

    // Vérifie que 'lightboxCategory' n'est pas null avant d'attribuer une valeur
    if (lightboxCategory) {
      lightboxCategory.textContent = categories[index]; // Mettre à jour la catégorie dans la lightbox
    } else {
      console.error("L'élément .lightbox-category n'a pas été trouvé dans le DOM.");
    }
  }

  attachOverlayEvents(); // Attacher les événements d'overlay au chargement initial

  // Gestionnaire d'événements pour charger plus de photos via AJAX
  jQuery(document).ready(function($) {
    if (typeof nathalie_mota !== 'undefined' && typeof nathalie_mota.ajaxurl !== 'undefined') {
      let page = 2; // Page initiale pour le chargement des photos
      $('#load-more').on('click', function() {
        let button = $(this);
        let paged = page;

        $.ajax({
          url: nathalie_mota.ajaxurl, // URL pour la requête AJAX
          type: 'POST', // Type de requête
          data: {
            action: 'load_more_photos', // Action à effectuer
            page: paged // Numéro de page
          },
          success: function(response) {
            if (response.trim() !== '') {
              $('.photos_container').append(response); // Ajouter les nouvelles photos au container
              page++; // Incrémenter le numéro de page
            } else {
              button.hide(); // Cacher le bouton si aucune photo n'est renvoyée
            }
            attachOverlayEvents(); // Réattacher les événements après le chargement des nouvelles photos
          },
          error: function() {
            console.error('Erreur lors du chargement des photos.'); // Afficher une erreur si la requête échoue
          }
        });
      });
    } else {
      console.error('nathalie_mota ou nathalie_mota.ajaxurl n\'est pas défini'); // Afficher une erreur si 'nathalie_mota' ou 'ajaxurl' n'est pas défini
    }
  });
});




//----------------------------------Script  filtre---------------------------------------------------------
  //Ce script permet de filtrer dynamiquement les photos selon les critères sélectionnés (catégorie, format, date)
  //sans recharger la page. Une requête est envoyée à WordPress chaque fois qu'un des filtres change, et les résultats
  //filtrés sont injectés directement dans le conteneur .photos_container


  document.addEventListener("DOMContentLoaded", function () {
    // Affiche l'objet `myAjax` dans la console pour vérifier s'il est bien défini
    //console.log(nathalie_mota); 
  
    // Sélectionne tous les éléments de filtrage (catégorie, format, date)
    document.querySelectorAll('#category-filter, #format-filter, #date-sort').forEach(function (selectElement) {
      // Ajoute un écouteur d'événement pour chaque élément de filtrage
      selectElement.addEventListener('change', function () {
        // Récupère les valeurs actuelles des filtres
        let category = document.getElementById('category-filter').value;
        let format = document.getElementById('format-filter').value;
        let order = document.getElementById('date-sort').value;
  
        // Prépare les données à envoyer via AJAX
        let data = {
          action: 'filter_photos',  // Action WordPress qui sera traitée
          category: category,       // Valeur sélectionnée du filtre de catégorie
          format: format,           // Valeur sélectionnée du filtre de format
          order: order              // Valeur sélectionnée du filtre de date
        };
  
        // Envoie une requête POST à WordPress via AJAX
        fetch(nathalie_mota.ajaxurl, {
          method: 'POST',  // Méthode d'envoi
          body: new URLSearchParams(data),  // Corps de la requête avec les données
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'  // Type de contenu
          }
        })
        .then(response => response.text())  // Convertit la réponse en texte
        .then(data => {
          // Met à jour la section contenant les photos filtrées
          document.querySelector('.photos_container').innerHTML = data;
        })
        .catch(error => console.error('Erreur:', error));  // Gère les erreurs éventuelles
      });
    });
  });

//----------------------------------Script menu burger---------------------------------------------------------
  const hamburgerButton = document.querySelector(".nav-toggler") 
  const navigation = document.querySelector("nav-burger")
hamburgerButton.addEventListener("click", toggleNav)
function toggleNav(){
  hamburgerButton.classList.toggle("active")
  navigation.classList.toggle("active")
}