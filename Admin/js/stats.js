function getStats() {
    fetch("../api/stats/", {
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
                // // Mise à jour des barres de progression
                // document.querySelectorAll(".barre-progression").forEach((el, idx) => {
                //     el.style.width = (data.data[idx]?.Pourcentage || 0) + "%";
                // });

                // document.querySelectorAll(".poucen_prog").forEach((el, idx) => {
                //     el.textContent = (data.data[idx]?.Pourcentage || 0) + "%";
                // });

                // document.querySelectorAll(".progre_non").forEach((el, idx) => {
                //     el.textContent = (data.data[idx]?.Progre_non || 0) + " FCFA";
                // });

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
                            cardsHtml += ` <div class="col-xl-3 col-md-6">
                            <div class="stat-card">
                                <div class="stat-icon" style="background: linear-gradient(135deg, #28a745, #20c997);">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h3 class="stat-number">${rec.total_users}</h3>
                                <p class="stat-label">Utilisateurs Actifs</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card">
                                <div class="stat-icon" style="background: linear-gradient(135deg, #007bff, #0056b3);">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <h3 class="stat-number">${rec.total_cotisations}</h3>
                                <p class="stat-label">Cotisations Actives</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card">
                                <div class="stat-icon" style="background: linear-gradient(135deg, #ffc107, #e0a800);">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <h4 class="stat-number">$${rec.total_montant}</h4>
                                <p class="stat-label">Total FCFA</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card">
                                <div class="stat-icon" style="background: linear-gradient(135deg, #dc3545, #c82333);">
                                    <i class="fas fa-gift"></i>
                                </div>
                                <h3 class="stat-number">${rec.total_recompenses}</h3>
                                <p class="stat-label">Récompenses disponibles</p>
                            </div>
                        </div>`;
                        });
                    }

                    el.innerHTML = cardsHtml;
                });
            } else {
                // Erreur envoyée par le serveur
                afficherMessage("Erreur serveur : " + (data && data.message ? data.message : "Réponse invalide"), "error", ".erreur-zone", 7000);
            }
        })
        .catch(error => {
            afficherMessage("Erreur : " + error.message, "error", ".erreur-zone", 7000);
        });
}
document.addEventListener('DOMContentLoaded', () => {
    getStats();
});