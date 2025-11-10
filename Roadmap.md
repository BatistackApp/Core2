
# Roadmap Batistack ERP

Cette roadmap présente la vision et la planification du développement de **Batistack**, un ERP moderne destiné aux entreprises du secteur du BTP.

## Légende

- ✅ **Réalisé** : Fonctionnalité développée et en production
- 🚧 **En cours** : Actuellement en développement
- 📋 **Planifié** : Prévu dans les prochaines itérations
- 💡 **En réflexion** : À l'étude, pas encore planifié

---

## Diagramme de Gantt
gantt
    title Roadmap Détaillée - Batistack ERP
    dateFormat  YYYY-MM-DD

    %% Marqueur pour la date actuelle (11 Nov 2025)
    todayMarker stroke-width:3px,stroke:#E040FB,opacity:0.6
    
    %% --- Phase 1: Terminée ---
    section Phase 1 - Core (Terminé)
    Core Applicatif & Infra       :done, core, 2025-01-01, 2025-10-31

    %% --- Phase 2: En cours (détaillée) ---
    section Phase 2 - Modules Fondamentaux (En cours)
    %% Module Tiers (Oct-Déc 2025)
    Tiers: CRUD Clients/Fourn.     :done,    t1, 2025-10-01, 30d
    Tiers: Contacts & Historique  :active,  t2, after t1, 40d
    Tiers: Segmentation & I/O     :         t3, 2025-12-01, 30d
    
    %% Module Articles (Oct 2025 - Jan 2026)
    Articles: Catalogue & Unités  :done,    a1, 2025-10-15, 30d
    Articles: Classification      :active,  a2, after a1, 30d
    Articles: Stocks de base      :         a3, 2025-12-01, 30d
    Articles: Tarifs & Codes      :         a4, 2026-01-01, 30d

    %% Module Commerces (Nov 2025 - Fév 2026)
    Commerces: Devis               :active,  c1, 2025-11-01, 30d
    Commerces: Commandes Clients  :         c2, 2025-12-01, 30d
    Commerces: Suivi Livraisons   :         c3, 2026-01-01, 30d
    Commerces: Retours & Templates :         c4, 2026-02-01, 28d

    %% --- Phase 3: Planifiée (détaillée

## Phase 1 : Fondations du Core (Jan-Oct 2025) ✅

### Core - Cœur Applicatif
- ✅ Configuration Laravel 12 avec Livewire 3 et FilamentPHP 4
- ✅ Architecture modulaire avec système d'activation de modules
- ✅ Gestion des utilisateurs et des rôles
- ✅ Système de permissions granulaires
- ✅ Authentification et sécurité (Laravel Sanctum)
- ✅ Interface d'administration FilamentPHP
- ✅ Configuration multi-tenant
- ✅ Internationalisation (i18n)

### Infrastructure
- ✅ Configuration Vite.js pour les assets
- ✅ Tests automatisés (Pest/PHPUnit)
- ✅ Intégration continue (CI/CD)
- ✅ Documentation technique de base

---

## Phase 2 : Modules Métiers Fondamentaux (Nov 2025 - Fév 2026) 🚧

### Module Tiers
- ✅ CRUD complet pour les clients
- ✅ CRUD complet pour les fournisseurs
- 🚧 Gestion des contacts multiples par tiers
- 🚧 Historique des interactions
- 📋 Segmentation et catégorisation avancée (Déc 2025)
- 📋 Import/Export CSV (Déc 2025)

### Module Articles
- ✅ Catalogue de produits et services
- 🚧 Gestion des unités de mesure
- 🚧 Classification par catégories
- 📋 Gestion des stocks de base (Déc 2025)
- 📋 Tarification multi-niveaux (Jan 2026)
- 📋 Codes-barres et QR codes (Jan 2026)

### Module Commerces
- 🚧 Création et gestion des devis
- 🚧 Transformation devis → commande
- 📋 Gestion des commandes clients (Déc 2025)
- 📋 Suivi des livraisons (Jan 2026)
- 📋 Gestion des retours (Fév 2026)
- 📋 Templates de documents personnalisables (Fév 2026)

---

## Phase 3 : Gestion Financière (Fév-Juin 2026) 📋

### Module Facturations & Paiements
- 📋 Création de factures depuis commandes (Fév 2026)
- 📋 Facturation récurrente (Mars 2026)
- 📋 Acomptes et avoirs (Mars 2026)
- 📋 Suivi des paiements et encaissements (Avr 2026)
- 📋 Relances automatiques (Avr 2026)
- 📋 Intégration moyens de paiement (Stripe, PayPal) (Avr 2026)
- 📋 Génération de PDF personnalisés (Avr 2026)

### Module Banques & Caisses
- 📋 Gestion multi-comptes bancaires (Mars 2026)
- 📋 Suivi des flux de trésorerie (Avr 2026)
- 📋 Rapprochement bancaire manuel (Avr 2026)
- 📋 Import des relevés bancaires (OFX, CSV) (Mai 2026)
- 💡 Rapprochement bancaire automatique (Mai 2026)
- 💡 Prévisions de trésorerie (Mai 2026)

### Module Comptabilité
- 📋 Plan comptable personnalisable (Avr 2026)
- 📋 Saisie d'écritures comptables (Mai 2026)
- 📋 Journaux comptables (ventes, achats, banque, OD) (Mai 2026)
- 📋 Grand livre et balance (Juin 2026)
- 📋 Compte de résultat (Juin 2026)
- 📋 Bilan comptable (Juin 2026)
- 📋 Clôture d'exercice (Juin 2026)
- 💡 Export FEC (Fichier des Écritures Comptables) (Juin 2026)

---

## Phase 4 : Gestion de Projets BTP (Juin-Oct 2026) 📋

### Module Chantiers
- 📋 Création et suivi de chantiers (Juin 2026)
- 📋 Diagramme de Gantt interactif (Juil 2026)
- 📋 Suivi des coûts en temps réel (Juil 2026)
- 📋 Gestion des phases de travaux (Août 2026)
- 📋 Allocation des ressources (humaines et matérielles) (Août 2026)
- 📋 Tableau de bord d'avancement (Sept 2026)
- 📋 Photos et rapports de chantier (Sept 2026)
- 💡 Alertes de dépassement budgétaire (Oct 2026)
- 💡 Intégration avec module Plannings (Oct 2026)

### Module Plannings
- 📋 Planification des équipes (Juil 2026)
- 📋 Calendrier partagé (Août 2026)
- 📋 Affectation des ressources aux tâches (Août 2026)
- 📋 Vue Kanban des tâches (Sept 2026)
- 📋 Gestion des congés et absences (Oct 2026)
- 💡 Optimisation automatique des plannings (Oct 2026)
- 💡 Application mobile pour les équipes terrain (Oct 2026)

---

## Phase 5 : Ressources Humaines et Paie (Oct 2026 - Fév 2027) 📋

### Module GHR (Gestion des Ressources Humaines)
- 📋 Fiches employés complètes (Oct 2026)
- 📋 Gestion des contrats de travail (Nov 2026)
- 📋 Suivi des qualifications et formations (Nov 2026)
- 📋 Gestion des congés et RTT (Déc 2026)
- 📋 Évaluations de performance (Déc 2026)
- 📋 Documents RH (certificats, attestations) (Jan 2027)
- 💡 Onboarding digital des nouveaux employés (Jan 2027)
- 💡 Portail employé self-service (Fév 2027)

### Module Paie
- 📋 Génération des bulletins de paie (Nov 2026)
- 📋 Calcul automatique des charges sociales (Déc 2026)
- 📋 DSN (Déclaration Sociale Nominative) (Déc 2026)
- 📋 Gestion des primes et avantages (Jan 2027)
- 📋 Historique et archivage des bulletins (Jan 2027)
- 💡 Conformité légale automatique (Fév 2027)
- 💡 Simulation de paie (Fév 2027)

### Module Note de Frais
- 📋 Soumission de notes de frais par les employés (Déc 2026)
- 📋 Workflow de validation (Jan 2027)
- 📋 Scan et OCR des justificatifs (Jan 2027)
- 📋 Calcul automatique des remboursements (Fév 2027)
- 📋 Export comptable (Fév 2027)
- 💡 Application mobile dédiée (Fév 2027)

---

## Phase 6 : Modules Avancés (Fév-Juil 2027) 📋

### Module GPAO (Gestion de Production)
- 📋 Gestion des lignes de fabrication (Fév 2027)
- 📋 Ordres de fabrication (Mars 2027)
- 📋 Suivi de la production en temps réel (Mars 2027)
- 📋 Gestion des nomenclatures (BOM) (Avr 2027)
- 📋 Calcul des coûts de production (Avr 2027)
- 💡 Optimisation des processus de fabrication (Avr 2027)

### Module GED (Gestion Électronique de Documents)
- 📋 Référentiel documentaire centralisé (Mars 2027)
- 📋 Classification et indexation (Avr 2027)
- 📋 Versionnement des documents (Avr 2027)
- 📋 Moteur de recherche avancé (Mai 2027)
- 📋 Droits d'accès granulaires (Mai 2027)
- 📋 Archivage à long terme (Mai 2027)
- 💡 OCR et extraction automatique de métadonnées (Juin 2027)
- 💡 Workflow de validation documentaire (Juin 2027)

### Module Signature Électronique
- 📋 Signature électronique simple (Mars 2027)
- 📋 Signature qualifiée (eIDAS) (Avr 2027)
- 📋 Workflow de signature multi-parties (Mai 2027)
- 📋 Traçabilité et certificats de signature (Mai 2027)
- 📋 Intégration avec GED (Juin 2027)
- 💡 Signature biométrique sur tablette (Juin 2027)
- 💡 Vérification d'identité avancée (Juin 2027)

### Module Flottes
- 📋 Gestion du parc de véhicules (Avr 2027)
- 📋 Suivi kilométrage et horodatage (Mai 2027)
- 📋 Planification de la maintenance (Mai 2027)
- 📋 Gestion des assurances et contrôles techniques (Juin 2027)
- 📋 Carnet d'entretien digital (Juin 2027)
- 💡 Géolocalisation GPS en temps réel (Juin 2027)
- 💡 Alertes de maintenance préventive (Juin 2027)

### Module Locations
- 📋 Gestion des contrats de location (matériel/services) (Mai 2027)
- 📋 Suivi des disponibilités (Juin 2027)
- 📋 Facturation automatique des locations (Juin 2027)
- 📋 Gestion des retours et états des lieux (Juil 2027)
- 💡 Calendrier de disponibilité en temps réel (Juil 2027)
- 💡 Intégration avec module Chantiers (Juil 2027)

---

## Phase 7 : Technologies Innovantes (Juil-Oct 2027) 💡

### Module 3D Vision
- 💡 Visualisation 3D des chantiers (Juil 2027)
- 💡 Intégration de maquettes BIM (Août 2027)
- 💡 Suivi de l'avancement en 3D (Août 2027)
- 💡 Annotations et mesures sur modèles 3D (Sept 2027)
- 💡 Réalité augmentée pour le terrain (Sept 2027)
- 💡 Détection automatique des écarts (prévu vs réalisé) (Oct 2027)

---

## Phase 8 : Options Premium et Intégrations (Sept-Déc 2027) 💡

### Option Agrégation Bancaire (Bankin API)
- 📋 Connexion sécurisée aux banques (Sept 2027)
- 📋 Récupération automatique des transactions (Oct 2027)
- 📋 Catégorisation intelligente (Oct 2027)
- 📋 Vue consolidée multi-comptes (Nov 2027)
- 💡 Prévisions basées sur l'IA (Déc 2027)
- 💡 Alertes de trésorerie proactives (Déc 2027)

### Pack Signature
- 📋 Packs d'unités de signature (Oct 2027)
- 📋 Gestion des quotas (Oct 2027)
- 📋 Reporting d'utilisation (Nov 2027)
- 💡 Tarification dynamique (Déc 2027)

### Sauvegarde et Rétention
- 📋 Sauvegardes automatiques programmables (Oct 2027)
- 📋 Restauration à chaud (Nov 2027)
- 📋 Rétention personnalisée (90j, 1an, 5ans, etc.) (Nov 2027)
- 📋 Backups géolocalisés (Déc 2027)
- 💡 Tests de restauration automatiques (Déc 2027)
- 💡 Conformité RGPD et archivage légal (Déc 2027)

### Extension Stockage
- 📋 Stockage cloud extensible (Nov 2027)
- 📋 Archivage de documents volumineux (Nov 2027)
- 📋 CDN pour l'accès rapide (Déc 2027)
- 💡 Compression intelligente (Déc 2027)
- 💡 Déduplication des fichiers (Déc 2027)

---

## Axes Transverses (Continu)

### Performance et Scalabilité
- 🚧 Optimisation des requêtes base de données (En cours)
- 📋 Mise en cache intelligente (Redis) (Déc 2025)
- 📋 CDN pour les assets statiques (Jan 2026)
- 📋 Architecture microservices pour modules critiques (2027)
- 📋 Queues asynchrones pour traitements lourds (2027)

### Sécurité
- ✅ HTTPS obligatoire
- ✅ Protection CSRF
- 🚧 Audit logs complets (En cours)
- 📋 Chiffrement des données sensibles (Déc 2025)
- 📋 2FA (Authentification à deux facteurs) (Jan 2026)
- 📋 Conformité RGPD (2026)
- 💡 Pentests réguliers (À partir de 2027)
- 💡 Bug bounty program (2027)

### UX/UI
- ✅ Interface responsive (mobile-first)
- 🚧 Dark mode (En cours)
- 📋 Personnalisation des tableaux de bord (Jan 2026)
- 📋 Widgets configurables (2026)
- 📋 Notifications en temps réel (2026)
- 💡 Assistant IA pour la navigation (2027)
- 💡 Commandes vocales (2027)

### Intégrations
- 📋 API REST complète et documentée (Jan 2026)
- 📋 Webhooks configurables (2026)
- 📋 Intégration avec Google Workspace (2026)
- 📋 Intégration avec Microsoft 365 (2026)
- 💡 Marketplace de plugins tiers (2027)
- 💡 Zapier/Make.com pour automatisations (2027)

### Intelligence Artificielle
- 💡 Prédictions de trésorerie (2027)
- 💡 Détection d'anomalies comptables (2027)
- 💡 Recommandations de planification (2027)
- 💡 Chatbot assistant pour support utilisateur (2027)
- 💡 OCR avancé pour extraction de données (2027)
- 💡 Analyse prédictive des délais de chantiers (2027)

---

## Vue d'ensemble des Phases

| Phase | Période | Durée | Statut |
|-------|---------|-------|--------|
| Phase 1 - Core | Jan-Oct 2025 | 10 mois | ✅ Terminé |
| Phase 2 - Modules Fondamentaux | Nov 2025 - Fév 2026 | 4 mois | 🚧 En cours |
| Phase 3 - Gestion Financière | Fév-Juin 2026 | 5 mois | 📋 Planifié |
| Phase 4 - Projets BTP | Juin-Oct 2026 | 5 mois | 📋 Planifié |
| Phase 5 - RH & Paie | Oct 2026 - Fév 2027 | 5 mois | 📋 Planifié |
| Phase 6 - Modules Avancés | Fév-Juil 2027 | 6 mois | 📋 Planifié |
| Phase 7 - Innovation | Juil-Oct 2027 | 4 mois | 💡 En réflexion |
| Phase 8 - Options Premium | Sept-Déc 2027 | 4 mois | 💡 En réflexion |

**Durée totale du projet :** 24 mois (2 ans) - De novembre 2025 à décembre 2027

---

## Jalons Clés (Milestones)

- **📍 Nov 2025** : Lancement Phase 2 - Premiers modules métiers
- **📍 Fév 2026** : Démarrage modules financiers (crucial pour facturation)
- **📍 Juin 2026** : Lancement modules spécifiques BTP (Chantiers)
- **📍 Oct 2026** : Début modules RH & Paie
- **📍 Fév 2027** : Lancement modules avancés (GPAO, GED)
- **📍 Juil 2027** : Début phase innovation (3D Vision)
- **📍 Déc 2027** : Release finale avec toutes les options premium

---

## Contribution et Évolution

Cette roadmap est un document vivant qui évolue en fonction :
- Des retours utilisateurs
- Des tendances du marché BTP
- Des évolutions technologiques
- Des exigences réglementaires

Pour proposer une amélioration ou une nouvelle fonctionnalité, consultez le fichier [CONTRIBUTING.md](CONTRIBUTING.md).

---

**Dernière mise à jour :** 11 novembre 2025  
**Version :** 2.0.0  
**Durée totale estimée :** 24 mois (Nov 2025 - Déc 2027)
