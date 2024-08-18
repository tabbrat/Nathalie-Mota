// Mise en cache des éléments DOM
const popupOverlay = document.querySelector(".popup-overlay");
const refPhotoInput = document.querySelector(".refPhoto");
const referenceElement = document.querySelector(".reference");

// Ouverture de la pop-up au clic sur un lien contact
document.querySelectorAll(".contact-button").forEach((contact) => {
  contact.addEventListener("click", () => {
    console.log("Bouton de contact cliqué"); // Vérifie si le bouton est bien cliqué
    popupOverlay.classList.remove("hidden");
    popupOverlay.classList.add("show");
    //console.log("Classes après ouverture :", popupOverlay.classList); // Affiche les classes appliquées à l'overlay

    if (referenceElement) {
      let ref = referenceElement.innerText.substring(11).trim();
      console.log("Référence trouvée :", ref); // Vérifie la valeur de la référence
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
    console.log("Overlay cliqué, fermeture de la modale"); // Vérifie si l'overlay est cliqué
    popupOverlay.classList.remove("show");
    popupOverlay.classList.add("hidden");
    console.log("Classes après fermeture :", popupOverlay.classList); // Vérifie les classes appliquées après fermeture
  }
});
