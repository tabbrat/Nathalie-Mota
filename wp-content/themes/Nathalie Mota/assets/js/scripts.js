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
  document
    .getElementById("menu-item-189")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Empêche le comportement par défaut du lien
      // Affiche le popup de contact
      document.getElementById("contact-popup").classList.remove("hidden");
    });

  // Ajouter un événement pour fermer le popup si clic en dehors du contenu
  document
    .querySelector(".popup-overlay")
    .addEventListener("click", function (event) {
      if (event.target === this) {
        // Vérifie si le clic est en dehors du contenu du popup
        this.classList.remove("show");
        this.classList.add("hidden");
      }
    });
});

// Initialise la variable des photos
let Photos = [];

// Attends que le document soit complètement chargé
document.addEventListener("DOMContentLoaded", function () {
  let currentIndex = 0; // Index actuel de l'image dans la lightbox

  // Définir les icônes pour la lightbox
  const closeIcon = "/wp-content/themes/Nathalie Mota/assets/img/croix.png"; // Icône pour fermer la lightbox
  const prevIcon = "/wp-content/themes/Nathalie Mota/assets/img/prev_white.svg"; // Icône pour passer à l'image précédente
  const nextIcon = "/wp-content/themes/Nathalie Mota/assets/img/next_white.svg"; // Icône pour passer à l'image suivante

  // Fonction pour attacher les événements et mettre à jour les tableaux des photos, références, et catégories
  function attachOverlayEvents() {
    let lightboxElements = document.querySelectorAll(".lightbox-trigger"); // Sélectionne tous les éléments qui déclenchent la lightbox

    // Remplir la variable Photos avec chaque image
    Photos = Array.from(lightboxElements).map(
      (photoElem) => photoElem.querySelector(".post_img").src
    );
    // Crée un tableau avec la source (URL) de chaque image

    // Mettre à jour les références et catégories
    references = Array.from(lightboxElements).map((el) => el.dataset.reference);
    // Crée un tableau avec les références des photos (provenant des attributs `data-reference`)
    categories = Array.from(lightboxElements).map((el) => el.dataset.category);
    // Crée un tableau avec les catégories des photos (provenant des attributs `data-category`)

    // Boucle à travers chaque élément 'lightbox-trigger' pour attacher les événements
    lightboxElements.forEach((element, index) => {
      const fullscreen = element.querySelector(".fullscreen"); // Sélectionner l'élément pour l'icône fullscreen
      if (fullscreen) {
        // Ajouter un événement click sur l'icône fullscreen
        fullscreen.addEventListener("click", function (event) {
          event.preventDefault(); // Empêcher le comportement par défaut du lien
          currentIndex = index; // Mettre à jour l'index actuel de l'image
          showLightbox(currentIndex); // Afficher la lightbox avec l'image actuelle
        });
      }

      // Sélectionner les éléments pour la catégorie et la référence dans l'overlay
      const category = element.dataset.category; // Récupère la catégorie depuis l'attribut `data-category`
      const reference = element.dataset.reference; // Récupère la référence depuis l'attribut `data-reference`
      const overlay = element.querySelector(".overlay"); // Sélectionne l'overlay
      const categoryElem = overlay.querySelector(".category"); // Sélectionne l'élément qui affichera la catégorie
      const referenceElem = overlay.querySelector(".reference"); // Sélectionne l'élément qui affichera la référence

      // Mettre à jour le texte de la catégorie et de la référence dans l'overlay
      if (categoryElem) categoryElem.textContent = category; // Si l'élément catégorie existe, met à jour son contenu avec la catégorie
      if (referenceElem) referenceElem.textContent = reference; // Si l'élément référence existe, met à jour son contenu avec la référence
    });
  }

  // Fonction pour afficher la lightbox
  function showLightbox(index) {
    const lightboxContainer = document.createElement("div"); // Crée un conteneur pour la lightbox
    lightboxContainer.classList.add("lightbox"); // Ajoute la classe CSS 'lightbox' au conteneur
    lightboxContainer.innerHTML = `
      <div class="lightbox-content">
        <img src="${Photos[index]}" alt="Lightbox Photo" class="lightbox-photo"> 
        <!-- Ajoute l'image actuelle dans la lightbox -->
        <div class="lightbox-info">
          <div class="lightbox-reference">${references[index]}</div> 
          <!-- Affiche la référence de l'image -->
          <div class="lightbox-category">${categories[index]}</div> 
          <!-- Affiche la catégorie de l'image -->
        </div>
        <div class="lightbox-close"><img src="${closeIcon}" alt="Fermer" /></div> 
        <!-- Bouton pour fermer la lightbox -->
        <div class="lightbox-prev">
          <img src="${prevIcon}" alt="Précédent" /> 
          <!-- Icône pour passer à l'image précédente -->
          <span class="Précédent">Précédent</span> 
          <!-- Texte pour passer à l'image précédente -->
        </div>
        <div class="lightbox-next">
          <span class="Suivant">Suivant</span> 
          <!-- Texte pour passer à l'image suivante -->
          <img src="${nextIcon}" alt="Suivant" /> 
          <!-- Icône pour passer à l'image suivante -->
        </div>
      </div>
    `;

    document.body.appendChild(lightboxContainer);
    // Ajoute la lightbox au corps du document

    // Ferme la lightbox lorsqu'on clique sur le bouton de fermeture
    lightboxContainer
      .querySelector(".lightbox-close")
      .addEventListener("click", function () {
        lightboxContainer.remove(); // Supprime la lightbox du DOM
      });

    // Ferme la lightbox lorsqu'on clique en dehors du contenu
    lightboxContainer.addEventListener("click", function (event) {
      if (event.target === lightboxContainer) {
        lightboxContainer.remove(); // Supprime la lightbox du DOM
      }
    });

    // Passe à l'image suivante lorsqu'on clique sur le bouton "Suivant"
    lightboxContainer
      .querySelector(".lightbox-next")
      .addEventListener("click", function () {
        currentIndex = (currentIndex + 1) % Photos.length; // Incrémente l'index et retourne au début si on dépasse la dernière image
        updateLightboxContent(currentIndex); // Met à jour le contenu de la lightbox avec la nouvelle image
      });

    // Passe à l'image précédente lorsqu'on clique sur le bouton "Précédent"
    lightboxContainer
      .querySelector(".lightbox-prev")
      .addEventListener("click", function () {
        currentIndex = (currentIndex - 1 + Photos.length) % Photos.length; // Décrémente l'index et retourne à la fin si on est avant la première image
        updateLightboxContent(currentIndex); // Met à jour le contenu de la lightbox avec la nouvelle image
      });

    updateLightboxContent(currentIndex); // Met à jour le contenu de la lightbox avec l'image actuelle
  }

  // Fonction pour mettre à jour le contenu de la lightbox
  function updateLightboxContent(index) {
    const lightboxPhoto = document.querySelector(".lightbox-photo"); // Sélectionne l'élément de l'image dans la lightbox
    const lightboxReference = document.querySelector(".lightbox-reference"); // Sélectionne l'élément de la référence dans la lightbox
    const lightboxCategory = document.querySelector(".lightbox-category"); // Sélectionne l'élément de la catégorie dans la lightbox

    if (lightboxPhoto) lightboxPhoto.src = Photos[index]; // Met à jour la source de l'image avec la nouvelle image
    if (lightboxReference) lightboxReference.textContent = references[index]; // Met à jour la référence de la nouvelle image
    if (lightboxCategory) lightboxCategory.textContent = categories[index]; // Met à jour la catégorie de la nouvelle image
  }

  // Attache les événements d'overlay au chargement initial
  attachOverlayEvents(); // Applique les événements aux images déjà présentes lors du chargement de la page

  // Utilise MutationObserver pour réattacher les événements après le chargement dynamique
  const observer = new MutationObserver((mutationsList) => {
    for (let mutation of mutationsList) {
      if (mutation.type === "childList" && mutation.addedNodes.length > 0) {
        // Si de nouveaux éléments sont ajoutés au DOM, on réattache les événements
        mutation.addedNodes.forEach((node) => {
          if (node.classList && node.classList.contains("lightbox-trigger")) {
            attachOverlayEvents(); // Réattache les événements aux nouvelles images
          }
        });
      }
    }
  });

  const photosContainer = document.querySelector(".photos_container");
  if (photosContainer) {
    // Observe les changements dans le conteneur des photos (ajout d'éléments)
    observer.observe(photosContainer, { childList: true });
  }

  // Gestionnaire d'événements pour charger plus de photos via AJAX
  jQuery(document).ready(function ($) {
    if (
      typeof nathalie_mota !== "undefined" &&
      typeof nathalie_mota.ajaxurl !== "undefined"
    ) {
      let page = 2; // Page à charger (commence à 2)
      $("#load-more").on("click", function () {
        let button = $(this); // Référence au bouton "Charger plus"
        $.ajax({
          url: nathalie_mota.ajaxurl, // URL pour l'AJAX
          type: "POST", // Requête POST
          data: {
            action: "load_more_photos", // Action à exécuter (PHP côté serveur)
            page: page, // Envoyer le numéro de page
          },
          success: function (response) {
            if (response) {
              $(".photos_container").append(response); // Ajouter les nouvelles photos au conteneur
              page++; // Incrémenter le numéro de page
              attachOverlayEvents(); // Réattacher les événements aux nouvelles images chargées
            } else {
              button.remove(); // Si aucune photo n'est retournée, on supprime le bouton
            }
          },
        });
      });
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
  document
    .querySelectorAll("#category-filter, #format-filter, #date-sort")
    .forEach(function (selectElement) {
      // Ajoute un écouteur d'événement pour chaque élément de filtrage
      selectElement.addEventListener("change", function () {
        // Récupère les valeurs actuelles des filtres
        let category = document.getElementById("category-filter").value;
        let format = document.getElementById("format-filter").value;
        let order = document.getElementById("date-sort").value;

        // Prépare les données à envoyer via AJAX
        let data = {
          action: "filter_photos", // Action WordPress qui sera traitée
          category: category, // Valeur sélectionnée du filtre de catégorie
          format: format, // Valeur sélectionnée du filtre de format
          order: order, // Valeur sélectionnée du filtre de date
        };

        // Envoie une requête POST à WordPress via AJAX
        fetch(nathalie_mota.ajaxurl, {
          method: "POST", // Méthode d'envoi
          body: new URLSearchParams(data), // Corps de la requête avec les données
          headers: {
            "Content-Type": "application/x-www-form-urlencoded", // Type de contenu
          },
        })
          .then((response) => response.text()) // Convertit la réponse en texte
          .then((data) => {
            // Met à jour la section contenant les photos filtrées
            document.querySelector(".photos_container").innerHTML = data;
          })
          .catch((error) => console.error("Erreur:", error)); // Gère les erreurs éventuelles
      });
    });
});

//----------------------------------Script menu burger---------------------------------------------------------
// Sélectionne le bouton hamburger (bouton avec la classe 'nav-toggler')
const hamburgerButton = document.querySelector(".nav-toggler");
// Sélectionne l'élément qui contient le menu burger (avec la classe 'nav-burger')
const navigation = document.querySelector(".nav-burger");

// Ajoute un événement 'click' au bouton hamburger
hamburgerButton.addEventListener("click", toggleNav);

// Fonction pour afficher/cacher le menu burger
function toggleNav() {
  // Ajoute ou supprime la classe 'active' au bouton hamburger pour l'animation
  hamburgerButton.classList.toggle("active");
  // Ajoute ou supprime la classe 'active' à l'élément du menu burger pour l'afficher/cacher
  navigation.classList.toggle("active");
  function toggleMenu() {
    const menu = document.getElementById("menuToggle");
    const toggler = document.querySelector(".nav-toggler");

    menu.classList.toggle("active"); // Active ou désactive la classe 'active' du menu
    toggler.classList.toggle("active"); // Active ou désactive la classe 'active' du bouton burger
  }
}
