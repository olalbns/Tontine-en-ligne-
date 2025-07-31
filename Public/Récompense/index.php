<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../font-awesome-6-pro-main/css/all.min.css">
    <link rel="stylesheet" href="../Css/Dash.css">
    <link rel="stylesheet" href="../Css/style.css">
    <title>Récompense disponible</title>
</head>

<body>
    <?php
    if (isset($_COOKIE['User_id']) && !empty($_COOKIE['User_id'])) { ?>


        <div class="Hero-name row p-2">
            <div class="d-flex justify-content-between align-items-center w-100 colum row">
                <div class="d-flex justify-content-between align-items-center col-6 col-sm-12">
                    <div class="mt-1 col-4">
                        <h3 class="text-green ">TNTL</h3>
                    </div>
                    <div class="">
                        <h2 class="n col-4">Récompense</h2>
                    </div>
                    <div id="dropdown" onclick="respo()" class="dropdow col-4">
                        <i class="fa-solid fa-navicon"></i>
                    </div>
                </div>


                <div id="profile" class=" profile col-6">
                    <a class="text-decoration-none d-flex" style="margin-left: auto;" href="../Profile/">
                        <div class="profile-img">
                            <img src="" alt="Profile Picture"
                                class="rounded-circle profile_img">
                        </div>&nbsp;
                        <div class="profile-name">
                            <h6 class="text-green d-flex flex-wrap"><span class="profile_name">Undefined</span> <span
                                    class="profile_prenom">Undefined</span></h6>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;
                    </a>
                    <div class="notif">
                        <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Notification"
                            class="btn btn-light position-relative clear-notif-btn">
                            <i style="font-size: large;" class="fa-solid fa-bell text-green"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge" style="display: none;">3</span>
                        </button>
                    </div>

                </div>

            </div>

        </div>
    <?php } else { ?>
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
    <?php }
    ?>
    <div class="container-fluid fonction">
        <div class="erreur-zone"></div>
        <h1 class="mt-3">Récompense disponible</h1>
        <div class="container">
            <div class="mod-cho-container shadow-sm rounded-3 bg-white w-100 p-3">
                <div class="award-container">
                    <h4>Choisir une récompense</h4>
                    <div class="car-container d-flex flex-wrap justify-content-around">
                        <div class="alert alert-info">Aucune récompense disponible</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModulAjRec" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column p-3 rounded m-auto bg-white ">
                        <ul>
                            <form id="submit-module" action="">
                                <div class="choix">
                                    <li>
                                        <h4 class="lis mb-2">Récompense choisie</h4>
                                        <div class="Aj_rec_choisie d-flex flex-wrap">
                                            <div class="alert alert-info">Rien n'a été choisie pour le moment</div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="lis mb-2">Type de cotisation</h4>
                                        <div class="mb-3">
                                            <select class="form-select p-3" id="typeCotisation" required>
                                                <option>Choisir votre type de cotisation</option>
                                                <option value="journalier">Journalier</option>
                                                <option value="hebdomadaire">Hebdomadaire</option>
                                                <option value="mensuel">Mensuel</option>
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="lis">Montant à cotiser par période</h4>
                                        <div class="mb-3">
                                            <input type="number" class="form-control p-3" id="montantCotisation"
                                                placeholder="Entrez le montant" required>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="lis">Résumé</h4>
                                        <div class="mb-2">
                                            <label>Montant total à cotiser :</label>
                                            <span id="montantTotal">0</span> FCFA
                                        </div>
                                        <div class="mb-2">
                                            <label>Date limite :</label>
                                            <span id="dateLimite">--/--/----</span>
                                        </div>
                                    </li>
                                    <!-- <button type="submit" id="sub-btn" class="btn btn-success mt-4">Valider</button> -->

                                </div>
                    </div>

                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="sub-btn" class="btn btn-success">Valider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            localStorage.setItem("location_recompense", window.location)
        })
    </script>
    <script src="../bootstrap-5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="../bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/message.js"></script>
    <script src="../Js/recompense.js"></script>
    <script src="../Js/profile.js"></script>
    <script src="../Js/moduleRec.js"></script>
    <script src="..Js/script.js"></script>
</body>

</html>