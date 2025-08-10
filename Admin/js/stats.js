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

                function getActivity() {
                    // Vérification des données
                    if (!data || !data.data || !Array.isArray(data.activity)) {
                        console.error("Les données d'activité sont introuvables ou invalides.");
                        return;
                    }

                    // Paramètres de pagination
                    let currentPage = 1;
                    let rowsPerPage = 15;
                    let notifications = data.activity;

                    // Fonction d'affichage
                    function displayTable(page) {
                        let tableBody = document.querySelector(".activity-table");
                        if (!tableBody) {
                            console.error("Impossible de trouver le tbody .activity-table");
                            return;
                        }

                        tableBody.innerHTML = ""; // Réinitialise le tableau

                        if (!notifications.length) {
                            tableBody.innerHTML = `<tr><td colspan="5" style="text-align:center;">Aucune activité trouvée</td></tr>`;
                            return;
                        }

                        let start = (page - 1) * rowsPerPage;
                        let end = start + rowsPerPage;
                        let paginatedItems = notifications.slice(start, end);

                        paginatedItems.forEach(item => {
                            let montantAffiche = item.Montant && !isNaN(item.Montant)
                                ? `${parseInt(item.Montant).toLocaleString()} FCFA`
                                : "-";

                            let badgeClass = "badge-pending";
                            if (item.Statut && item.Statut.toLowerCase().includes("ter")) badgeClass = "badge-active";
                            else if (item.Statut && item.Statut.toLowerCase().includes("cot")) badgeClass = "badge-active";

                            let row = `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="../../Public/Assets/img/default.png" class="rounded-circle me-2" width="40" height="40" alt="User">
                            <span>${item.Utilisateur || "-"}</span>
                        </div>
                    </td>
                    <td>${item.Action || "-"}</td>
                    <td>${montantAffiche}</td>
                    <td>${item.Date || "-"}</td>
                    <td><span class="badge-status ${badgeClass}">${item.Statut || "-"}</span></td>
                </tr>
            `;
                            tableBody.innerHTML += row;
                        });

                        displayPagination();
                    }

                    // Fonction d'affichage de la pagination
                    function displayPagination() {
                        let paginationDiv = document.getElementById("pagination");
                        if (!paginationDiv) return;

                        paginationDiv.innerHTML = "";
                        let totalPages = Math.ceil(notifications.length / rowsPerPage);
                        let maxButtonsToShow = 5; // nombre de boutons autour de la page courante

                        function createButton(page) {
                            let button = document.createElement("button");
                            button.innerText = page;
                            button.className = (page === currentPage) ? "active" : "";
                            button.onclick = function () {
                                currentPage = page;
                                displayTable(currentPage);
                            };
                            return button;
                        }

                        // Bouton 1
                        if (currentPage > 3) {
                            paginationDiv.appendChild(createButton(1));
                            if (currentPage > 4) {
                                let dots = document.createElement("span");
                                dots.innerText = "...";
                                paginationDiv.appendChild(dots);
                            }
                        }

                        // Boutons autour de la page courante
                        let startPage = Math.max(1, currentPage - 2);
                        let endPage = Math.min(totalPages, currentPage + 2);
                        for (let i = startPage; i <= endPage; i++) {
                            paginationDiv.appendChild(createButton(i));
                        }

                        // Bouton dernière page
                        if (currentPage < totalPages - 2) {
                            if (currentPage < totalPages - 3) {
                                let dots = document.createElement("span");
                                dots.innerText = "...";
                                paginationDiv.appendChild(dots);
                            }
                            paginationDiv.appendChild(createButton(totalPages));
                        }
                    }


                    // Lancement initial
                    displayTable(currentPage);
                }

                getActivity();

            } else {
                // Erreur envoyée par le serveur
                afficherMessage("Erreur serveur : " + (data && data.message ? data.message : "Réponse invalide"), "error", ".erreur-zone", 7000);
                console.log(data && data.message ? data.message : "Réponse invalide");
            }
        })
        .catch(error => {
            afficherMessage("Erreur : " + error.message, "error", ".erreur-zone", 7000);
            console.log(error.message);
        });
}
document.addEventListener('DOMContentLoaded', () => {
    getStats();
});