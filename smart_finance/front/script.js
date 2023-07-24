// JavaScript pour ouvrir/fermer la pop-up et basculer entre les onglets
document
  .getElementById("btn-open-popup")
  .addEventListener("click", function () {
    document.getElementById("popup").style.display = "block";
  });

document
  .getElementById("btn-close-popup")
  .addEventListener("click", function () {
    document.getElementById("popup").style.display = "none";
  });

// Gestion des onglets
const tabs = document.querySelectorAll(".tab");
const forms = document.querySelectorAll("form");

tabs.forEach((tab, index) => {
  tab.addEventListener("click", () => {
    // Masquer tous les formulaires
    forms.forEach((form) => {
      form.classList.remove("visible");
    });

    // Afficher le formulaire associé à l'onglet actif
    forms[index].classList.add("visible");

    // Désactiver tous les onglets
    tabs.forEach((tab) => {
      tab.classList.remove("active");
    });

    // Activer l'onglet actif
    tab.classList.add("active");
  });
});
