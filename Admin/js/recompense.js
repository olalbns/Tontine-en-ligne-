function getRec() {
    fetch("../api/Récompense/", {
        method: "GET",
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
                const ReceContainer = document.querySelectorAll('.ReceContainer');
                ReceContainer.forEach(el => {
                    let cardsHtml = "";

                    // Vérifie si data.data est vide ou non défini
                    if (!data.data || data.data.length === 0) {
                        cardsHtml = `
            <div class="alert alert-info w-100 text-center mt-3">
                Aucun statistique disponible pour le moment.
            </div>
        `;
                    } else {
                        data.data.forEach(item => {
                            cardsHtml += `
            <div class="card shadow-sm mb-3" style="width: 18rem;">
                                <img src="../../Public/Assets/img/${item.img_rec}" class="card-img-top" alt="...">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <p class="card-text">
                                        <h6 class="text-bold">${item.nom_rec}</h6>
                                        <span class="text-green">${item.prix_rec} FCFA</span>
                                    </p>
                                    <button class="btn btn-success" id="updateBtn"><i class="fas fa-pencil"></i> Modifier cette récompense</button>
                                </div>
                            </div>`;
                        });
                    }
                    el.innerHTML = cardsHtml;
                });
            }
        })
        .catch(error => {
            afficherMessage("Erreur : " + error.message, "error", ".erreur-zone", 7000);
            console.log(error.message);
        });
}
getRec();