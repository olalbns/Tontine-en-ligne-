<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-5.3.3/dist/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../Css/Dash.css">
    <link rel="stylesheet" href="../font-awesome-6-pro-main/css/all.min.css">
    <title>Dashboard</title>
</head>

<body>
    <div class="spinner-zone"></div>
    <?php
    if (!isset($_COOKIE['User_id'])) {
        header("location: ../Connexion");
        exit();
    }
    ?>
    <section class="main">
        <div class="Hero-name row p-2">
            <div class="d-flex justify-content-between align-items-center w-100 colum row">
                <div class="d-flex justify-content-between align-items-center col-8 w-100-respo">
                    <div class="mt-1 col-4">
                        <h3 class="">TNTL</h3>
                    </div>
                    <div class="col-5">
                        <h2 class="n">Tableau de bord</h2>
                    </div>
                    <div onclick="respo()" id="dropdown" class="dropdow col-4">
                        <i class="fa-solid fa-navicon"></i>
                    </div>
                </div>


                <div id="profile" class=" profile col-3">
                    <a class="text-decoration-none d-flex profil--link" href="../Profile/">
                        <div class="profile-img">
                            <img src="" alt="Profile Picture" class="rounded-circle profile_img">
                        </div>&nbsp;
                        <div class="profile-name ">
                            <h6 class="text-white d-flex flex-wrap"><span class="profile_name">Undefined</span> <span
                                    class="profile_prenom">Undefined</span></h6>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;
                    </a>
                    <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Notification"
                        class="btn btn-light position-relative clear-notif-btn">
                        <i style="font-size: large;" class="fa-solid fa-bell text-green"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge" style="display: none;">0</span>
                    </button>
                </div>

            </div>

        </div>
        </div>
        <div class="dash-container row">
            <div id="sidebar" class="sidebar col-3 shadow">
                <div class="sidebars-links p-4 mt-3">
                    <a title="Tableau de bord" href="../Dashboard/"
                        class="side-link text-decoration-none acti-hov text-dark rounded-3">
                        <div class="side-item p-3 rounded-3 mb-2 acti"><i
                                class="fa-solid fa-user-circle mr-pc ft-2"></i><span class="nope">Tableau de bord</span>
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
                        <div class="side-item p-3 rounded-3 mb-2"><i class="fa-solid fa-award mr-pc ft-2"></i><span
                                class="nope">Récompense</span>
                        </div>
                    </a>
                    <a title="Cotiser" href="../Cotisation/"
                        class="side-link text-decoration-none text-dark acti-hov rounded-3">
                        <div class="side-item p-3 rounded-3 mb-2"><i
                                class="fa-solid fa-exchange-alt mr-pc ft-2"></i><span class="nope">Cotiser</span>
                        </div>
                    </a>
                    <a title="Méthodes de paiement" href="../MethodesDePaiement/"
                        class="side-link text-decoration-none text-dark acti-hov rounded-3">
                        <div class="side-item p-3 rounded-3 mb-2"><i
                                class="fa-solid fa-credit-card mr-pc ft-2"></i><span class="nope">Méthodes de
                                paiement</span>
                        </div>
                    </a>
                    <a title="Profile" href="../Profile/" class="side-link text-decoration-none text-dark rounded-3">
                        <div class="side-item p-3 mb-2 rounded-3"><i
                                class="fa-solid fa-user-circle mr-pc ft-2"></i><span class="nope">Mon
                                profil</span>
                        </div>
                    </a>
                    <hr>
                    <button title="Se déconnecter"
                        class="side-link text-decoration-none text-red red rounded-3 disconnect">
                        <div class="side-item p-3 rounded-3 mb-2"><i
                                class="fa-solid fa-sign-out-alt mr-pc ft-2"></i><span class="nope">Se
                                déconnecter</span> </div>
                    </button>
                </div>
            </div>
            <div id="fonction" class="fonction col-9">
                <div class="erreur-zone"></div>
                <div class="stats_container d-flex flex-column justify-content-center align-items-center">
                    <div class="alert alert-info">Aucune récompense pour le moment</div>
                </div>


                <div class="container kl6846">
                    <!-- <br class="bg-success"> -->
                    <hr>
                    <h4>Récompense choisie</h4> <br>
                    <div class="rec_choisie mb-3 d-flex justify-content-around align-items-center flex-wrap">
                        <div class="alert alert-success">Rien n'a été choisie pour le moment</div>
                    </div>
                    <hr>
                </div>

                <div class="history">
                    <h4>Historique de cotisation</h4> <br>
                    <table class="table table-hover table-sm p-5">
                        <thead>
                            <tr>
                                <th style="padding: 20px;" scope="col">ID</th>
                                <th style="padding: 20px;" scope="col">Date</th>
                                <th style="padding: 20px;" scope="col">Montant</th>
                                <th style="padding: 20px;" scope="col">Récompense</th>
                                <th style="padding: 20px;" scope="col">Methode de paiement</th>
                            </tr>
                        </thead>
                        <tbody class="tb_rec_dash">

                        </tbody>

                    </table>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div style="margin-top: 12%;" class="modal-content w-100">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Notification</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="notification-container">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>


    <script src="../bootstrap-5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="../js/script.js" defer></script>
    <script src="../js/profile.js"></script>
    <script src="../Js/message.js"></script>
    <script src="../Js/stats.js"></script>
    <script src="../Js/cotisation.js"></script>
</body>

</html>