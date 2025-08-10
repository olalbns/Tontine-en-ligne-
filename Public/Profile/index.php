<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../font-awesome-6-pro-main/css/all.min.css">
    <link rel="stylesheet" href="../Css/Dash.css">
    <title>Profile</title>
</head>
 <?php
    if (!isset($_COOKIE['User_id'])) {
        header("location: ../Connexion");
        exit();
    }
    ?>
<body>
    <div class="spinner-zone"></div>

    <section class="main">
        <div class="Hero-name row p-2">
            <div class="d-flex justify-content-between align-items-center w-100 colum">
                <div class="d-flex justify-content-between align-items-center w-70">
                    <div class="mt-1">
                        <h3 class=" ">TNTL</h3>
                    </div>
                    <div class="">
                        <h2 class="n">Profile</h2>
                    </div>
                    <div id="dropdown" onclick="respo()" class="dropdow">
                        <i class="fa-solid fa-navicon"></i>
                    </div>
                </div>


                <div id="profile" class=" profile">
                    <a style="width: 55%;" class="text-decoration-none d-flex" href="../Profile/">
                        <div class="profile-img">
                            <img src="" alt="Profile Picture"
                                class="rounded-circle profile_img">
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
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge" style="display: none;">3</span>
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
                        <div class="side-item p-3 rounded-3 mb-2 "><i
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
                    <a title="Cotisation" href="../Cotisation/"
                        class="side-link text-decoration-none text-dark acti-hov rounded-3">
                        <div class="side-item p-3 rounded-3 mb-2"><i
                                class="fa-solid fa-exchange-alt mr-pc ft-2"></i><span class="nope">Cotisation</span>
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
                        <div class="side-item p-3 mb-2 rounded-3 acti"><i
                                class="fa-solid fa-user-circle mr-pc ft-2"></i><span class="nope">Mon
                                profil</span>
                        </div>
                    </a>
                    <hr>
                    <button title="Se déconnecter" class="side-link text-decoration-none text-red red rounded-3 disconnect">
                        <div class="side-item p-3 rounded-3 mb-2"><i
                                class="fa-solid fa-sign-out-alt mr-pc ft-2"></i><span class="nope">Se
                                déconnecter</span> </div>
                    </button>
                </div>
            </div>

            <div id="fonction" class="fonction col-9">
                <div class="erreur-zone"></div>
                <div class="container">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <div class="p-img">
                            <div class="position-relative"><img style="max-height: 200px ;" class="rounded-circle img-fluid profile_img" id="img-edit" width="200" height="200"
                                    src="" alt=""><button id="edit-profile-img"
                                    class="position-absolute bottom-0 start-75 translate-middle badge rounded-sm bg-dark text-light p-2"><i
                                        class="fa fa-pencil"></i></button></div>
                            <input type="file" id="profile-img-input" class="d-none">
                        </div>
                        <br>
                        <div class="p-info w-70">
                            <form id="UpdateProfile" action="" class="p-4 bg-white rounded shadow-sm">
                                <table class="table table-hover mt-3 w-100 rounded-5">
                                    <tr>
                                        <th class="p-2 align-content-center"><span> Nom</span></th>
                                        <td><input value="Undefined Undefined"
                                                class="profile_allName form-control w-100 d-inline p-2 ipt-bd"
                                                type="text" name="full_name" id=""></td>
                                    </tr>
                                    <tr>
                                        <th class="p-2 align-content-center"><span>Email</span></th>
                                        <td class="p-2"><input name="email" value="undefined@example.com"
                                                class="profile_email form-control d-inline w-100 ipt-bd" type="email"
                                                required></td>
                                    </tr>
                                    <tr>
                                        <th class="p-2 align-content-center"><span>Téléphone</span></th>
                                        <td class="p-2"><input value="+123456789"
                                                class="profile_tel form-control d-inline w-100 ipt-bd" type="number"
                                                name="phone_number" id="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="p-2 align-content-center "><span>Montant cotisé</span> </th>
                                        <td class="p-2"><input name="amount" readonly
                                                class="profile_balanc form-control d-inline w-100 ipt-bd" type="text">
                                        </td>
                                    </tr>
                                    <input name="id_uti" class="profile_id" type="text" hidden>
                                </table>
                                <div class="btn-co">
                                    <button class="btn btn-success" type="submit">Enregistrer les modifications</button>
                                </div>
                            </form><br>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

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
    <script src="../bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/profile.js"></script>
    <script src="../js/message.js"></script>

</body>

</html>