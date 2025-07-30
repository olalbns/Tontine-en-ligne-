// Exemple de calcul automatique (à adapter selon votre logique)
const typeCotisation = document.getElementById('typeCotisation');
const montantCotisation = document.getElementById('montantCotisation');
const montantTotal = document.getElementById('montantTotal');
const dateLimite = document.getElementById('dateLimite');
const selectRecompense = document.getElementById('selectRecompense');

let recompensesAssociees = [];
let selectedRec = null;

// Charger la liste des récompenses associées à l'utilisateur
function loadRecompenses() {
    const id_uti = document.cookie
        .split('; ')
        .find(row => row.startsWith('User_id='))?.split('=')[1] || '';
    fetch(`../../api/recompense/?`, { method: "GET" })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success' && data.data.recCh) {
                recompensesAssociees = data.data.recCh;
                selectRecompense.innerHTML = '<option value="">Choisir une récompense</option>';
                recompensesAssociees.forEach(rec => {
                    selectRecompense.innerHTML += `<option value="${rec.id_info}">${rec.nom_rec}</option>`;
                });
            }
        });
}
loadRecompenses();

selectRecompense?.addEventListener('change', function () {
    const id_info = this.value;
    selectedRec = recompensesAssociees.find(r => r.id_info == id_info);
    if (selectedRec) {
        // Affiche le prix de la récompense choisie
        montantTotal.textContent = selectedRec.prix_rec || 0;
        // Recharge les infos de cotisation pour la récompense sélectionnée
        showUpdateble(id_info);
    } else {
        montantTotal.textContent = "0";
        // Réinitialise le formulaire si aucune récompense sélectionnée
        document.querySelector("#typeCotisation").value = "";
        document.querySelector("#montantCotisation").value = "";
        dateLimite.textContent = "--/--/----";
        window._selectedCotisation = null;
    }
});

// Adapter la récupération des infos de cotisation pour la récompense sélectionnée
function showUpdateble(id_info) {
    if (!id_info) return;
    fetch(`../../api/users/infocotie.php?id_info=${encodeURIComponent(id_info)}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'success') {
                afficherMessage("Erreur serveur : " + data.message, "error", ".erreur-zone", 7000);
                return;
            }
            document.querySelector("#typeCotisation").value = data.data.user.types;
            document.querySelector("#montantCotisation").value = data.data.user.montantChoisie;
            montantTotal.textContent = data.data.rec.prix_rec || 0;
            window._selectedCotisation = data;
            updateResume(); // Met à jour la date limite dès chargement
        })
        .catch(error => {
            console.log("Erreur : " + error.message);
            afficherMessage("Erreur serveur : " + error.message, "error", ".erreur-zone", 3000);
        });
}

function updateResume() {
    const data = window._selectedCotisation;
    if (!data || data.status !== 'success') {
        dateLimite.textContent = "--/--/----";
        return;
    }
    const montant = Number(montantCotisation?.value) || 0;
    const total = Number(data?.data?.rec?.prix_rec) || 0;
    montantTotal.textContent = total.toLocaleString();

    if (montant <= 0) {
        afficherMessage("Le montant par période est invalide.", "error");
        dateLimite.textContent = "-";
        return;
    }

    const nbPeriodes = Math.ceil(total / montant);
    let date = new Date();
    const type = typeCotisation?.value;

    if (type === 'journalier') {
        date.setDate(date.getDate() + nbPeriodes);
    } else if (type === 'hebdomadaire') {
        date.setDate(date.getDate() + (7 * nbPeriodes));
    } else if (type === 'mensuel') {
        date.setMonth(date.getMonth() + nbPeriodes);
    } else {
        afficherMessage("Type de cotisation inconnu.", "warning");
        dateLimite.textContent = "-";
        return;
    }

    dateLimite.textContent = date.toLocaleDateString("fr-FR", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
    });
}

typeCotisation.addEventListener('change', updateResume);
montantCotisation.addEventListener('input', updateResume);

fetch("../../api/users/", {
    method: "POST",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded"
    }
})
    .then(response => response.json())
    .then(data => {
        function validate() {
            const data = window._selectedCotisation;
            if (!data || data.status !== 'success') return;
            let date = new Date();
            const type = typeCotisation?.value;
            const montant = Number(montantCotisation?.value) || 0;
            const total = Number(data?.data?.rec?.prix_rec) || 0;
            const nbPeriodes = Math.ceil(total / montant);

            if (type === 'journalier') {
                date.setDate(date.getDate() + nbPeriodes); // 1 jour par cotisation
            } else if (type === 'hebdomadaire') {
                date.setDate(date.getDate() + (7 * nbPeriodes)); // 1 semaine par cotisation
            } else if (type === 'mensuel') {
                date.setMonth(date.getMonth() + nbPeriodes); // 1 mois par cotisation
            } else {
                afficherMessage("Type de cotisation inconnu.", "warning");
            }
            const id_uti = data.data.user.id_uti;
            const id_rec = data.data.rec.id_rec;
            const id_info = data.data.user.id_info;
            fetch(`../../api/users/updateInfocotie.php`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: JSON.stringify({
                    montant: montant,
                    dateLimite: date,
                    id_uti: id_uti,
                    types: type,
                    id_rec: id_rec,
                    id_info: id_info
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Erreur direct envoyer par le serveur
                        afficherMessage("Message : " + data.data.message, "info", ".erreur-zone", 1000);
                        
                       window.location.href = "../../Public/ChoisirModifierRecompense/";

                    } else {
                        // Erreur direct envoyer par le serveur
                        afficherMessage("Erreur serveur : " + data, "error", ".erreur-zone", 3000);
                    }
                })
                .catch(error => {
                    console.log("Erreur : " + error.message);
                    afficherMessage("Erreur serveur : " + error.message, "error", ".erreur-zone", 3000);
                });
        };

       
        document.getElementById("submit-module")?.addEventListener('submit', async (e) => {
            e.preventDefault();
            validate();

        });
        setTimeout(updateResume, 2000);
        
    });


