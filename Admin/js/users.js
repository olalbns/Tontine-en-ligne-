function getUsers() {
    fetch('../api/users/index.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const users = data.data;
                // Afficher les utilisateurs dans la table
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
                                    <button class="btn btn-action btn-view" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-action btn-edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-action btn-delete" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                console.error('Erreur lors de la récupération des utilisateurs');
                afficherMessage("Erreur lors de la récupération des utilisateurs", "error", ".erreur-zone", 7000);

            }
        })
        .catch(error => console.error('Erreur:', error));
}
document.addEventListener('DOMContentLoaded', () => {
    getUsers();
});