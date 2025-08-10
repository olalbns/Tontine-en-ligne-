<?php
// session_start();
// if (!isset($_SESSION['admin'])) {
//     header('Location: ../login.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Tontine</title>
    <link rel="stylesheet" href="../../Public/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../Public/font-awesome-6-pro-main/css/all.min.css">
    <link rel="stylesheet" href="../Css/Dash.css">

</head>

<body>
    <!-- Navigation -->
    <nav style="top:0; z-index: 1000;" class="navbar position-sticky navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-coins me-2"></i>
                TNTLN Admin
            </a>
            <button class="navbar-toggler" type="button" id="sidebarToggle">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="ms-auto">
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-2"></i>
                        Admin
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar" id="sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#dashboard" onclick="showSection('dashboard')">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#users" onclick="showSection('users')">
                            <i class="fas fa-users"></i>
                            Utilisateurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cotisations" onclick="showSection('cotisations')">
                            <i class="fas fa-money-bill-wave"></i>
                            Cotisations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#recompenses" onclick="showSection('recompenses')">
                            <i class="fas fa-gift"></i>
                            Récompenses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#transactions" onclick="showSection('transactions')">
                            <i class="fas fa-exchange-alt"></i>
                            Transactions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reports" onclick="showSection('reports')">
                            <i class="fas fa-chart-bar"></i>
                            Rapports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#settings" onclick="showSection('settings')">
                            <i class="fas fa-cog"></i>
                            Paramètres
                        </a>
                    </li>
                </ul>
            </nav>
            
            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 main-content">
                <!-- Dashboard Section -->
                <div id="dashboard-section" class="content-section">
                    <div class="page-header">
                        <h1><i class="fas fa-tachometer-alt me-2"></i>Tableau de Bord</h1>
                        <p class="mb-0">Vue d'ensemble de la plateforme de tontine</p>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row stats_container">
                        <div class="alert alert-success">Chargement en cours <span class="spiner spiner-success"></span> </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <h5><i class="fas fa-bolt me-2"></i>Actions Rapides</h5>
                        <button class="btn btn-success" onclick="showSection('users')">
                            <i class="fas fa-user-plus me-2"></i>Nouvel Utilisateur
                        </button>
                        <button class="btn btn-primary" onclick="showSection('cotisations')">
                            <i class="fas fa-plus me-2"></i>Nouvelle Cotisation
                        </button>
                        <button class="btn btn-warning" onclick="showSection('recompenses')">
                            <i class="fas fa-gift me-2"></i>Ajouter Récompense
                        </button>
                        <button class="btn btn-info" onclick="showSection('reports')">
                            <i class="fas fa-download me-2"></i>Exporter Rapport
                        </button>
                    </div>

                    <!-- Recent Activities -->
                    <div class="row">
                        <div class="col-md">
                            <div class="table-card">
                                <h5><i class="fas fa-clock me-2"></i>Activités Récentes</h5>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Utilisateur</th>
                                                <th>Action</th>
                                                <th>Montant</th>
                                                <th>Date</th>
                                                <th>Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody class="activity-table">

                                        </tbody>
                                    </table>
                                </div>
                                <div id="pagination" style="margin-top: 10px;"></div>

                            </div>
                        </div>
                        <!-- <div class="col-md-4">
                            <div class="chart-card">
                                <h5><i class="fas fa-chart-pie me-2"></i>Répartition des Cotisations</h5>
                                <canvas id="cotisationChart" width="400" height="200"></canvas>
                            </div> -->
                    </div>
                </div>
        

        <!-- Users Section -->
        <div id="users-section" class="content-section" style="display: none;">
            <div class="page-header">
                <h1><i class="fas fa-users me-2"></i>Gestion des Utilisateurs</h1>
                <p class="mb-0">Gérez tous les utilisateurs de la plateforme</p>
            </div>

            <div class="table-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5><i class="fas fa-list me-2"></i>Liste des Utilisateurs</h5>
                    <button class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Nouvel Utilisateur
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom Complet</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Date d'inscription</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="users-table">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Other sections would be added similarly -->
        <div id="cotisations-section" class="content-section" style="display: none;">
            <div class="page-header">
                <h1><i class="fas fa-money-bill-wave me-2"></i>Gestion des Cotisations</h1>
                <p class="mb-0">Suivez et gérez toutes les cotisations</p>
            </div>
            <!-- Content for cotisations -->
        </div>

        <div id="recompenses-section" class="content-section" style="display: none;">
            <div class="page-header">
                <h1><i class="fas fa-gift me-2"></i>Gestion des Récompenses</h1>
                <p class="mb-0">Gérez les récompenses disponibles</p>
            </div>
            <!-- Content for recompenses -->
        </div>

        <div id="transactions-section" class="content-section" style="display: none;">
            <div class="page-header">
                <h1><i class="fas fa-exchange-alt me-2"></i>Transactions</h1>
                <p class="mb-0">Historique de toutes les transactions</p>
            </div>
            <!-- Content for transactions -->
        </div>

        <div id="reports-section" class="content-section" style="display: none;">
            <div class="page-header">
                <h1><i class="fas fa-chart-bar me-2"></i>Rapports</h1>
                <p class="mb-0">Analyses et statistiques détaillées</p>
            </div>
            <!-- Content for reports -->
        </div>

        <div id="settings-section" class="content-section" style="display: none;">
            <div class="page-header">
                <h1><i class="fas fa-cog me-2"></i>Paramètres</h1>
                <p class="mb-0">Configuration de la plateforme</p>
            </div>
            <!-- Content for settings -->
        </div>
        </main>
    </div>
    </div>

    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>

    <script src="../../Public/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navigation functionality
        function showSection(sectionName) {
            // Hide all sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.style.display = 'none';
            });

            // Show selected section
            document.getElementById(sectionName + '-section').style.display = 'block';

            // Update active nav link
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(link => {
                link.classList.remove('active');
            });
            event.target.classList.add('active');

            // Hide sidebar on mobile after selection
            if (window.innerWidth <= 768) {
                document.getElementById('sidebar').classList.remove('show');
                document.getElementById('overlay').style.display = 'none';
            }
        }

        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.toggle('show');
            if (sidebar.classList.contains('show')) {
                overlay.style.display = 'block';
            } else {
                overlay.style.display = 'none';
            }
        });

        // Close sidebar when clicking overlay
        document.getElementById('overlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('show');
            this.style.display = 'none';
        });

        // Chart.js for the pie chart (you can add Chart.js library)
        // This is a placeholder - you would need to include Chart.js library
        /*
        const ctx = document.getElementById('cotisationChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Mensuelles', 'Hebdomadaires', 'Journalières'],
                datasets: [{
                    data: [45, 35, 20],
                    backgroundColor: ['#28a745', '#007bff', '#ffc107']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
        */

        // Auto-update stats (example)
        function updateStats() {
            // You can fetch real data from your API here
            console.log('Updating statistics...');
        }

        // Update stats every 30 seconds
        setInterval(updateStats, 30000);

        // Initialize with dashboard view
        document.addEventListener('DOMContentLoaded', function() {
            showSection('dashboard');
        });
    </script>
    <script src="../js/stats.js"></script>
    <script src="../js/message.js"></script>
    <script src="../js/users.js"></script>
</body>

</html>