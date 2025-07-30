
function getStats() {
    fetch("../../api/stats/", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error("Erreur réseau : " + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data && data.status === 'success' && Array.isArray(data.data)) {
                // Mise à jour des barres de progression
                document.querySelectorAll(".barre-progression").forEach((el, idx) => {
                    el.style.width = (data.data[idx]?.Pourcentage || 0) + "%";
                });

                document.querySelectorAll(".poucen_prog").forEach((el, idx) => {
                    el.textContent = (data.data[idx]?.Pourcentage || 0) + "%";
                });

                document.querySelectorAll(".progre_non").forEach((el, idx) => {
                    el.textContent = (data.data[idx]?.Progre_non || 0) + " FCFA";
                });

                // Mise à jour des cartes de stats
                const stats_container = document.querySelectorAll('.stats_container');
                stats_container.forEach(el => {
                    let cardsHtml = "";

                    // Vérifie si data.data est vide ou non défini
                    if (!data.data || data.data.length === 0) {
                        cardsHtml = `
            <div class="alert alert-info w-100 text-center mt-3">
                Aucun statistique disponible pour le moment.
            </div>
        `;
                    } else {
                        // Traitement normal si des données existent
                        data.data.forEach(rec => {
                            cardsHtml += `
                <h4 class="mt-1">${rec.nom_rec || "Titre Indéfini"}</h4>
                <div class="cards-container row mt-1 w-100">
                    <div class="card col otop shadow-sm p-2 mt-2 rounded-4 d-flex h-auto align-items-center">
                        <div class="title-others d-flex flex-column">
                            <h6 class="jj">Montant cottisé</h6>
                            <div class="price">
                                <h3 class="">${rec.balance_uti || 0}<span> FCFA</span></h3>
                            </div>
                        </div>
                        <i style="font-size:22px; color:green;" class="fa-solid fa-wallet"></i>
                    </div>
                    <div class="card col otop shadow-sm p-3 mt-2 rounded-4 d-flex h-auto align-items-center">
                        <div class="title-others d-flex flex-column">
                            <h6 class="jj">Prochaine échéance</h6>
                            <div class="price">
                                <h3>${rec.date_echeance ? new Date(rec.date_echeance).toLocaleDateString() : "Aucune échéance"}</h3>
                            </div>
                        </div>
                        <i style="font-size:22px; color:green;" class="fa-solid fa-calendar"></i>
                    </div>
                    <div class="card col otop shadow-sm p-3 mt-2 rounded-4 d-flex h-auto align-items-center">
                        <div class="title-others w-100 d-flex flex-column">
                            <h6 class="jj">Progression</h6>
                            <div class="price">
                                <div class="progression">
                                    <div class="barre-progression" style="width:${rec.Pourcentage || 0}%; max-width:100%;"></div>
                                </div>
                                <h3 class="mb-0"><sup class="poucen_prog">${rec.Pourcentage || 0}%</sup><sup> | </sup> <sup
                                        class="progre_non"> ${rec.Progre_non || 0} </sup> <sup> restant</sup></h3>
                            </div>
                        </div>
                        <i style="font-size:22px; color:green; margin-top:-12px;"
                            class="fa-solid fa-chart-line"></i>
                    </div>
                </div>`;
                        });
                    }

                    el.innerHTML = cardsHtml;
                });
            } else {
                // Erreur envoyée par le serveur
                afficherMessage("Erreur serveur : " + (data && data.message ? data.message : "Réponse invalide"), "info", ".erreur-zone", 7000);
            }
        })
        .catch(error => {
            afficherMessage("Erreur : " + error.message, "danger", ".erreur-zone", 7000);
        });
}
document.addEventListener('DOMContentLoaded', () => {
    getStats();
});