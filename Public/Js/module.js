// Exemple de calcul automatique (à adapter selon votre logique)
const typeCotisation = document.getElementById('typeCotisation');
const montantCotisation = document.getElementById('montantCotisation');
const montantTotal = document.getElementById('montantTotal');
const dateLimite = document.getElementById('dateLimite');
fetch("../../api/users/", {
    method: "POST",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded"
    }
})
    .then(response => response.json())
    .then(data => {

        function updateResume() {

            if (data.status !== 'success') {
                afficherMessage("Erreur serveur : " + data.message, "error", ".erreur-zone", 7000);
                return;
            }
            const montant = Number(montantCotisation?.value) || 0;
            const total = Number(data?.data?.rec?.prix_rec) || 0;
            montantTotal.textContent = total.toLocaleString();

            // Vérifie que le montant est valide
            if (montant <= 0) {
                afficherMessage("Le montant par période est invalide.", "error");
                dateLimite.textContent = "-";
                return;
            }

            // Calcul du nombre de périodes
            const nbPeriodes = Math.ceil(total / montant);

            // Date de départ
            let date = new Date();
            const type = typeCotisation?.value;

            if (type === 'journalier') {
                date.setDate(date.getDate() + nbPeriodes); // 1 jour par cotisation
            } else if (type === 'hebdomadaire') {
                date.setDate(date.getDate() + (7 * nbPeriodes)); // 1 semaine par cotisation
            } else if (type === 'mensuel') {
                date.setMonth(date.getMonth() + nbPeriodes); // 1 mois par cotisation
            } else {
                afficherMessage("Type de cotisation inconnu.", "warning");
            }

            // Affiche la date limite formatée
            dateLimite.textContent = date.toLocaleDateString("fr-FR", {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric"
            });




        }

        typeCotisation.addEventListener('change', updateResume);
        montantCotisation.addEventListener('input', updateResume);

        function validate() {
            // Date de départ
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

            const id = data.data.user.id_uti
            const dateLim = date.toLocaleDateString("fr-FR", {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric"
            });
            const id_rec = data.data.rec.id_rec;
            fetch(`../../api/users/infocotie.php`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: JSON.stringify({
                    montant: montant,
                    dateLimite: dateLim,
                    id_uti: id,
                    types: type,
                    id_rec: id_rec
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Erreur direct envoyer par le serveur
                        afficherMessage("Message : " + data.data.message, "info", ".erreur-zone", 3000);
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

});


