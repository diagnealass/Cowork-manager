Coworking Management System – Laravel

Un projet Laravel complet permettant de gérer un espace de coworking : réservations, salles, utilisateurs, abonnements, facturation, gestion des ressources, etc.
Ce projet a été pensé comme une application professionnelle avec une architecture propre, une base solide (ERD), et une structure évolutive pour en faire un futur SaaS.

🚀 Fonctionnalités principales

🧑‍💼 Gestion des utilisateurs

Création, modification, suppression

Rôles (Admin / Manager / Client)

Authentification Laravel Breeze / Jetstream (selon installation)

🏢 Gestion des salles de coworking

Types de salles (privée, open-space, salle de réunion…)

Capacité, équipements, disponibilité

📅 Réservations

Réserver une salle sur une plage horaire

Empêcher les conflits de réservation

Historique des réservations

💳 Abonnements / Tarification

Packs mensuels, journaliers ou à l’heure

Paiements (selon intégration future Stripe/PayTech)

📊 Dashboard administrateur

Vue globale : statistiques, revenu, taux d’occupation

Gestion des ressources et équipements

⚙️ Architecture claire

Modèles Laravel + Relations Eloquent

Migrations + Seeders

Services / Repositories (si utilisés)

ERD défini dans le dossier /docs/

🗂️ Structure du projet
├── app/
│   ├── Models/
│   ├── Http/Controllers/
│   ├── Services/
├── database/
│   ├── migrations/
│   ├── seeders/
├── resources/
│   ├── views/
│   ├── components/
├── public/
├── routes/
│   └── web.php
└── docs/
    └── ERD_coworking.pdf

🔧 Installation & Configuration
 Cloner le projet
git clone https://github.com/diagnealass/Cowork-manager.git
cd Cowork-manager


🔌 Relations Eloquent utilisées

Le système utilise les relations suivantes :

🔹 User → Reservations

Un utilisateur peut effectuer plusieurs réservations.

public function reservations() {
    return $this->hasMany(Reservation::class);
}

🔹 Room → Reservations

Une salle peut être réservée plusieurs fois.

public function reservations() {
    return $this->hasMany(Reservation::class);
}

🔹 Plan (Abonnement) ↔ Users

Un utilisateur peut avoir un abonnement.

public function plan() {
    return $this->belongsTo(Plan::class);
}

🔹 Many-to-Many (si équipements de salle)

Room ↔ Equipment

🎨 Interface & Design

Le projet utilise :

TailwindCSS

Blade Components

Layouts centralisés (layouts/app.blade.php)

Un footer incluant :

<p class="text-center text-gray-500 text-sm">© {{ date('Y') }} Coworking Manager – Tous droits réservés.</p>

👥 Participation / Contribution

Les contributions sont les bienvenues :

📜 Licence

Libre d’utilisation pour l’apprentissage et les projets personnels.

👍 Auteur

Alassane DIAGNE
Étudiant en Informatique – UIDT
Développeur Web & Mobile en progression
📧 diagnealass03@gmail.com
