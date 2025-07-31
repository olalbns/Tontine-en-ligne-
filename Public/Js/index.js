function ModRecompense() {
    fetch("../api/recompense/i.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data?.status !== 'success' || !data?.data) {
            throw new Error("Structure de données invalide");
        }

        const carModContainers = document.querySelectorAll(".index-recompense");
        const recModData = data.data.recMod || [];

        if (!Array.isArray(recModData)) {
            throw new Error("recMod n'est pas un tableau");
        }

        if (recModData.length === 0) {
            carModContainers.forEach(container => {
                container.innerHTML = `
                    <div class="alert alert-info w-100">
                        Aucune récompense disponible pour le moment
                    </div>
                `;
            });
            return;
        }

        carModContainers.forEach(container => {
            try {
                const cardsHtml = recModData.map(rec => {
                    if (!rec?.id_rec || !rec?.nom_rec || !rec?.prix_rec) {
                        console.warn("Récompense incomplète:", rec);
                        return '';
                    }
                    
                    return `
                        <div class="card shadow-sm mb-3 align-items-center" style="width: 18rem;">
                            <img src="../Public/Assets/img/${rec.img_rec || 'default.jpg'}" 
                                 class="card-img-top" 
                                 alt="${rec.nom_rec}"
                                 style="height: 180px; object-fit: cover; width: 108%;">
                            <div class="card-body d-flex flex-column align-items-center">
                                <div class="text-center">
                                    <h6 class="text-bold mb-2">${rec.nom_rec}</h6>
                                    <span class="text-success fw-bold d-block">${rec.prix_rec} FCFA</span>
                                </div>
                                <button class="btn btn-success mt-3 w-100" 
                                        onclick="selectRec('${rec.id_rec}', '${rec.nom_rec}')">
                                    <i class="fas fa-check me-2"></i>Choisir cette récompense
                                </button>
                            </div>
                        </div>
                    `;
                }).join('');

                container.innerHTML = cardsHtml || `
                    <div class="alert alert-warning">
                        Aucune récompense valide à afficher
                    </div>
                `;

            } catch (error) {
                console.error("Erreur de génération HTML:", error);
                container.innerHTML = `
                    <div class="alert alert-danger">
                        Erreur d'affichage des récompenses
                    </div>
                `;
            }
        });
    })
    .catch(error => {
        console.error("Erreur:", error);
        document.querySelectorAll(".index-recompense").forEach(container => {
            container.innerHTML = `
                <div class="alert alert-danger">
                    Erreur de chargement: ${error.message}
                </div>
            `;
        });
    });
}

function selectRec(idRec, nomRec) {
    if (!idRec || !nomRec) {
        console.error("ID ou nom de récompense manquant");
        return;
    }
    window.location.href = "Connexion";
}

document.addEventListener("DOMContentLoaded", ModRecompense);