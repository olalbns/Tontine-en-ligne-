// Exemple de calcul automatique (à adapter selon votre logique)
const typeCotisation = document.getElementById('typeCotisation');
const montantCotisation = document.getElementById('montantCotisation');
const montantTotal = document.getElementById('montantTotal');
const dateLimite = document.getElementById('dateLimite');
function recupIdRecMod(id_rec) {




    fetch(`../../api/recompense/AjoutRec.php?id_rec=${encodeURIComponent(id_rec)}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
        .then(response => response.json())
        .then(data => {

            document.querySelectorAll(".Aj_rec_choisie").forEach(el => {
                el.innerHTML = `
                     <div class="card shadow-sm mb-3" style="width: 18rem;">
                                <img src="../Assets/img/${data.data.recMod.img_rec}" class="card-img-top"
                                    alt="...">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <p class="card-text"><h6 class="text-bold">${data.data.recMod.nom_rec}</h6>
                                    <span class="text-green">${data.data.recMod.prix_rec} FCFA</span>
                                    </p>
                                </div>
                            </div>
                    `;
            });


            function calculerDateLimite(montant, total, type) {
                const nbPeriodes = Math.ceil(total / montant);
                let date = new Date();

                if (type === 'journalier') {
                    date.setDate(date.getDate() + nbPeriodes);
                } else if (type === 'hebdomadaire') {
                    date.setDate(date.getDate() + (7 * nbPeriodes));
                } else if (type === 'mensuel') {
                    date.setMonth(date.getMonth() + nbPeriodes);
                }

                return date;
            }


            function updateResume() {
                if (data.status !== 'success') {
                    afficherMessage("Erreur serveur : " + data.message, "error", ".erreur-zone", 7000);
                    return;
                }

                const montant = Number(montantCotisation?.value) || 0;
                const total = Number(data?.data?.recMod?.prix_rec) || 0;
                montantTotal.textContent = total.toLocaleString();

                if (montant <= 0) {
                    afficherMessage("Le montant par période est invalide.", "error");
                    dateLimite.textContent = "-";
                    return;
                }

                const type = typeCotisation?.value;
                const date = calculerDateLimite(montant, total, type);

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
                const montant = Number(montantCotisation?.value) || 0;
                const total = Number(data?.data?.recMod?.prix_rec) || 0;
                const type = typeCotisation?.value;

                const date = calculerDateLimite(montant, total, type);

                const dateLim = date.toLocaleDateString("fr-FR", {
                    weekday: "long",
                    year: "numeric",
                    month: "long",
                    day: "numeric"
                }); // Format propre pour PHP

                const id = data.data.user.id_uti;
                const id_rec = data.data.recMod.id_rec;

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
                            afficherMessage("Message : " + data.data.message, "info", ".erreur-zone", 1000);
                             setTimeout(location.reload(), 2000)

                            if (localStorage.getItem("location_recompense")) {
                                window.location= "../Dashboard/";
                            }
                        } else {
                            afficherMessage("Erreur serveur : " + data.message, "error", ".erreur-zone", 3000);
                        }
                    })
                    .catch(error => {
                        console.log("Erreur : " + error.message);
                        afficherMessage("Erreur serveur : " + error.message, "error", ".erreur-zone", 3000);
                    });
            }




            document.getElementById("submit-module")?.addEventListener('submit', async (e) => {
                e.preventDefault();
                validate();
            });

        }); ///////////////////////////////////////////////////////////

}
