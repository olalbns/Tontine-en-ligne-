<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-5.3.3/dist/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../Css/Dash.css">
    <link rel="stylesheet" href="../font-awesome-6-pro-main/css/all.min.css">
    <title>Choisir/Modifier Recompense</title>
</head>
 <?php
    if (!isset($_COOKIE['User_id'])) {
        header("location: ../Connexion");
        exit();
    }
    ?>
<body>
    <div class="spinner-zone"></div>
    <div class="Hero-name row p-2">
        <div class="d-flex justify-content-between align-items-center w-100 colum">
            <div class="d-flex justify-content-between align-items-center w-70">
                <div class="mt-1">
                    <h3 class="">TNTL</h3>
                </div>
                <div class="">
                    <h2 class="n">Choisir/Modifier Recompense</h2>
                </div>
                <div id="dropdown" onclick="respo()" class="dropdow">
                    <i class="fa-solid fa-navicon"></i>
                </div>
            </div>


            <div id="profile" class=" profile">
                <a style="width: 55%;" class="text-decoration-none d-flex" href="../Profile/">
                    <div class="profile-img">
                        <img src="" alt="Profile Picture" class="rounded-circle profile_img">
                    </div>&nbsp;
                    <div class="profile-name">
                        <h6 class="text-white d-flex flex-wrap"><span class="profile_name">Undefined</span> <span
                                class="profile_prenom">Undefined</span></h6>
                    </div>&nbsp;&nbsp;&nbsp;&nbsp;
                </a>
                <div class="notif">
                    <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Notification"
                        class="btn btn-light position-relative clear-notif-btn">
                        <i style="font-size: large;" class="fa-solid fa-bell text-green"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge"
                            style="display: none;">3</span>
                    </button>
                </div>

            </div>

        </div>

    </div>
    <div class="dash-container row">
        <div id="sidebar" class="sidebar col-3 shadow">
            <div class="sidebars-links p-4 mt-1">
                <a title="Tableau de bord" href="../Dashboard/"
                    class="side-link text-decoration-none acti-hov text-dark rounded-3">
                    <div class="side-item p-3 rounded-3 mb-2"><i class="fa-solid fa-user-circle mr-pc ft-2"></i><span
                            class="nope">Tableau de bord</span>
                    </div>
                </a>
                <a title="Mes cotisations" href="../MesCotisations/"
                    class="side-link text-decoration-none text-dark acti-hov rounded-3">
                    <div class="side-item p-3 rounded-3 mb-2"><i class="fa-solid fa-wallet mr-pc ft-2"></i><span
                            class="nope">Mes
                            cotisations</span> </div>
                </a>
                <a title="Changer mode de cotisation" href="../ChangerModeCotisation/"
                    class="side-link text-decoration-none text-dark acti-hov rounded-3">
                    <div class="side-item p-3 rounded-3 mb-2"><i class="fa-solid fa-pen mr-pc ft-2"></i><span
                            class="nope">Mode
                            de cotisation</span> </div>
                </a>
                <a title="Choisir/Modifier récompense" href="../ChoisirModifierRecompense/"
                    class="side-link text-decoration-none text-dark acti-hov rounded-3">
                    <div class="side-item p-3 rounded-3 mb-2 acti"><i class="fa-solid fa-award mr-pc ft-2"></i><span
                            class="nope">Récompense</span>
                    </div>
                </a>
                <a title="Cotiser" href="../Cotisation/"
                    class="side-link text-decoration-none text-dark acti-hov rounded-3">
                    <div class="side-item p-3 rounded-3 mb-2"><i class="fa-solid fa-exchange-alt mr-pc ft-2"></i><span
                            class="nope">Cotiser</span>
                    </div>
                </a>
                <a title="Méthodes de paiement" href="../MethodesDePaiement/"
                    class="side-link text-decoration-none text-dark acti-hov rounded-3">
                    <div class="side-item p-3 rounded-3 mb-2"><i class="fa-solid fa-credit-card mr-pc ft-2"></i><span
                            class="nope">Méthodes de
                            paiement</span>
                    </div>
                </a>
                <a title="Profile" href="../Profile/"
                    class="side-link text-decoration-none acti-hov text-dark rounded-3">
                    <div class="side-item p-3 mb-2 rounded-3"><i class="fa-solid fa-user-circle mr-pc ft-2"></i><span
                            class="nope">Mon
                            profil</span>
                    </div>
                </a>
                <hr>
                <button title="Se déconnecter" href=""
                    class="side-link text-decoration-none text-red red rounded-3 disconnect">
                    <div class="side-item p-3 rounded-3 mb-2"><i class="fa-solid fa-sign-out-alt mr-pc ft-2"></i><span
                            class="nope">Se
                            déconnecter</span> </div>
                </button>
            </div>
        </div>
        <div id="fonction" class="fonction col-9 mt-2">
            <div class="container">
                <div class="erreur-zone position-absolute"></div>

                <div class="mod-cho-container shadow-sm rounded-3 bg-white w-100 p-3">
                    <div class="award-container">
                        <div class="d-flex justify-content-between">
                            <h4>Récompense choisie</h4>

                        </div> <br>
                        <div class="rec-modifiable d-flex flex-wrap justify-content-around">
                            <div class="alert alert-info">Aucune récompense Choisie</div>

                        </div>
                        <hr>
                        <h4>Choisir une récompense</h4>
                        <div class="car-container d-flex flex-wrap justify-content-around">
                            <div class="alert alert-info">Aucune récompense disponible</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div style="margin-top: 12%;" class="modal-content w-100">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Notifications</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="notification-container">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="ModRec" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="car-mod-container d-flex flex-wrap justify-content-around">
                        <div class="alert alert-info">Aucune récompense disponible</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!---Modal du module d'ajout-->
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



    <script src="../bootstrap-5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../Js/recompense.js" defer></script>
    <script src="../Js/message.js"></script>
    <script src="../js/profile.js"></script>
    <script src="../Js/moduleRec.js"></script>
</body>

</html>