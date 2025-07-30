const submitButton = document.querySelector('.btn');
submitButton.addEventListener('click', function (event) {
    event.preventDefault();
    const email = document.querySelector('input[type="email"]').value;
    const password = document.querySelector('input[type="password"]').value;

    // Vérification des champs vides
    if (!email || !password) {
        afficherMessage("Erreur: Veuillez remplir tous les champs.", "error", ".erreur-zone", 3000);
        return;
    }

    // Envoi des données au serveur
    fetch("../../api/connexion/", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ email, password })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                if (document.cookie.includes('Insc')) {
                    window.location.href = "../Récompense/";
                }else {
                    window.location.href = "../Dashboard/";
                }
            } else { 
                afficherMessage("Erreur: " + data.message, "error", ".erreur-zone", 3000);
            }
        });
});