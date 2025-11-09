# Batistack ERP

Batistack est un logiciel ERP (Enterprise Resource Planning) complet et moderne, spécialement conçu pour répondre aux besoins de gestion et de comptabilité des entreprises du secteur du BTP (Bâtiment et Travaux Publics).

Développé avec **Laravel 12**, **Livewire 3** et **FilamentPHP 4**, il offre une solution flexible et évolutive grâce à son architecture modulaire. Les fonctionnalités peuvent être activées ou désactivées en fonction de la formule souscrite par le client, garantissant ainsi une solution sur mesure.

## Stack Technique

*   **Framework Backend:** Laravel 12
*   **Framework Frontend/UI:** Livewire 3 & Alpine.js
*   **Panel d'administration:** FilamentPHP 4
*   **Base de données:** MySQL (par défaut)
*   **Serveur de développement:** Vite.js

## Modules Principaux

Batistack est composé d'un cœur applicatif sur lequel viennent se greffer des modules métiers spécialisés.

### **Core** (Cœur Principal)
Centralisation applicative, gestion des utilisateurs, des droits et fonctions de base du système.

### **Tiers**
Permet de gérer l'annuaire général du logiciel (clients, fournisseurs, contacts, etc.).

### **GPAO**
Permet de gérer vos lignes de fabrications.

### **Signature**
Solution avancée de gestion de la signature électronique pour dématérialiser et sécuriser les processus de validation et d'approbation de documents.

### **Chantiers**
Pilotez efficacement tous vos projets de construction : planification (Gantt), suivi des coûts en temps réel, gestion des ressources et avancement des travaux.

### **Articles**
Organisez et suivez tous les produits (matériaux, équipements) et services (main d'œuvre, prestations) que votre entreprise utilise ou propose.

### **Commerces**
Gérez toutes les étapes de vente, de la création des devis à leur transformation en commandes, jusqu'au suivi des livraisons.

### **Facturations & Paiements**
Créez facilement des factures, suivez les paiements de vos clients et gérez les relances pour assurer un bon suivi de vos encaissements.

### **Banques & Caisses**
Simplifiez et automatisez la gestion de votre trésorerie, suivez les flux financiers en temps réel et facilitez le rapprochement bancaire.

### **Comptabilité**
Gérez l'ensemble des opérations comptables, de la saisie des écritures à la génération des bilans et comptes de résultat.

### **GHR (Ressources Humaines)**
Centralisez toutes les informations relatives aux employés et simplifiez les processus administratifs liés aux RH.

### **Paie**
Automatisez et simplifiez la gestion de la paie des employés, en assurant la conformité avec la législation en vigueur.

### **Plannings**
Optimisez l'organisation et la gestion des activités, des ressources et des équipes au sein de l'entreprise.

### **GED (Gestion Électronique de Documents)**
Centralisez, organisez et sécurisez tous les documents numériques de l'entreprise pour faciliter l'accès à l'information.

### **3D Vision**
Intégrez des capacités de visualisation et de modélisation 3D pour manipuler et analyser des données spatiales ou des représentations d'objets.

### **Flottes**
Gérez le parc de véhicules de l'entreprise : horodatage, kilométrage et maintenance.

### **Locations**
Suivez les contrats de locations de matériel ou de services de l'entreprise.

### **Note de Frais**
Permet aux salariés de soumettre leurs notes de frais et de suivre leur remboursement en temps réel.

## Options Supplémentaires

Des options additionnelles peuvent être activées pour étendre les capacités de Batistack.

### **Aggrégation bancaire**
Grâce au partenariat avec **Bankin API**, ce module centralise et automatise la récupération des flux bancaires pour une vision consolidée de la trésorerie.

### **Pack Signature**
En complément du module Signature, cette option propose des packs d'unités de signature électronique pour la validation de documents.

### **Sauvegarde et rétention**
Définissez des intervalles de sauvegarde personnalisés et bénéficiez de la restauration à chaud pour une sécurité accrue de vos données.

### **Extension Stockage**
Augmentez la capacité de stockage pour archiver des fichiers volumineux au-delà des documents transactionnels usuels (devis, factures, etc.).

## Installation et Démarrage

Suivez ces étapes pour mettre en place un environnement de développement local.

1.  **Cloner le dépôt :**
```shell script
git clone https://github.com/votre-utilisateur/batistack.git
    cd batistack
```


2.  **Installer les dépendances PHP :**
```shell script
composer install
```


3.  **Installer les dépendances Node.js :**
```shell script
npm install
```


4.  **Configuration de l'environnement :**
    Copiez le fichier d'environnement d'exemple et configurez vos variables, notamment la connexion à la base de données.
```shell script
cp .env.example .env
```

    Modifiez ensuite le fichier `.env` avec vos informations.

5.  **Générer la clé d'application :**
```shell script
php artisan key:generate
```


6.  **Exécuter les migrations de la base de données :**
    Pour créer les tables et éventuellement les peupler avec des données de test.
```shell script
php artisan migrate --seed
```


7.  **Compiler les assets frontend :**
```shell script
npm run dev
```


8.  **Lancer le serveur de développement :**
```shell script
php artisan serve
```

    L'application sera accessible à l'adresse `http://127.0.0.1:8000`.

## Lancer les Tests

Pour exécuter la suite de tests automatisés, utilisez la commande suivante :
```shell script
php artisan test
```


## Contribuer

Les contributions sont les bienvenues ! Si vous souhaitez améliorer Batistack, veuillez suivre les étapes suivantes :

1.  Forkez le projet.
2.  Créez une branche pour votre fonctionnalité (`git checkout -b feature/NouvelleFonctionnalite`).
3.  Commitez vos changements (`git commit -m 'Ajout de NouvelleFonctionnalite'`).
4.  Pushez votre branche (`git push origin feature/NouvelleFonctionnalite`).
5.  Ouvrez une Pull Request.

## Licence

Ce projet est sous licence [Nom de la licence].
