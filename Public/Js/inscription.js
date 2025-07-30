const submitButton = document.querySelector('.btn');
submitButton.addEventListener('click', function(event) {
        event.preventDefault(); 
        const nom = document.querySelector('input[name="nom"]').value;
        const prenoms = document.querySelector('input[name="prenoms"]').value;  
        const email = document.querySelector('input[name="email"]').value;
        const tel = document.querySelector('input[name="telephone"]').value;
        const motdepasse = document.querySelector('input[name="motdepasse"]').value;
        // Vérification des champs vides
        if (!nom || !prenoms || !email || !tel || !motdepasse) {
            afficherMessage("Erreur: Veuillez remplir tous les champs.", "error", ".erreur-zone", 3000);
            return;
        }

        fetch("../../api/inscription/", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ nom, prenoms, email, tel, motdepasse })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    afficherMessage(data.message, "success", ".erreur-zone", 2000);
                    setTimeout(() => {
                        window.location.href = "../Connexion/";
                    }, 1000);
                } else {
                    afficherMessage("Erreur: " + data.message, "error", ".erreur-zone", 3000);
                }
            });
        });