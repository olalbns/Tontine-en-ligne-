// Fonction pour récupérer le profil de l'utilisateur
function getUsersProfile() {
    fetch("../../api/users/", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.cookie = "id_rec=" + data.data.user.id_rec + "; path=/";
                // Affiche le nom dans les éléments avec la classe .profile_nom
                document.querySelectorAll(".profile_name").forEach(el => {
                    el.textContent = data.data.user.nom_uti;
                });

                // Affiche le prénom dans les éléments avec la classe .profile_prenom
                document.querySelectorAll(".profile_prenom").forEach(el => {
                    el.textContent = data.data.user.prenom_uti;
                });

                // Affiche le nom et le prénom ensemble dans les inputs avec la classe
                document.querySelectorAll(".profile_allName").forEach(el => {
                    el.value = `${data.data.user.nom_uti} ${data.data.user.prenom_uti}`;
                });

                document.querySelectorAll(".profile_email").forEach(el => {
                    el.value = `${data.data.user.email_uti}`;
                });

                document.querySelectorAll(".profile_tel").forEach(el => {
                    el.value = `${data.data.user.num_uti}`;
                });

                document.querySelectorAll(".profile_balance").forEach(el => {
                    el.value = `${data.data.user.total_balance} FCFA`;
                    el.textContent = `${data.data.user.total_balance} FCFA`;
                });
                document.querySelectorAll(".profile_balanc").forEach(el => {
                    el.value = `${data.data.user.total_balance} FCFA`;
                });
                document.querySelectorAll(".profile_id").forEach(el => {
                    el.value = `${data.data.user.id_uti}`;
                });


                fetch("../../api/recompense/", {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        const containerElements = document.querySelectorAll(".rec_choisie");
                        const containerForModifi = document.querySelectorAll(".rec-modifiable");

                        const showNoDataMessage = (container) => {
                            container.innerHTML = `
                       <div class="alert alert-info w-100 text-center mt-3">
                            Aucune statistique disponible pour le moment.
                     </div>
        `;
                        };

                        if (!data.data?.recCh || data.data.recCh.length === 0) {
                            // Cas où il n'y a aucune donnée
                            containerElements.forEach(container => showNoDataMessage(container));
                            containerForModifi.forEach(container => showNoDataMessage(container));
                            return;
                        }

                        containerElements.forEach(container => {
                            container.innerHTML = data.data.recCh.map(rec => `
            <div class="card shadow-sm mb-3" style="width: 18rem;">
                <img src="../Assets/img/${rec.img_rec}" class="card-img-top" alt="${rec.nom_rec}">
                <div class="card-body d-flex flex-column align-items-center">
                    <p class="card-text">
                        <h6 class="text-bold">${rec.nom_rec}</h6>
                        <span class="text-green">${rec.prix_rec} FCFA</span>
                    </p>
                </div>
            </div>
        `).join('');
                        });

                        containerForModifi.forEach(container => {
                            container.innerHTML = data.data.recCh.map(rec => `
            <div class="card shadow-sm mb-3" style="width: 18rem;">
                <img src="../Assets/img/${rec.img_rec}" class="card-img-top" alt="${rec.nom_rec}">
                <div class="card-body d-flex flex-column align-items-center">
                    <p class="card-text">
                        <h6 class="text-bold">${rec.nom_rec}</h6>
                        <span class="text-green">${rec.prix_rec} FCFA</span>
                    </p>
                    <button onclick="actuCook(${rec.id_rec}, ${rec.id_info})" 
                            class="btn btn-success" 
                            data-bs-toggle="modal" 
                            data-bs-target="#ModRec">
                        <i style="color: white;" class="fas fa-pen"></i>
                        Modifier la récompense
                    </button>
                </div>
            </div>
        `).join('');
                        });
                    })

                // document.querySelectorAll(".rec_choisie").forEach(el => {
                //     el.innerHTML = `
                //      <div class="card shadow-sm mb-3" style="width: 18rem;">
                //                 <img src="../Assets/img/${data.data.rec.img_rec}" class="card-img-top"
                //                     alt="...">
                //                 <div class="card-body d-flex flex-column align-items-center">
                //                     <p class="card-text"><h6 class="text-bold">${data.data.rec.nom_rec}</h6>
                //                     <span class="text-green">${data.data.rec.prix_rec} FCFA</span>
                //                     </p>
                //                 </div>
                //             </div>
                //     `;
                // });

                // document.querySelectorAll(".profile_allName").forEach(el => {
                //     el.value = `${data.data.user.nom_uti}`;
                // });

                // Affiche l'image de profil dans les éléments avec la classe .profile_img
                document.querySelectorAll(".profile_img").forEach(el => {
                    el.src = data.data.user.img_uti;
                });
            } else {
                // Erreur direct envoyer par le serveur
                afficherMessage("Erreur serveur : " + data.message, "error", ".erreur-zone", 3000);
            }
        })
        .catch(error => {
            console.log("Erreur : " + error.message);
            afficherMessage("Erreur serveur : " + error.message, "error", ".erreur-zone", 3000);
        });

}
function actuCook(id_actu, id_info) {
    localStorage.setItem('id_actu', id_actu);
    localStorage.setItem('id_info', id_info);
    ModRecompense();
    console.log("ID de la récompense actuelle :", id_actu, "ID info cotisation :", id_info);
}
function editProfileImg() {
    const btn = document.getElementById("edit-profile-img");
    const imgPreview = document.getElementById("img-edit");

    if (!btn || !imgPreview) return;

    // Crée l'input file si inexistant
    let input = document.getElementById("profile_img_input");
    if (!input) {
        input = document.createElement("input");
        input.type = "file";
        input.accept = "image/*";
        input.style.display = "none";
        input.id = "profile_img_input";
        document.body.appendChild(input);
    }

    // Gestion du changement d'image
    input.addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (!file) return;

        // Vérification du type de fichier
        if (!file.type.match('image.*')) {
            alert('Veuillez sélectionner une image valide');
            return;
        }

        // Récupère juste le nom du fichier sélectionné
        imgPreview.src = "../Assets/img/" + file.name;
    });

    // Déclenche le clic sur l'input file
    btn.addEventListener("click", function () {
        input.value = ""; // Permet de re-sélectionner la même image
        input.click();
    });
}



// Initialisation
document.addEventListener('DOMContentLoaded', function () {
    editProfileImg();
});


// Fonction de modification du profile
document.getElementById('UpdateProfile')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    const btn = form.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;

    try {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';
        btn.disabled = true;


        let img_name = document.getElementById("img-edit")?.src;
        const phone = form.phone_number?.value;
        const full_name = form.full_name.value;
        const email = form.email.value;
        const id = form.id_uti.value;
        const response = await fetch(`../../api/users/updateProfil.php`, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: JSON.stringify({
                phone: phone,
                full_name: full_name,
                email: email,
                id_uti: id,
                img: img_name
            })
        });

        const data = await response.json();

        if (!response.ok) {
            // throw new Error(data.message || 'Erreur lors de la demande de retrait');
            afficherMessage("Erreur serveur : " + data.message, "error", ".erreur-zone", 3000);
        }
        
        afficherMessage("Success : " + data, "info", ".erreur-zone", 3000);

        if (data.status === 'success') {
            getUsersProfile();
        }
    } catch (error) {
        console.error('Erreur d envoie:', error);
        afficherMessage("Erreur d'envoie : " + error.message, "error", ".erreur-zone", 3000);

    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
});


document.addEventListener('DOMContentLoaded', () => {
    getUsersProfile();
});

// Ajoute cette fonction pour permettre une actualisation externe
window.refreshProfile = function () {
    getUsersProfile();
}
function disconnect() {
    // Sélectionne tous les éléments avec la classe 'disconnect'
    document.querySelectorAll(".disconnect").forEach(button => {
        button.addEventListener("click", function () {
            // Crée un modal de confirmation Bootstrap
            const modalHTML = `
                <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="logoutModalLabel">Confirmation de déconnexion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir vous déconnecter ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="button" class="btn btn-danger" id="confirmLogout">Déconnecter</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Ajoute le modal au DOM
            document.body.insertAdjacentHTML('beforeend', modalHTML);

            // Affiche le modal
            const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();

            // Gestion de la confirmation
            document.getElementById('confirmLogout').addEventListener('click', function () {
                // Supprime les cookies
                document.cookie = "id_rec=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = "id_uti=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = "User_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

                // Redirection
                window.location.href = "../Connexion/";

                // Ferme le modal
                logoutModal.hide();

                // Nettoie le modal du DOM après animation
                setTimeout(() => {
                    document.getElementById('logoutModal').remove();
                }, 500);
            });

            // Nettoyage quand le modal est fermé
            document.getElementById('logoutModal').addEventListener('hidden.bs.modal', function () {
                this.remove();
            });
        });
    });
}

// Appel de la fonction
disconnect();
// Ajoute ce code pour vider le localStorage à la fermeture du modal
document.getElementById('ModRec')?.addEventListener('hidden.bs.modal', function () {
    localStorage.removeItem('id_actu');
    localStorage.removeItem('id_info');
});