document.addEventListener("DOMContentLoaded", function () {
    const contactBtn = document.querySelectorAll(".contact");
    const popupOverlay = document.querySelector(".popup-overlay");
    const popupCloseBtn = document.querySelector(".popup-close");
  
    // Ouverture de la pop-up au clic sur un lien contact
    contactBtn.forEach((contact) => {
      contact.addEventListener("click", () => {
        popupOverlay.classList.remove("hidden");
        if (document.querySelector(".reference") !== null) {
          let ref = document.querySelector(".reference").innerText.substring(11);
          ref = ref.trim();
          if (document.querySelector(".refPhoto") !== null) {
            document.querySelector(".refPhoto").value = ref;
          }
        }
      });
    });
  
    // Fermeture de la pop-up au clic sur l'overlay ou sur le bouton de fermeture
    popupOverlay.addEventListener("click", (e) => {
      if (e.target.className == "popup-overlay") {
        popupOverlay.classList.add("hidden");
      }
    });
  
    if (popupCloseBtn) {
      popupCloseBtn.addEventListener("click", () => {
        popupOverlay.classList.add("hidden");
      });
    }
  });