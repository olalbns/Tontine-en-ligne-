function afficherMessage(message, type = "info", cible = ".message", duree = 4000) {
    const container = document.querySelector(cible);
    if (!container) return;

    // Création du bloc de message
    const messageBox = document.createElement("div");
    messageBox.style.cssText = `
    padding: 10px;
    background-color: ${{
            success: "#4CAF50",
            error: "#F44336",
            info: "#2196F3",
            warning: "#FFC107"
        }[type] || "#999"};
    color: white;
    border-radius: 5px;
    margin-top: 10px;
    font-size: 14px;
    opacity: 1;
    transition: opacity 0.5s ease;
    width:200px;
  `;
    messageBox.textContent = message;

    // Vider d'abord les anciens messages
    container.innerHTML = "";
    container.appendChild(messageBox);

    // Faire disparaître après X millisecondes
    setTimeout(() => {
        messageBox.style.opacity = "0";
        setTimeout(() => {
            if (container.contains(messageBox)) {
                container.removeChild(messageBox);
            }
        }, 500); // temps de transition CSS
    }, duree);
}
//  afficherMessage("Erreur serveur", "error", ".erreur-zone", 6000);   
function afficherSpinner(cible = ".spinner-zone") {
    const container = document.querySelector(cible);
    if (!container) return;

    // Créer l'overlay flou
    const overlay = document.createElement("div");
    overlay.style.cssText = `
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.6);
    backdrop-filter: blur(4px);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  `;

    // Créer le spinner
    const spinner = document.createElement("div");
    spinner.style.cssText = `
    border: 8px solid #f3f3f3;
    border-top: 8px solid #4CAF50;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite;
  `;

    overlay.appendChild(spinner);
    container.appendChild(overlay);

    // Ajout de l'animation CSS si pas déjà présente
    if (!document.getElementById("spinner-style")) {
        const style = document.createElement("style");
        style.id = "spinner-style";
        style.textContent = `
      @keyframes spin {
        0% { transform: rotate(0deg);}
        100% { transform: rotate(360deg);}
      }
    `;
        document.head.appendChild(style);
    }

    // Retirer le spinner après 2 secondes
    setTimeout(() => {
        if (container.contains(overlay)) {
            container.removeChild(overlay);
        }
    }, 1000);
}


document.addEventListener('DOMContentLoaded', () => {
    afficherSpinner()
});
