<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Public/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/font-awesome-6-pro-main/css/all.min.css">
    <title>Connexion Administation</title>
</head>
<style>
    @media (max-width: 728px) {
        .container {
            width: 100% !important;
            margin-top: 20% !important;
        }
    }

    .container {
        margin-top: 10%;
    }
</style>

<body>
    <div class="erreur-zone"></div>
    <div class="container w-50 rounded shadow-sm p-4">
        <h1>Connexion Administration</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-success">Se connecter</button>
        </form>
    </div>
</body>
<script src="js/login.js"></script>
<script src="js/message.js"></script>
</html>