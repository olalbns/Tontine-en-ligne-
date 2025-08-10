function getUsers() {
    fetch('../api/users/index.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const users = data.data;
                const tableBody = document.querySelector('.users-table');
                tableBody.innerHTML = '';

                users.forEach(user => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${user.id_uti}</td>
                        <td>${user.nom_uti} ${user.prenom_uti}</td>
                        <td>${user.email_uti}</td>
                        <td>${user.num_uti}</td>
                        <td>${user.date_uti}</td>
                        <td>
                            <button class="btn btn-action btn-view" title="Voir" data-id="${user.id_uti}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-action btn-edit" title="Modifier" data-id="${user.id_uti}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-action btn-delete" title="Supprimer" data-id="${user.id_uti}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                // Bouton Voir
                document.querySelectorAll('.btn-view').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.getAttribute('data-id');
                        const user = users.find(u => u.id_uti == id);
                        if (user) {
                            document.getElementById('viewUserName').textContent = `${user.nom_uti} ${user.prenom_uti}`;
                            document.getElementById('viewUserEmail').textContent = user.email_uti;
                            document.getElementById('viewUserPhone').textContent = user.num_uti;
                            document.getElementById('viewUserDate').textContent = user.date_uti;
                            new bootstrap.Modal(document.getElementById('modalViewUser')).show();
                        }
                    });
                });

                // Bouton Modifier
                document.querySelectorAll('.btn-edit').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.getAttribute('data-id');
                        const user = users.find(u => u.id_uti == id);
                        if (user) {
                            document.getElementById('editUserId').value = user.id_uti;
                            document.getElementById('editUserNom').value = user.nom_uti;
                            document.getElementById('editUserPrenom').value = user.prenom_uti;
                            document.getElementById('editUserEmail').value = user.email_uti;
                            document.getElementById('editUserPhone').value = user.num_uti;
                            new bootstrap.Modal(document.getElementById('modalEditUser')).show();
                        }
                    });
                });

                // Bouton Supprimer
                document.querySelectorAll('.btn-delete').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.getAttribute('data-id');
                        document.getElementById('deleteUserId').value = id;
                        new bootstrap.Modal(document.getElementById('modalDeleteUser')).show();
                    });
                });

            } else {
                afficherMessage("Erreur lors de la récupération des utilisateurs", "error", ".erreur-zone", 7000);
            }
        })
        .catch(error => console.error('Erreur:', error));
}

// Soumission formulaire modification
document.getElementById('formEditUser').addEventListener('submit', function (e) {
    e.preventDefault();

    // Récupérer chaque champ individuellement
    const id_uti = document.getElementById('editUserId').value.trim();
    const nom_uti = document.getElementById('editUserNom').value.trim();
    const prenom_uti = document.getElementById('editUserPrenom').value.trim();
    const email_uti = document.getElementById('editUserEmail').value.trim();
    const num_uti = document.getElementById('editUserPhone').value.trim();

    // Construire les données à envoyer
    const formData = new FormData();
    formData.append('id_uti', id_uti);
    formData.append('nom_uti', nom_uti);
    formData.append('prenom_uti', prenom_uti);
    formData.append('email_uti', email_uti);
    formData.append('num_uti', num_uti);

    console.log(formData);
    // Envoi de la requête
    fetch('../api/users/update.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        if (res.status === 'success') {
            afficherMessage("Utilisateur modifié avec succès", "success", ".erreur-zone", 5000);
            bootstrap.Modal.getInstance(document.getElementById('modalEditUser')).hide();
            getUsers();
        } else {
            afficherMessage("Erreur lors de la modification", "error", ".erreur-zone", 5000);
        }
    })
    .catch(error => {
        console.error("Erreur lors de la modification :", error);
        afficherMessage("Erreur de connexion au serveur", "error", ".erreur-zone", 5000);
    });
});


// Soumission suppression
document.getElementById('formDeleteUser').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('../api/users/delete.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        if (res.status === 'success') {
            afficherMessage("Utilisateur supprimé avec succès", "success", ".erreur-zone", 5000);
            bootstrap.Modal.getInstance(document.getElementById('modalDeleteUser')).hide();
            getUsers();
        } else {
            afficherMessage("Erreur lors de la suppression", "error", ".erreur-zone", 5000);
        }
    });
});


document.getElementById('formAddUser').addEventListener('submit', function (e) {
    e.preventDefault();

    const payload = {
        nom_uti: document.getElementById('addNom').value.trim(),
        prenom_uti: document.getElementById('addPrenom').value.trim(),
        email_uti: document.getElementById('addEmail').value.trim(),
        num_uti: document.getElementById('addPhone').value.trim(),
        password: document.getElementById('addPassword').value.trim()
    };

    fetch('../api/users/create.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(res => {
        if (res.status === 'success') {
            afficherMessage("Utilisateur ajouté avec succès", "success", ".erreur-zone", 5000);
            bootstrap.Modal.getInstance(document.getElementById('modalAddUser')).hide();
            getUsers();
        } else {
            afficherMessage(res.message, "error", ".erreur-zone", 5000);
        }
    })
    .catch(error => {
        console.error("Erreur :", error);
        afficherMessage("Erreur de connexion", "error", ".erreur-zone", 5000);
    });
});


document.addEventListener('DOMContentLoaded', () => {
    getUsers();
});