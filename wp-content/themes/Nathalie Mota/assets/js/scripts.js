

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
//---------------------------------------------lightbox---------------------------------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
  // Initialisation de la lightbox
  let currentIndex = 0;// Sélection de tous les éléments déclencheurs de la lightbox
  const lightboxElements = document.querySelectorAll('.lightbox-trigger');
  const images = Array.from(lightboxElements).map(el => el.href);// Récupération des URLs des images
// Chemins des icônes de navigation et de fermeture
const templateUrl = myTheme.templateUrl; // URL de base du thème WordPress s'assurez que myTheme.templateUrl est correctement défini dans  WordPress.
const closeIcon = templateUrl + '/assets/img/croix.png';
const prevIcon = templateUrl + '/assets/img/prev_white.svg';
  const nextIcon = templateUrl + '/assets/img/next_white.svg';
  // Fonction pour afficher la lightbox
  // Création de l'élément conteneur de la lightbox

  function showLightbox(index) {
    const lightboxContainer = document.createElement('div');
    lightboxContainer.classList.add('lightbox');// Ajout de la classe CSS
    // Contenu de la lightbox (image et icônes de navigation)    
    lightboxContainer.innerHTML = `
    <div class="lightbox-content">
            <h2 class="lightbox-reference"></h2> <!-- Affiche la référence -->
            <p class="lightbox-category"></p> <!-- Affiche la catégorie -->
        <img src="${images[index]}" alt="Lightbox Image">
        <div class="lightbox-close"><img src="${closeIcon}" alt="Fermer" /></div>
        <div class="lightbox-prev"><img src="${prevIcon}" alt="Pecedent" /></div>
        <divdiv class="lightbox-next"><img src="${nextIcon}" alt="Suivant" /></div>
    </div>`;

    document.body.appendChild(lightboxContainer);// Ajout de la lightbox au body
    // Gestion de la fermeture de la lightbox
    // Fermeture de la lightbox
    lightboxContainer.querySelector('.lightbox-close').addEventListener('click', function () {
      lightboxContainer.remove();// Suppression de la lightbox
    });

    // Navigation suivante/précédente
    lightboxContainer.querySelector('.lightbox-next').addEventListener('click', function () {
      currentIndex = (currentIndex + 1) % images.length;
      // Retour à l'image précédente
      lightboxContainer.querySelector('img').src = images[currentIndex];
    });
// Navigation précédente
    lightboxContainer.querySelector('.lightbox-prev').addEventListener('click', function () {
      currentIndex = (currentIndex - 1 + images.length) % images.length;
      lightboxContainer.querySelector('img').src = images[currentIndex];
      // Mise à jour de l'image
    });

    // Fermeture en cliquant à l'extérieur
    lightboxContainer.addEventListener('click', function (event) {
      if (event.target === lightboxContainer) {
        lightboxContainer.remove();
        // Suppression de la lightbox si on clique en dehors
      }
      
    });
  }
// Ajout d'un écouteur de clic sur chaque élément déclencheur de la lightbox
  lightboxElements.forEach((element, index) => {
    element.addEventListener('click', function (event) {
      event.preventDefault();
      currentIndex = index;// Mise à jour de l'index actuel  
      showLightbox(currentIndex);// Affichage de la lightbox
    });
  });
  // Gestionnaires d'événements pour les icônes plein écran
const fullscreenIcons = document.querySelectorAll(".full-screen-icon");
fullscreenIcons.forEach(function (icon) {
  icon.addEventListener("click", function (e) {
    e.preventDefault();
    const imageUrl = this.getAttribute("href");
    openLightbox(imageUrl);
  });
});

//---------------------------------------Fonctionnalité "Charger Plus"------------------------------------------------------------------
  let page = 2; // Global, pour suivre le numéro de page

  document.getElementById('load-more').addEventListener('click', function () {
      let button = this;
      let data = {
          'action': 'load_more_photos',
          'page': page
      };
  
      fetch(myAjax.ajaxUrl, {
          method: 'POST',
          body: new URLSearchParams(data),
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
          }
      })
      .then(response => response.text())
      .then(data => {
       // console.log (data)
          if (data.trim() !== '') {
              document.querySelector('.photos_container').innerHTML += data;
              page++; 
          } else {
              button.style.display = 'none'; // Cache le bouton si aucune photo n'est retournée
          }
      })
      .catch(error => console.error('Error:', error));
  });
});
//----------------------------------Fonctionnalité  filtre---------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll('#category-filter, #format-filter, #date-sort').forEach(function (selectElement) {
      selectElement.addEventListener('change', function () {
          let category = document.getElementById('category-filter').value;
          let format = document.getElementById('format-filter').value;
          let order = document.getElementById('date-sort').value;

          let data = {
              action: 'filter_photos',
              category: category,
              format: format,
              order: order,
          };

          fetch(myAjax.ajaxUrl, {
              method: 'POST',
              body: new URLSearchParams(data),
              headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
              }
          })
          .then(response => response.text())
          .then(data => {
              document.querySelector('.photos_container').innerHTML = data;
          })
          .catch(error => console.error('Erreur:', error));
      });
  });
});
//----------------------------------Fonctionnalité  element contact menu Accueil---------------------------------------------------------
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
function debugLog(message) {
  let debugDiv = document.getElementById('debug-log');
  if (!debugDiv) {
      debugDiv = document.createElement('div');
      debugDiv.id = 'debug-log';
      document.body.appendChild(debugDiv);
  }
  debugDiv.innerHTML += `<p>${message}</p>`;
}

// Exemple d'utilisation
debugLog('Le script est exécuté.');