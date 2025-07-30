var selectPayemnt = document.getElementById("selectPayemnt");
var formulaire = document.getElementById("formulaire");

selectPayemnt.addEventListener("change",
    function fieldShow() {
        var cardBancaire = document.getElementById("cardBancaire");
        var mobileMoney = document.getElementById('mobileMoney');

        switch (this.value) {
            case 'mobile_money':
                mobileMoney.removeAttribute('hidden', true);
                cardBancaire.setAttribute('hidden', true);
                break;
            case 'Carte_Bancaire':
                cardBancaire.removeAttribute('hidden', true);
                mobileMoney.setAttribute('hidden', true);
                break;
            default:
                cardBancaire.setAttribute('hidden', true);
                mobileMoney.setAttributeAttribute('hidden', true);
                break
        }
    }
);

function getPayementFormData() {
    const type = selectPayemnt.value;
    let infos = [];
    if (type === 'mobile_money') {
        const mobileMoney = document.getElementById('mobileMoney');
        if (!mobileMoney.hasAttribute('hidden')) {
            infos.push(mobileMoney.querySelector('input[name="mobile_number"]').value);
            infos.push(mobileMoney.querySelector('input[name="last_name"]').value);
            infos.push(mobileMoney.querySelector('input[name="first_name"]').value);
        }
    } else if (type === 'Carte_Bancaire') {
        const cardBancaire = document.getElementById('cardBancaire');
        if (!cardBancaire.hasAttribute('hidden')) {
            infos.push(cardBancaire.querySelector('input[name="card_number"]').value);
            infos.push(cardBancaire.querySelector('input[name="card_holder"]').value);
            infos.push(cardBancaire.querySelector('input[name="expiry_date"]').value);
            infos.push(cardBancaire.querySelector('input[name="cvv"]').value);
        }
    }
    return { type, infos };
}

// Fonction pour envoyer les données à l'API
function submitPayementForm() {
    const { type, infos } = getPayementFormData();
    if (!type || infos.length === 0) {
        afficherMessage("Veuillez remplir tous les champs du formulaire. ", "error", ".erreur-zone", 3000);
        return;
    }
    fetch("../../api/payement/index.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            type: type,
            details: infos
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Optionnel : reset le formulaire ou afficher un message
                afficherMessage("Méthode de paiement enregistrée ! ", "success", ".erreur-zone", 3000);

            } else {
                afficherMessage("Erreur serveur : " + data.message || "Impossible d'enregistrer. ", "error", ".erreur-zone", 3000);



            }
        })
        .catch(error => {
            afficherMessage("Erreur serveur : " + error.message, "error", ".erreur-zone", 3000);

        });
}

// Ajout de l'événement sur le bouton du formulaire
document.querySelector('.payement-form form').addEventListener('submit', function (e) {
    e.preventDefault();
    submitPayementForm();
    showPayementMethodSaved();
    setTimeout(() => {
        showPayementMethodSaved();
    }, timeout = 2000);
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
            container.innerHTML = "";
            if (data.data.length === 0) {
                container.innerHTML = `<div class="alert alert-success">Aucun moyens enregistrer pour le moment</div>`;
            } else {
                data.data.forEach(method => {
                    let html = '';
                    if (method.types === 'Carte_Bancaire') {
                        html = `
                        <div class="d-flex p-4 rounded-4 shadow-sm w-auto mb-3 flex-column align-items-end methodElement" data-id="${method.id_method}">
                            <button class="btn btn-outline-danger btn-sm mb-2 deleteButtons" title="Supprimer">
                                <i class="fa fa-trash"></i>
                            </button>
                            <div class="d-flex flex-column align-items-center">
                                <i style="width: 38%; background-color: rgba(0, 0, 255, 0.589);" class="far fa-credit-card p-3 rounded-pill text-white"></i>
                                <h5 class="mt-2 mb-1 methodType">Carte bancaire</h5>
                                <span>${method.details[1] || ''}</span>
                                <span>${method.details[0]?.slice(0,6) || ''}...</span>
                            </div>
                        </div>`;
                    } else if (method.types === 'mobile_money') {
                        html = `
                        <div class="d-flex p-4 rounded-4 shadow-sm w-auto mb-3 flex-column align-items-end methodElement" data-id="${method.id_method}">
                            <button class="btn btn-outline-danger btn-sm mb-2 deleteButtons" title="Supprimer">
                                <i class="fa fa-trash"></i>
                            </button>
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-mobile-alt p-3 rounded-pill" style="width: 38%; background-color: rgba(255, 166, 0, 0.589); color: black;"></i>
                                <h5 class="mt-2 mb-1 methodType">Mobile Money</h5>
                                <span class="fw-bold">${method.details[1] || ''}</span>
                                <span>${method.details[0] || ''}</span>
                            </div>
                        </div>`;
                    }
                    container.innerHTML += html;
                });

                // Ajout des événements de suppression après affichage
                const methodElements = container.querySelectorAll('.methodElement');
                methodElements.forEach(element => {
                    const deleteButton = element.querySelector('.deleteButtons');
                    deleteButton.addEventListener('click', function (e) {
                        e.preventDefault();
                        const methodId = element.getAttribute('data-id');
                        const methodType = element.querySelector('.methodType').textContent.trim();
                        showDeleteModal(methodId, methodType);
                    });
                });
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    showPayementMethodSaved();
});

let deleteModal = null;
let deleteMethodId = null;
let deleteMethodType = null;

// Fonction pour afficher le modal de confirmation
function showDeleteModal(methodId, methodType) {
    deleteMethodId = methodId;
    deleteMethodType = methodType;
    // Remplit le texte du modal
    document.getElementById('deleteModalBody').textContent =
        `Êtes-vous sûr de vouloir supprimer ce moyen de paiement : ${methodType} ${deleteMethodId} ?`;
    // Affiche le modal
    const modalElement = document.getElementById('deletePayementModal');
    if (modalElement) {
        deleteModal = bootstrap.Modal.getOrCreateInstance(modalElement);
        deleteModal.show();
    }
}

// Gestion du bouton "Confirmer" du modal
document.getElementById('confirmDeletePayement').addEventListener('click', function () {
    if (deleteMethodId) {
        fetch("../../api/payement/delete.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id_method: deleteMethodId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                afficherMessage("Moyen de paiement supprimé avec succès !", "success", ".erreur-zone", 3000);
                showPayementMethodSaved();
            } else {
                afficherMessage("Erreur lors de la suppression : " + data.message, "error", ".erreur-zone", 3000);
            }
            if (deleteModal) deleteModal.hide();
        })
        .catch(error => {
            afficherMessage("Erreur serveur : " + error.message, "error", ".erreur-zone", 3000);
            if (deleteModal) deleteModal.hide();
        });
    }
});