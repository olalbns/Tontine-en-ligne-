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
    fetch("../Admin/api/connexion/", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ email, password })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                
                    window.location.href = "Admin/../Dashboard/";
                
            } else {
                afficherMessage("Erreur: " + data.message, "error", ".erreur-zone", 3000);
            }
        });
});