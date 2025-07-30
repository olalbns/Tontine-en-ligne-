function getRecompense() {
    fetch("../../api/recompense/", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // On suppose que data.data.recompense est un tableau d'objets récompense
                const carContainers = document.querySelectorAll(".car-container");
                // Pour chaque container, on affiche toutes les récompenses
                carContainers.forEach(el => {
                    // On construit le HTML pour toutes les récompenses
                    let cardsHtml = "";
                    if ((data.data.recompense).length === 0) {
                        cardsHtml = `<div class="alert alert-info">Aucune récompense disponible</div>`;
                        el.innerHTML = cardsHtml;
                        return; // Sortie de la fonction si aucune récompense

                    } else {

                        data.data.recompense.forEach(rec => {
                            cardsHtml += `
                            <div class="card shadow-sm mb-3" style="width: 18rem;">
                                <img src="../Assets/img/${rec.img_rec}" class="card-img-top" alt="...">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <p class="card-text">
                                        <h6 class="text-bold">${rec.nom_rec}</h6>
                                        <span class="text-green">${rec.prix_rec} FCFA</span>
                                    </p>
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModulAjRec" onclick="recupIdRecMod(${rec.id_rec})"><i class="fas fa-plus"></i> Ajouter cette récompense</button>
                                </div>
                            </div>
                        `;
                        });
                    }

                    // On insère le HTML généré dans le container
                    el.innerHTML = cardsHtml;
                });


            } else {
                // Erreur direct envoyer par le serveur
                console.console.log(data.message);
                afficherMessage("Erreur serveur : " + data.message, "info", ".erreur-zone", 7000);
            }
        })
        .catch(error => {
            console.log("Erreur : " + error.message);
            afficherMessage("Erreur serveur : " + error.message, "error", ".erreur-zone", 7000);
        });

}

document.addEventListener('DOMContentLoaded', () => {
    getRecompense(); // Votre fonction existante
});


function ModRecompense() {
    fetch("../../api/recompense/", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // let id_actu = localStorage.getItem('id_actu') || '';
                let id_info = localStorage.getItem('id_info') || '';
                // On suppose que data.data.recompense est un tableau d'objets récompense
                const car_mod_container = document.querySelectorAll(".car-mod-container");
                // Pour chaque container, on affiche toutes les récompenses
                car_mod_container.forEach(el => {
                    // On construit le HTML pour toutes les récompenses
                    let cardsHtml = "";
                    data.data.recompense.forEach(rec => {
                        if ((data.data.recompense).length === 0) {
                            cardsHtml = `<div class="alert alert-info">Aucune récompense disponible</div>`;
                            el.innerHTML = cardsHtml;
                            return; 

                        } else {
                            cardsHtml += `
                            <div class="card shadow-sm mb-3" style="width: 18rem;">
                                <img src="../Assets/img/${rec.img_rec}" class="card-img-top" alt="...">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <p class="card-text">
                                        <h6 class="text-bold">${rec.nom_rec}</h6>
                                        <span class="text-green">${rec.prix_rec} FCFA</span>
                                    </p>
                                    <button class="btn btn-success" onclick="UpdateRec(${rec.id_rec}, ${id_info})" id="updateBtn"><i class="fas fa-check"></i> Choisir cette récompense</button>
                                </div>
                            </div>
                        `;
                        }
                    });
                    // On insère le HTML généré dans le container
                    el.innerHTML = cardsHtml;
                });


            } else {
                // Erreur direct envoyer par le serveur
                console.console.log(data.message);
                afficherMessage("Erreur serveur : " + data.message, "info", ".erreur-zone", 7000);
            }
        })
        .catch(error => {
            console.log("Erreur : " + error.message);
            afficherMessage("Erreur serveur : " + error.message, "error", ".erreur-zone", 7000);
        });

}

document.addEventListener('DOMContentLoaded', () => {
    ModRecompense(); // Votre fonction existante
});

function UpdateRec(id_rec, id_info) {
    fetch(`../../api/recompense/UpdateRec.php?id_rec=${encodeURIComponent(id_rec)}&id_info=${encodeURIComponent(id_info)}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                afficherMessage(
                    `Récompense mise à jour avec succès. Date limite : ${data.data.date_limite || '-'}`,
                    "success",
                    ".erreur-zone",
                    3000
                );
                getRecompense();
                ModRecompense();
                // Actualise le profil et les récompenses associées en temps réel
                if (window.refreshProfile) window.refreshProfile();
                // Ferme le modal automatiquement après modification
                const modal = document.getElementById('ModRec');
                if (modal) {
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    bsModal?.hide();
                }
            } else {
                afficherMessage("Erreur serveur : " + data.message, "error", ".erreur-zone", 7000);
            }
        })
        .catch(error => {
            console.log("Erreur : " + error.message);
            afficherMessage("Erreur serveur : " + error.message, "error", ".erreur-zone", 3000);
        });
}