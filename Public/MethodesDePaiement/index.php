<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-5.3.3/dist/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../Css/Dash.css">
    <link rel="stylesheet" href="../font-awesome-6-pro-main/css/all.min.css">
    <title>Méthode de payement</title>
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
                    <h2 class="n">Methode de payement</h2>
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
        <div id="sidebar" class="sidebar col-3 shadow ">
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
                    <div class="side-item p-3 rounded-3 mb-2"><i class="fa-solid fa-exchange-alt mr-pc ft-2"></i><span
                            class="nope">Cotiser</span>
                    </div>
                </a>
                <a title="Méthodes de paiement" href="../MethodesDePaiement/"
                    class="side-link text-decoration-none text-dark acti-hov rounded-3">
                    <div class="side-item p-3 rounded-3 mb-2 acti"><i
                            class="fa-solid fa-credit-card mr-pc ft-2"></i><span class="nope">Méthodes de
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
                <div class="payement-container rounded shadow-sm bg-white p-3 d-flex row">
                    <div class="payement-form col">
                        <h4 class="mb-4">Ajouter methode de payement</h4>
                        <label class="mb-3" for="">Type de payement</label><br>
                        <select class="form-control" name="" id="selectPayemnt" required>
                            <option value="">Sélectionner le type de payement</option>
                            <option value="mobile_money">Mobile monnaie</option>
                            <option value="Carte_Bancaire">Carte bancaire</option>
                        </select>
                        <form id="formulaire" action="">
                            <div id="mobileMoney" class="mt-3" bis_skin_checked="1" hidden>
                                <div bis_skin_checked="1">
                                    <label class="mb-2">Numéro de téléphone</label>
                                    <input name="mobile_number" type="tel" class="form-control p-3 border rounded"
                                        placeholder="6XXXXXXXX" wfd-id="id2">
                                </div>
                                <div bis_skin_checked="1">
                                    <label class="block text-gray-700 mb-2">Nom</label>
                                    <input name="last_name" type="text" class="form-control p-3 border rounded-lg"
                                        placeholder="Votre nom" wfd-id="id3">
                                </div>
                                <div bis_skin_checked="1">
                                    <label class="block text-gray-700 mb-2">Prénom</label>
                                    <input name="first_name" type="text" class="form-control p-3 border rounded-lg"
                                        placeholder="Votre prénom" wfd-id="id4">
                                </div>
                            </div>
                            <div id="cardBancaire" class="mt-3" bis_skin_checked="1" hidden>
                                <div bis_skin_checked="1">
                                    <label class="block text-gray-700 mb-2">Numéro de carte</label>
                                    <input name="card_number" type="text" class="form-control p-3"
                                        placeholder="1234 5678 9012 3456" wfd-id="id5">
                                </div>
                                <div bis_skin_checked="1">
                                    <label class="block text-gray-700 mb-2">Nom du titulaire</label>
                                    <input name="card_holder" type="text" class="form-control p-3"
                                        placeholder="Comme sur la carte" wfd-id="id6">
                                </div>
                                <div class="row align-content-center" bis_skin_checked="1">
                                    <div class="col">
                                        <label class="block text-gray-700 mb-2">Date d'expiration</label>
                                        <input name="expiry_date" type="date" class="form-control p-3"
                                            placeholder="MM/AA" wfd-id="id7">
                                    </div>
                                    <div class="col">
                                        <label class="block text-gray-700 mb-2">CVV</label><br>
                                        <input name="cvv" type="text" class="form-control p-3" placeholder="123"
                                            wfd-id="id8">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success w-100 mt-3"><i class="fas fa-check"></i> Ajouter la
                                methode</button>
                        </form>
                    </div>
                    <div class="payement-save col">
                        <h4>Vos moyens enregistré</h4>
                        <div class="payemntdiv d-flex flex-row flex-wrap justify-content-between">

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

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deletePayementModal" tabindex="-1" aria-labelledby="deletePayementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePayementModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body" id="deleteModalBody">
                    <!-- Texte dynamique JS -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="confirmDeletePayement">Confirmer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap-5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/profile.js"></script>
    <script src="../Js/message.js"></script>
    <script src="../Js/payement.js"></script>
</body>

</html>