<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tontine en ligne - Accueil</title>
    <link rel="stylesheet" href="bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome-6-pro-main/css/all.min.css">
    <link rel="stylesheet" href="font-awesome-6-pro-main/css/fontawesome.min.css">
    <link rel="stylesheet" href="Css/index.css">
    <!-- <link rel="stylesheet" href="Css/Dash.css"> -->
   
</head>
<?php
setcookie('Gest_id', '1234588888888888888888888888888888888888888888888888888888222222222222111111111111111111111111111111111111111', time() + 6000000, "/"); // Exemple de cookie pour l'ID utilisateur
?>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-success sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">TNTLN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#"><i class="fa fa-home me-1"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about"><i class="fa fa-info me-1"></i> A propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#present"><i class="fas fa-shield-alt me-1"></i> Avantages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reco"><i class="fas fa-award me-1"></i> Récompense</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact"><i class="fa fa-message me-1"></i> Contact</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" href="Connexion/"><i class="fa fa-user me-1"></i> Se connecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Inscription/"><i class="fa fa-user-circle me-1"></i> S'inscrire</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="erreur-zone"></div>
    <section id="hero" class="d-flex align-items-center">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Épargnez aujourd’hui, gagnez demain !</h1>
            <p class="lead mb-4">
                Rejoignez une communauté de cotisants modernes et atteignez vos
                objectifs financiers sans stress. Gagnez en liberté, en sécurité, et
                surtout en confiance.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="Inscription/" class="btn btn-primary btn-lg">S'inscrire</a>
                <a href="Récompense/" class="btn btn-secondary btn-lg">Découvrir les récompenses</a>
            </div>
        </div>
    </section>

    <section id="about" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-success text-center mb-4">À propos</h2>
            <p class="text-center mx-auto" style="max-width: 800px;">
                <span class="fw-bold">Non_de_la_plate</span> révolutionne l’épargne solidaire. Finie la
                paperasse, vive la simplicité digitale ! <b class="text-success">Cotisez</b>, <b class="text-success">suivez</b>,
                <b class="text-success">recevez</b>. Tout est entre vos mains.
            </p>
        </div>
    </section>

    <section id="present" class="py-5 bg-white">
        <div class="container">
            <h2 class="text-success text-center mb-4">Qu’est-ce qu’une tontine en ligne ?</h2>
            <p class="text-center mx-auto" style="max-width: 800px;">
                La tontine en ligne vous permet de cotiser depuis chez vous, à votre
                rythme — chaque jour, chaque semaine ou chaque mois. À la fin, vous
                recevez une récompense de votre choix : une somme d’argent ou un bien
                comme une moto, un réfrigérateur, etc. Simple, transparente et flexible,
                c’est une nouvelle façon d’atteindre vos objectifs sans pression.
            </p>
        </div>
    </section>

    <section id="reco" class="py-5 bg-success bg-opacity-10">
        <div class="container">
            <h2 class="text-success text-center mb-4">Récompenses disponibles</h2>
            <p class="text-center mb-5 mx-auto" style="max-width: 800px;">
                Vous pouvez choisir de recevoir votre récompense sous forme d’argent ou
                de biens matériels. Voici quelques exemples :
            </p>

            <div class="row row-cols-1 row-cols-md-3 g-4 index-recompense">
                
            </div>
            <a class="text-center text-success" href="Récompense">Voir plus </a>
        </div>
    </section>

    <section id="testimonials" class="py-5 bg-white">
        <div class="container">
            <h2 class="text-success text-center mb-5">Ils nous font confiance</h2>

            <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <p class="card-text fst-italic">
                                "J'ai pu réaliser mon rêve d'acheter une moto grâce à la tontine en
                                ligne. C'est un service fiable et sécurisé!"
                            </p>
                            <p class="card-text text-end fw-bold text-success">- Jean Dupont</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <p class="card-text fst-italic">
                                "La tontine en ligne m'a permis de faire des économies et d'investir
                                dans mon projet. Je recommande vivement!"
                            </p>
                            <p class="card-text text-end fw-bold text-success">- Marie Curie</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <p class="card-text fst-italic">
                                "Une expérience incroyable! J'ai pu cotiser facilement et recevoir ma
                                récompense sans aucun souci."
                            </p>
                            <p class="card-text text-end fw-bold text-success">- Paul Martin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-success text-center mb-5">Comment ça marche ?</h2>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="faq-step p-4 mb-3 border border-success border-start-0 border-end-0 border-bottom-0 rounded-0">
                        <h4 class="text-success fw-bold">1. S'inscrire</h4>
                        <p class="mb-0">
                            Inscrivez-vous sur notre site. Choisissez votre rythme de cotisation.
                        </p>
                    </div>

                    <div class="faq-step p-4 mb-3 border border-success border-start-0 border-end-0 border-bottom-0 rounded-0">
                        <h4 class="text-success fw-bold">2. Cotisez</h4>
                        <p class="mb-0">Cotisez via PayPal, Mobile Money, etc.</p>
                    </div>

                    <div class="faq-step p-4 mb-3 border border-success border-start-0 border-end-0 border-bottom-0 rounded-0">
                        <h4 class="text-success fw-bold">3. Gagnez votre récompense</h4>
                        <p class="mb-0">À la fin de la cotisation, vous obtenez le prix de votre choix.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-0">&copy; 2025 Company, Inc. All rights reserved.</p>
        </div>
    </footer>

    <script src="bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Js/message.js"></script>
    <script src="Js/index.js"></script>
    </body>

</html>