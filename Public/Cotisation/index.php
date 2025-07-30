<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-5.3.3/dist/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../Css/Dash.css">
    <link rel="stylesheet" href="../font-awesome-6-pro-main/css/all.min.css">
    <title>Cotiser</title>
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
                    <h3 class="text-green ">TNTL</h3>
                </div>
                <div class="">
                    <h2 class="n">Cotiser</h2>
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
                        <h6 class="text-green d-flex flex-wrap"><span class="profile_name">Undefined</span> <span
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
                    <div class="side-item p-3 rounded-3 mb-2"><i class="fa-solid fa-award mr-pc ft-2"></i><span
                            class="nope">Récompense</span>
                    </div>
                </a>
                <a title="Cotiser" href="../Cotisation/"
                    class="side-link text-decoration-none text-dark acti-hov rounded-3">
                    <div class="side-item p-3 rounded-3 mb-2 acti"><i
                            class="fa-solid fa-exchange-alt mr-pc ft-2"></i><span class="nope">Cotiser</span>
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
                <button title="Se déconnecter" class="side-link text-decoration-none text-red red rounded-3 disconnect">
                    <div class="side-item p-3 rounded-3 mb-2"><i class="fa-solid fa-sign-out-alt mr-pc ft-2"></i><span
                            class="nope">Se
                            déconnecter</span> </div>
                </button>
            </div>
        </div>
        <div id="fonction" class="fonction col-9 mt-2">
            <div class="erreur-zone position-absolute"></div>

            <div class="container">
                <div class="Cotiser-container bg-white p-3 shadow-sm rounded-3 w-100">
                    <h4 class="mb-4">Récompense a cotiser</h4>
                    <div class="container rec_a_cotiser d-flex flex-row justify-content-around flex-wrap">

                    </div>
                    <label for="">
                        <h4 class="mb-4">Methode de payement</h4>
                    </label>
                    <div class="payemntdiv d-flex justify-content-around container flex-wrap mb-3">
                        <div class="d-flex flex-column-reverse p-4 rounded-4 shadow-sm w-auto mb-3">
                            <button class="btn btn-success"> <input type="radio" name="methode" value="carte_bancaire">
                                Selectionné </button>
                            <div class="d-flex flex-column align-items-center">
                                <i style="width: 38%; background-color: rgba(0, 0, 255, 0.589);"
                                    class="far fa-credit-card p-3 rounded-pill  text-white"></i>
                                <h5>Carte bancaire</h5>
                                <span>Jonh Doe</span>
                                <span>541181...</span>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded-4 flex-column-reverse shadow-sm w-auto mb-3">
                            <button class="btn btn-success"> <input type="radio" name="methode" value="mobile_money">
                                Selectionné </button>
                            <div class="d-flex flex-column align-items-center">
                                <i style="width: 38%; background-color: rgba(255, 166, 0, 0.589); color: black;"
                                    class="fas fa-mobile-alt p-3 rounded-pill "></i>
                                <h5>Mobile money</h5>
                                <span>Jonh Doe</span>
                                <span>541181...</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-3">Montant a payer</h4>
                        <form style="padding: 0;" class="container d-flex flex-column align-items-center" action="">
                            <label style="width: 50%;" class="text-left mb-2" for="">Montant a payer</label>
                            <div style="width: 50%;" class="input-group mb-3 p-3">
                                <span class="input-group-text" id="basic-addon1">XOF</span>
                                <input style="min-width: 100px; padding: 0 !important;" type="number"
                                    class="form-control p-3" placeholder="Ex: 5000" aria-describedby="basic-addon1"
                                    readonly required>
                            </div>
                        </form>
                    </div>
                    <button class="btn btn-success p-2 mt-4 confirmBtn"><i class="fas fa-paper-plane"></i> Confirmé le
                        payement</button>
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
    <script src="../bootstrap-5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/profile.js"></script>
    <script src="../Js/message.js"></script>
    <script src="../Js/cotisation.js"></script>
</body>

</html>