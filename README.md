<h1 align="center">🚀 TNTL</h1>

<p align="center">
  <strong>Une plateforme de tontine en ligne avec choix de récompenses et interface administrateur.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/status-en%20cours-yellow?style=for-the-badge"/>
  <img src="https://img.shields.io/badge/version-1.0.0-blue?style=for-the-badge"/>
  <img src="https://img.shields.io/badge/licence-MIT-green?style=for-the-badge"/>
</p>

---

## 📸 Aperçu

<p align="center">
  <img src="./Capture d'écran 2026-03-19 060111.png" alt="Aperçu du projet" width="800"/>
</p>

---

## 📋 Description

Une plateforme qui permet aux utilisateurs de cotiser en ligne avec un choix de récompense à la fin de chaque tontine. Elle possède aussi une interface administrateur pour gérer les utilisateurs, les récompenses, etc.

Choisir une récompense dans le pack de récompenses (ex : mobiliers, argent, etc.), définir le montant et la cadence de cotisation.

---

## ✨ Fonctionnalités

**👤 Gestion des utilisateurs**

- ✅ Inscription / Connexion / Déconnexion
- ✅ Profil utilisateur (modifier infos, photo)
- ✅ Réinitialisation de mot de passe

**💰 Cotisation**

- ✅ Créer une campagne de cotisation
- ✅ Définir un montant cible et une date limite
- ✅ Payer sa cotisation en ligne
- ✅ Historique des paiements
- ✅ Suivi de la progression (barre de progression)
- ✅ Relance automatique des cotisants en retard

**🎁 Récompenses**

- ✅ Choisir une récompense selon le montant cotisé
- ✅ Affichage des récompenses disponibles avec description
- ✅ Confirmation de la récompense choisie
- ✅ Suivi du statut de livraison de la récompense

**📊 Tableau de bord**

- ✅ Vue globale des cotisations reçues
- ✅ Liste des cotisants et leurs récompenses
- ✅ Export des données (PDF / Excel)
- ✅ Statistiques visuelles (graphiques)

**🔔 Notifications**

- ✅ Notification après paiement
- ✅ Alerte quand l'objectif est atteint
- ✅ Rappel avant la date limite

**🛡️ Administration**

- ✅ Gérer les utilisateurs
- ✅ Gérer les récompenses (ajouter, modifier, supprimer)
- ✅ Tableau de bord administrateur

---

## 🛠️ Technologies utilisées

<p align="center">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white"/>
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white"/>
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black"/>
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white"/>
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white"/>
  <img src="https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white"/>
</p>

---

## ⚙️ Installation

```bash
# 1. Cloner le dépôt
git clone https://github.com/olalbns/Tontine-en-ligne-.git

# 2. Accéder au dossier
cd Tontine-en-ligne-

# 3. Installer les dépendances (si applicable)
composer install
```

---

## 🗄️ Base de données

```sql
-- Importer le fichier SQL fourni
-- dans phpMyAdmin ou via la commande :
mysql -u root -p nom_de_la_bdd < database.sql
```

---

## 🚀 Utilisation

```
1. Lance ton serveur local (XAMPP, Laragon, etc.)
2. Ouvre ton navigateur sur http://localhost/Tontine-en-ligne-
3. Connecte-toi avec les identifiants par défaut :
   - Email    : <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="5c3d383135321c39243d312c3039723f3331">[email&#160;protected]</a>
   - Password : admin123
```

---

## 📁 Structure du projet

```
Tontine-en-ligne-/
│
├── admin/                  # Interface d'administration
│
├── public/                 # Pages accessibles au public
│   ├── assets/
│   │   └── img/            # Images du site
│   └── [pages]/            # Dossiers par page du site
│
├── api/                    # Endpoints API
│
├── app/                    # Logique métier (config, fonctions, etc.)
│
├── vendor/                 # Dépendances (Composer)
│
├── index.php               # Point d'entrée principal
├── database.sql
└── README.md
```

---

## 👤 Auteur

**Ola lbn's**

<p>
  <a href="/cdn-cgi/l/email-protection#fd92919c919f938ebd9a909c9491d39e9290">
    <img src="https://img.shields.io/badge/Gmail-D14836?style=for-the-badge&logo=gmail&logoColor=white"/>
  </a>
  <a href="https://linkedin.com/in/emmanuel-labintan-8457272a0">
    <img src="https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white"/>
  </a>
  <a href="https://x.com/ola_lbn">
    <img src="https://img.shields.io/badge/Twitter-1DA1F2?style=for-the-badge&logo=twitter&logoColor=white"/>
  </a>
  <a href="https://github.com/olalbns">
    <img src="https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white"/>
  </a>
</p>

---

## 📄 Licence

Ce projet est sous licence **MIT** — l
