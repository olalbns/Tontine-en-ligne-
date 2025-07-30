let infoCotisationsData = []; // Variable globale pour stocker les données infocoti

document.addEventListener('DOMContentLoaded', () => {
    // 1. Récupérer les données de cotisation (incluant infocoti) au chargement
    fetch("../../api/cotisation/", {
        method: "GET",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.infocoti) {
                infoCotisationsData = data.infocoti; // Stocke les données infocoti
            }


            showCoti();
            showCotiDash();
            showPayementMethodSaved();
        });

    // 2. Récupérer les récompenses et gérer les écouteurs d'événements
    fetch("../../api/recompense/", {
        method: "GET",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
        .then(response => response.json())
        .then(data => {
            const containerElements = document.querySelectorAll(".rec_a_cotiser");

            if (!data.data?.recCh || data.data.recCh.length === 0) {
                containerElements.forEach(container => {
                    container.innerHTML = `
                <div class="alert alert-info w-100 text-center mt-3">
                    Aucune récompense disponible pour le moment.
                </div>
            `;
                });
                return;
            }

            containerElements.forEach(container => {
                container.innerHTML = ""; // Vider le contenu

                data.data.recCh.forEach(rec => {
                    let buttonHTML = '';

                    if (rec.statut === 'terminé') {
                        buttonHTML = `<div class="btn btn-secondary disabled">Cotisation terminée</div>`;
                    } else {
                        buttonHTML = `
        <label class="btn btn-success" style="cursor:pointer;">
            <input type="radio" name="rec_ch" value="${rec.id_rec}" class="rec-radio" data-prix="${rec.prix_rec}" style="margin-right:5px;"> Sélectionner
        </label>
    `;
                    }

                    const cardHTML = `
    <div class="card shadow-sm mb-3 select${rec.id_rec}" style="width: 18rem; cursor:pointer;">
        <img src="../Assets/img/${rec.img_rec}" class="card-img-top" alt="${rec.nom_rec}">
        <div class="card-body d-flex flex-column align-items-center">
            <p class="card-text">
                <h6 class="text-bold">${rec.nom_rec}</h6>
                <span class="text-green">${rec.prix_rec} FCFA</span>
            </p> 
            ${buttonHTML}
        </div>
    </div>
`;


                    container.innerHTML += cardHTML;

                    // Gestion du click sur la carte
                    const cardDiv = container.querySelector(`.select${rec.id_rec}`);
                    if (cardDiv && rec.statut !== 'terminé') {
                        cardDiv.addEventListener('click', function (e) {
                            if (e.target.tagName !== 'INPUT') {
                                const radio = cardDiv.querySelector('.rec-radio');
                                if (radio) {
                                    radio.checked = true;
                                    radio.dispatchEvent(new Event('change'));
                                }
                            }
                        });
                    }

                });
            });

            // Ajouter des écouteurs d'événements à tous les boutons radio de récompense
            const recRadios = document.querySelectorAll('input[name="rec_ch"]');
            recRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const selectedRecId = parseInt(this.value); // Récupère l'ID de la récompense cliquée

                    // Cherche le montantChoisie correspondant dans les données infocoti
                    const correspondingInfo = infoCotisationsData.find(info => info.id_rec === selectedRecId);

                    if (correspondingInfo) {
                        document.querySelector('input[type="number"]').value = correspondingInfo.montantChoisie;
                    } else {
                        // Si aucune correspondance trouvée, vider le champ ou mettre une valeur par défaut
                        document.querySelector('input[type="number"]').value = '';
                    }
                });
            });
        });

});

function showPayementMethodSaved() {
    fetch("../../api/payement/", {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success' && Array.isArray(data.data)) {
                const container = document.querySelector('.payemntdiv');
                const sendButton = document.querySelector('.confirmBtn'); // Assurez-vous d'avoir un ID pour votre bouton d'envoi, par exemple 'sendButtonId'

                container.innerHTML = "";
                if (data.data.length === 0) {
                    container.innerHTML = `<div class="alert alert-success">Aucun moyens enregistrer pour le moment.<br> <i class="fa fa-info-circle"></i> Vous devez avoir au moin un moyens enregistrer pour cotiser</div>`;
                    if (sendButton) {
                        sendButton.disabled = true; // Désactive le bouton d'envoi
                    }
                } else {
                    if (sendButton) {
                        sendButton.disabled = false; // Réactive le bouton d'envoi s'il y a des méthodes
                    }
                    data.data.forEach(method => {
                        let html = '';
                        if (method.types === 'Carte_Bancaire') {
                            html = `
                    <div class="d-flex select methodElement flex-column-reverse p-4 rounded-4 shadow-sm w-auto mb-3 flex-column align-items-end" data-id="${method.id_method}">
                        <button class="btn btn-success"> <input type="radio" name="methode" value="${method.id_method}" class="method-radio"> Selectionné </button>
                        <div class="d-flex flex-column align-items-center">
                            <i style="width: 38%; background-color: rgba(0, 0, 255, 0.589);" class="far fa-credit-card p-3 rounded-pill text-white"></i>
                            <h5 class="mt-2 mb-1 methodType">Carte bancaire</h5>
                            <span>${method.details[1] || ''}</span>
                            <span>${method.details[0]?.slice(0, 6) || ''}...</span>
                        </div>
                    </div>
                    `;
                        } else if (method.types === 'mobile_money') {
                            html = `
                    <div class="d-flex methodElement flex-column-reverse p-4 rounded-4 shadow-sm w-auto mb-3 flex-column align-items-end" data-id="${method.id_method}">
                        <button class="btn btn-success"> <input type="radio" name="methode" value="${method.id_method}" class="method-radio"> Selectionné </button>
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-mobile-alt p-3 rounded-pill" style="width: 38%; background-color: rgba(255, 166, 0, 0.589); color: black;"></i>
                            <h5 class="mt-2 mb-1 methodType">Mobile Money</h5>
                            <span class="fw-bold">${method.details[1] || ''}</span>
                            <span>${method.details[0] || ''}</span>
                        </div>
                    </div>
                    `;
                        }
                        container.innerHTML += html;
                    });

                    // Ajoute le gestionnaire de clic après le rendu
                    const methodElements = container.querySelectorAll('.methodElement');
                    methodElements.forEach(element => {
                        element.addEventListener('click', function () {
                            const radio = element.querySelector('.method-radio');
                            if (radio) {
                                radio.checked = true;
                            }
                        });
                    });

                }
            }
        });
}




// Ajout gestionnaire pour bouton de confirmation
document.addEventListener("DOMContentLoaded", function () {
    const confirmBtn = document.querySelector(".confirmBtn");
    if (confirmBtn) {
        confirmBtn.addEventListener("click", function () {
            // Récupère l'id de la récompense sélectionnée
            const recRadio = document.querySelector('input[name="rec_ch"]:checked');
            if (!recRadio) {
                afficherMessage("Erreur: Veuillez sélectionner une récompense.", "error", ".erreur-zone", 6000);
                return;
            }
            const id_method = document.querySelector('input[name="methode"]:checked');
            if (!id_method) {
                afficherMessage("Erreur: Veuillez choisir une méthode de payement", "error", ".erreur-zone", 6000);
                return;
            }
            // Récupère l'id de la récompense sélectionnée
            const id_rec = recRadio.value;
            // Récupère le montant à payer
            const montant = document.querySelector('input[type="number"]').value;
            // id_methode fixé à 1
            const id_methode = id_method.value;
            fetch("../../api/cotisation/", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    id_rec: id_rec,
                    id_methode: id_methode,
                    montant: montant
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        afficherMessage("Success: Cotisation enregistré", "info", ".erreur-zone", 4000);

                        // Optionnel: reload ou mise à jour de l'UI
                    } else {
                        afficherMessage("Erreur serveur" + data.message, "error", ".erreur-zone", 6000);
                    }
                });
        });
    }
});


function showCoti() {

    fetch("../../api/cotisation/", {
        method: "GET",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
        .then(response => response.json())
        .then(data => {



            const tableBody = document.querySelector(".tb_rec");
            if (tableBody) {
                tableBody.innerHTML = ""; // Vider le contenu existant
                data.data.forEach(coti => {
                    tableBody.innerHTML += `
                    <tr>
                        <th style="padding: 10px;" scope="row">${coti.id_coti}</th>
                        <td style="padding: 10px;">${coti.date}</td>
                        <td style="padding: 10px;">${coti.montant} FCFA</td>
                        <td style="padding: 10px;">${coti.nom_recompense}</td>
                        <td style="padding: 10px;">${coti.methode_paiement}</td>
                    </tr>
                `;
                });
            }
        })
        .catch(error => {
            afficherMessage("Erreur : " + error.message, "error", ".erreur-zone", 6000);
        });
}

function showCotiDash() {
    fetch("../../api/cotisation/", {
        method: "PUT",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector(".tb_rec_dash");
            if (tableBody) {
                tableBody.innerHTML = ""; // Vider le contenu existant
                data.data.forEach(coti => {
                    tableBody.innerHTML += `
                    <tr>
                        <th style="padding: 10px;" scope="row">${coti.id_coti}</th>
                        <td style="padding: 10px;">${coti.date}</td>
                        <td style="padding: 10px;">${coti.montant} FCFA</td>
                        <td style="padding: 10px;">${coti.nom_rec}</td>
                        <td style="padding: 10px;">${coti.id_method}</td>
                    </tr>
                `;
                });
            }
        })
        .catch(error => {
            afficherMessage("Erreur : " + error.message, "error", ".erreur-zone", 6000);
        });
}
document.addEventListener('DOMContentLoaded', () => {
    showCoti();
    showCotiDash();
    showPayementMethodSaved();
});