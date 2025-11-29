# [1.4.0](https://github.com/BatistackApp/Core2/compare/v1.3.0...v1.4.0) (2025-11-29)


### Bug Fixes

* **devis:** Corriger l'affichage des contacts manquants ([731993e](https://github.com/BatistackApp/Core2/commit/731993eb9f6b1f02f7eba182955c417e50c3b209))
* simplifier les appels Artisan dans CoreController ([b78adf6](https://github.com/BatistackApp/Core2/commit/b78adf693bea75720b8eec0a2302d4a9fac7744f))


### Features

* ajout de la fonctionnalité de téléchargement de logo pour l'entreprise ([6907f12](https://github.com/BatistackApp/Core2/commit/6907f12d6b7e5560f9dd11647888ded312d52c62))
* ajout de la gestion des conditions générales de vente (develop) ([e83e794](https://github.com/BatistackApp/Core2/commit/e83e794912158ca0ad8f9d90c3bea8f23e5f7a85))
* ajout du schéma d'entrepôt et intégration dans les composants (develop) ([53c49a4](https://github.com/BatistackApp/Core2/commit/53c49a48e11bb66e4abf4222aebafe8ce9060d42))
* Améliorations Majeures des Tiers, Génération PDF et Optimisations Générales ([#86](https://github.com/BatistackApp/Core2/issues/86)) ([6648a68](https://github.com/BatistackApp/Core2/commit/6648a684d9ce48ccf2d692a37afda5809606eb62))
* Intégration de la génération PDF, gestion des informations d'entreprise et des CVG ([#85](https://github.com/BatistackApp/Core2/issues/85)) ([c7f697e](https://github.com/BatistackApp/Core2/commit/c7f697e9933a81b9b53d16cfdc55ca475ddf4329))
* **pdf:** Ajouter service générique de génération PDF et template ([1334b2d](https://github.com/BatistackApp/Core2/commit/1334b2d57f56c45ba2ecff7ea1166fb8aff45acf))
* **pdf:** amélioration du générateur de PDF avec des informations sur la société ([153a127](https://github.com/BatistackApp/Core2/commit/153a12710973dffb8a4d7365d9122e7b8d77db7b))
* **tiers:** Ajouter la génération auto des codes comptables et refactoriser ([39a6f92](https://github.com/BatistackApp/Core2/commit/39a6f92c572debb14b245bfab5fadf1586897cce))
* **tiers:** Ajouter la récupération et l'affichage des informations BODACC ([a1bd547](https://github.com/BatistackApp/Core2/commit/a1bd547c35e63bd8e1ab99eab020fbb78b29e565))
* **tiers:** Automatisation, enrichissement et amélioration de la gestion des Tiers ([#84](https://github.com/BatistackApp/Core2/issues/84)) ([7b1f8c3](https://github.com/BatistackApp/Core2/commit/7b1f8c38c37d2af160203092ffdc730149a5337e))
* **tiers:** Intégrer la recherche d'entreprise par SIREN (develop) ([b8cdfc9](https://github.com/BatistackApp/Core2/commit/b8cdfc9d2abb15ccc05d562f5a2d3fcdb17db2b3))

# [1.3.0](https://github.com/BatistackApp/Core2/compare/v1.2.0...v1.3.0) (2025-11-26)


### Features

* ajout du schéma de formulaire pour le Plan Comptable et ([fb2c727](https://github.com/BatistackApp/Core2/commit/fb2c72774e74aa28f2e219e6ba91b1ece7a59c5f))
* **devis:** ajout de la gestion des types de ligne et calculs associés ([ef56dfe](https://github.com/BatistackApp/Core2/commit/ef56dfef5508b352986390f1ecb64ca34a02814d))
* **devis:** ajout de la gestion des types de ligne et calculs associés ([aaefc76](https://github.com/BatistackApp/Core2/commit/aaefc7616dd3af49a530a80fd95e51aec1a63191))
* **panel:** ajout de la configuration des commerces et des devis ([a481ccb](https://github.com/BatistackApp/Core2/commit/a481ccbbca0d7122cfcc1ee49d897f733bea7553))
* **panel:** ajout de la configuration des commerces et des devis (develop) ([225f152](https://github.com/BatistackApp/Core2/commit/225f1520227ce9f615ccf8da17c3a41a51e6d8ca))

# [1.2.0](https://github.com/BatistackApp/Core2/compare/v1.1.0...v1.2.0) (2025-11-23)


### Bug Fixes

* Remplacer 'form' par 'schema' dans EditAction pour l'action d'édition d'article ([323b814](https://github.com/BatistackApp/Core2/commit/323b8146cef88e33c7ffb54305ea25d97e73d595))


### Features

* **activite:** Ajout de la fonctionnalité de journalisation d'activité ([5951fd9](https://github.com/BatistackApp/Core2/commit/5951fd99ba1088849cf6e1242df98dfe30632cee))
* **activity-log:** Ajout de l'API pour le journal d'activités ([#25](https://github.com/BatistackApp/Core2/issues/25)) ([8bbed21](https://github.com/BatistackApp/Core2/commit/8bbed212854efe64899c8a2f966fdac9af2a60b2))
* Ajout API pour le journal d'activités ([0d0dca1](https://github.com/BatistackApp/Core2/commit/0d0dca14e8624d4397a5530c1942d956add525b2)), closes [#25](https://github.com/BatistackApp/Core2/issues/25)
* Ajout d'une colonne identité avec initiales pour les utilisateurs ([84e51a6](https://github.com/BatistackApp/Core2/commit/84e51a65d2f8b495491c904ee5ff674749c5a7ed))
* Ajout d'une interface d'inventaire pour les articles ([b18de42](https://github.com/BatistackApp/Core2/commit/b18de42aaedbd2a5a881f2d7a26af07c573b7664))
* Ajout de l'observateur DevisObserver et de la relation lines pour les devis ([28a2688](https://github.com/BatistackApp/Core2/commit/28a2688468bb8604dad3cae510edbf2d32be7353))
* Ajout de l'observation du modèle Devis par l'observer DevisObserver ([2a41ddc](https://github.com/BatistackApp/Core2/commit/2a41ddc8fda240813d5cece076d39598fd3561d1))
* Ajout de la gestion des inventaires (develop) ([defa3f3](https://github.com/BatistackApp/Core2/commit/defa3f36415f904d2e5525b0f6deb9f0d0d1d74f))
* Ajout de la gestion des prix des articles ([22e1c66](https://github.com/BatistackApp/Core2/commit/22e1c66540a72e33dc90502ca1b6fb703e83a90f))
* Ajout de la page de liste des devis avec table Filament ([8c2f112](https://github.com/BatistackApp/Core2/commit/8c2f112101767829e8d48ed520558a0c0a6e946f))
* Ajout des actions bulk et des filtres pour la gestion des devis ([384b6be](https://github.com/BatistackApp/Core2/commit/384b6be6796a3e8bf57471cac0d138c8b9ede5fb))
* Ajout des actions et du filtre sur l'inventaire ([2cd9fa9](https://github.com/BatistackApp/Core2/commit/2cd9fa922db37de0516e00e3e658e4a95aad1dce))
* ajout des traits pour les formulaires de commerce (commande et devis) ([cc859b6](https://github.com/BatistackApp/Core2/commit/cc859b6a8d13b5cad5376dee026f2847303dca03))
* Ajout des widgets de devis et commandes en brouillon, avec graphiques ([52ab31d](https://github.com/BatistackApp/Core2/commit/52ab31dc8fc45120c4006f2cffb110161af4b30a))
* Ajout du module commerces avec sous-modules devis et commandes ([dd4500d](https://github.com/BatistackApp/Core2/commit/dd4500dd3341ac7dd905df8ae410fc1291c1f3a3))
* Ajout du système d'inventaire ([e31869c](https://github.com/BatistackApp/Core2/commit/e31869cd3e2643e5219f25a16384fcb1c55c1b70))
* Amélioration de la notification de validation d'inventaire et ajustement de l'action de création ([3e690d3](https://github.com/BatistackApp/Core2/commit/3e690d33889eae8a5af34abbdd20867b3a4eee74))
* **articles:** Ajout de la gestion des stocks avec tableau, filtres et calculs de seuils ([796756c](https://github.com/BatistackApp/Core2/commit/796756cd127fb99e4f338325b3822d4d5b31c3a1))
* **Articles:** Ajout de la méthode creating dans InventoryObserver pour la génération automatique du code et de l'utilisateur ([1acaedb](https://github.com/BatistackApp/Core2/commit/1acaedb9f900909db0867167c4c92cf57753628f))
* **Articles:** Ajout de relations avec les commandes et devis, implémentation du calcul de stock ([8230611](https://github.com/BatistackApp/Core2/commit/8230611c905888227425b586b9b58ab6d3178073))
* **articles:** ajoute un panneau de gestion des stocks ([6c5b8ad](https://github.com/BatistackApp/Core2/commit/6c5b8adb7182af7a9ebd6f68fc19a97015b42a21))
* **articles:** implement complete articles module with price management and configuration panels ([#65](https://github.com/BatistackApp/Core2/issues/65)) ([9da6411](https://github.com/BatistackApp/Core2/commit/9da6411c8e05de8b03b70a7bf482fa619f2179f8))
* **articles:** Permet l'édition du stock et corrige l'affichage ([c2c1736](https://github.com/BatistackApp/Core2/commit/c2c17362368b35f002f4c2697421da7a94538d5f))
* **auth:** Ajoute la connexion par SSO ([1c8dc81](https://github.com/BatistackApp/Core2/commit/1c8dc812a35be8141a6c3e6b81f03153af1ce81b)), closes [#19](https://github.com/BatistackApp/Core2/issues/19)
* **auth:** ajoute la connexion SSO et un endpoint de backup ([8c3c01d](https://github.com/BatistackApp/Core2/commit/8c3c01da7719ce00f21d9c779a39d439a4b96fde))
* **commerce:** Ajout des widgets de table et de graphique pour le commerce ([8777ed4](https://github.com/BatistackApp/Core2/commit/8777ed45f5da5f946e3bdaa9b558f51c60d947ee))
* **config:** add category and unit management panels for articles configuration ([2479033](https://github.com/BatistackApp/Core2/commit/247903334b473ef9c52dfac425c06dd1ad49750f))
* **config:** Intégration du module filament-export pour la gestion des catégories et unités ([0097f76](https://github.com/BatistackApp/Core2/commit/0097f765274f28f7d5bbc6ff980dcfa864ad7df3))
* **core:** Ajout d'un point d'accès de bilan de santé ([c85f2f9](https://github.com/BatistackApp/Core2/commit/c85f2f9d0d2fc32173e9527a83082aed7bbbbb1b))
* **inventory:** ajout de la génération de PDF pour les inventaires ([19da441](https://github.com/BatistackApp/Core2/commit/19da4412bd397c1d6a8d1b888393355fa5fb72c5))
* **sante:** Ajout du point d'accès de vérification de santé ([17467be](https://github.com/BatistackApp/Core2/commit/17467bea79685232f7d6605a96e82c0523fcc88d))

# [1.1.0](https://github.com/BatistackApp/Core2/compare/v1.0.0...v1.1.0) (2025-11-15)


### Bug Fixes

* **css:** corriger la déclaration des propriétés CSS dans `app.css` ([ad72408](https://github.com/BatistackApp/Core2/commit/ad724081b041361ce8b4b15df2eed8653c4d74fc))
* **dev, tiers:** Corrections pour Vite/Herd et module Tiers ([#59](https://github.com/BatistackApp/Core2/issues/59)) ([a3d6b0d](https://github.com/BatistackApp/Core2/commit/a3d6b0da50ae8408c81b43ada43421cd10396dca))
* **dev:** Configure Vite pour Herd (SSL/HMR) et finalise l'UI Tiers ([cba59b3](https://github.com/BatistackApp/Core2/commit/cba59b39bb9c03f76b694c870aa520a2b693479c))
* **tiers:** Corriger l'action de suppression d'un tiers ([ce06e40](https://github.com/BatistackApp/Core2/commit/ce06e40f5d1bbda2831da9980d12832cf05837e0))


### Features

* Ajout d'un modal de confirmation pour la suppression des Tiers ([d4177e5](https://github.com/BatistackApp/Core2/commit/d4177e55ddb59f6151a8e82ef89f04df6443fbbb))
* Ajout du fichier de prompt pour l'Assistant IA PR ([3ffcb86](https://github.com/BatistackApp/Core2/commit/3ffcb8630c08f6878dc9e27a7b900518c43fe835))
* **articles:** ajouter les modèles, migrations et factories pour la gestion des articles, stocks, ouvrages et catégories ([09ee540](https://github.com/BatistackApp/Core2/commit/09ee54098e8b0ed68854ca89c60dae5192a690d6))
* **articles:** Implémente les alertes de stock et le calcul de coût des ouvrages ([d6e8ea3](https://github.com/BatistackApp/Core2/commit/d6e8ea3b5b3d4798ab619477b667246b33b280d2))
* **banking:** implémentation complète de la gestion bancaire des tiers ([9e26d2c](https://github.com/BatistackApp/Core2/commit/9e26d2c9c203b5145e0a29720d67d28b1e62b832))
* **banque:** ajouter les modèles, migrations, énumérations et factories pour la gestion bancaire ([b8336ea](https://github.com/BatistackApp/Core2/commit/b8336ea489fa888cf6c0155cc07d63f9286c3f87))
* **chantiers:** ajouter le modèle et la factory pour la gestion des postes de chantiers ([ccb06ed](https://github.com/BatistackApp/Core2/commit/ccb06edc2bebc6d6cee59d1b1d9ac0b815fd9438))
* **chantiers:** ajouter les modèles, énumérations, migrations et factories pour la gestion des chantiers ([d587b9b](https://github.com/BatistackApp/Core2/commit/d587b9b529c3bea76ef66723e236b05276da8b02))
* **chantiers:** ajouter les modèles, énumérations, migrations et factories pour la gestion des chantiers ([#49](https://github.com/BatistackApp/Core2/issues/49)) ([a5d3d2b](https://github.com/BatistackApp/Core2/commit/a5d3d2ba4ef6e3d9e43fa95700b6420bfa74e8bf))
* **commerces:** ajouter les modèles, énumérations, migrations et factories pour les commandes et devis ([611e65d](https://github.com/BatistackApp/Core2/commit/611e65ddccfd8bfbabfbe476b7461f90f4d40464))
* **comptabilite:** ajouter les modèles, migrations et factories pour la gestion comptable ([3f4d701](https://github.com/BatistackApp/Core2/commit/3f4d70143cbcd945b6c0ac6a4f65bc7b7dd1f8ee))
* **core:** ajouter les entités Units et Warehouses avec leurs migrations et factories ([c4a8062](https://github.com/BatistackApp/Core2/commit/c4a8062133cfd28f631d9ee54dfca7efd172d41f))
* **facturation:** ajouter les modèles, énumérations, migrations et factories pour la gestion des factures ([1fd035a](https://github.com/BatistackApp/Core2/commit/1fd035afee6ee3798872c0bebc2ffd395b01a7e0))
* **flottes:** ajouter les modèles, énumérations, migrations, observers, jobs et commandes pour la gestion des flottes ([aa085ba](https://github.com/BatistackApp/Core2/commit/aa085bae65ab69f0ddfe1622b038d43e63a81195))
* **ged:** ajouter les modèles, migrations, observers, factories et énumérations pour la gestion des documents et collections GED ([bde0223](https://github.com/BatistackApp/Core2/commit/bde0223a159bdeef41990be0aba63e27cafa6ad2))
* **gpao:** ajouter les modèles, observers, jobs, énumérations et commandes pour la gestion des ordres de fabrication ([8076ac1](https://github.com/BatistackApp/Core2/commit/8076ac1247888d00a9ef63ef0095fdbc64ac3794))
* **grh:** ajouter les modèles, migrations, énumérations et factories pour la gestion RH ([a4d51d3](https://github.com/BatistackApp/Core2/commit/a4d51d387cd9840ca975ab3f1abcaf8cac9112d6))
* Implémentation des principaux modules métier ([#58](https://github.com/BatistackApp/Core2/issues/58)) ([1799a5c](https://github.com/BatistackApp/Core2/commit/1799a5cdffa66ec365e5d18ce61d665a917102b6))
* **locations:** Implémente la facturation auto et la gestion des disponibilités ([df0e0f0](https://github.com/BatistackApp/Core2/commit/df0e0f0252de9aa046f1a2ca076aa17d5a24b800))
* **note-frais:** ajouter les modèles, observers, jobs, énumérations, factories et commandes pour la gestion des notes de frais ([58c77d7](https://github.com/BatistackApp/Core2/commit/58c77d7f47ad25f261ab4b468f9e1e3338c178bf))
* **paie:** ajouter les modèles, migrations, énumérations et factories pour la gestion de la paie ([9a28b10](https://github.com/BatistackApp/Core2/commit/9a28b10afe7763d5e3300fc56722808bf7b4ec1c))
* **planning:** ajouter les entités et configurations pour la gestion des plannings ([73fbf98](https://github.com/BatistackApp/Core2/commit/73fbf98d257f2cce2df95c641cdf6ab510591043))
* **signature:** ajouter les modèles, énumérations, migrations, observers, jobs et notifications pour la gestion des signatures électroniques ([3aa18f9](https://github.com/BatistackApp/Core2/commit/3aa18f90ae497546b8e3af2f12ed33754a0672a8))
* **tiers:** implémentation complète de la fiche détaillée et gestion des relations ([e72afc0](https://github.com/BatistackApp/Core2/commit/e72afc06d06fefdf57de82e0421d1a42449eadf8))
* **tiers:** Implémente la logique métier via les Observers et finalise les modèles ([45f0d18](https://github.com/BatistackApp/Core2/commit/45f0d189e42097795fa2effcff44bea7d66b5f28))
* **vision:** Implémente le traitement et l'extraction des maquettes BIM ([85b9f9b](https://github.com/BatistackApp/Core2/commit/85b9f9b6b6e3b35b31284032f4a10efaef5920b4))

# 1.0.0 (2025-11-09)


### Features

* **ConfigModule:** add module ordering and activation actions ([645f5df](https://github.com/BatistackApp/Core2/commit/645f5df6c6c09591e34e9a3884f6256fa594c296))
* **core, tests:** améliorer la gestion des actions et ajouter des tests pour les composants principaux ([f05e7c3](https://github.com/BatistackApp/Core2/commit/f05e7c3f7d2d9e933ce2fc16908b28bf87d55cde))
* **core:** ajouter et initialiser les fonctionnalités principales Metronic ([83540e3](https://github.com/BatistackApp/Core2/commit/83540e3a76a72174c588d8293cca3aaab656ee32))
* **core:** ajouter un composant Livewire pour la visualisation des licences ([bc28b43](https://github.com/BatistackApp/Core2/commit/bc28b43301ca6f18aefc6b1852535aa2a1222da3))
* **core:** ajuster les couleurs des statuts et ajouter une nouvelle route pour la licence ([d79cbc4](https://github.com/BatistackApp/Core2/commit/d79cbc488369cf1b5f4ab2c1bfda0ce2240b5445))
* **docs:** ajouter le fichier Readme.md pour documenter Batistack ([b945c67](https://github.com/BatistackApp/Core2/commit/b945c67763f9fdb4bbc8eade6429eca03926b767))
* Gérer les erreurs de création d'utilisateur API ([af899a5](https://github.com/BatistackApp/Core2/commit/af899a599b9fbed0927a3c76bec9b6023162730c))
* **mattermost:** Intégration des notifications Mattermost ([175e943](https://github.com/BatistackApp/Core2/commit/175e9437e4cfe94922134c41a951387f5cc5b339))
* Mettre en place une CI/CD complète et l'automatisation du workflow ([f613751](https://github.com/BatistackApp/Core2/commit/f613751209660c0cdcbc663189705054b24282b0))
* **navigation:** améliorer la navigation avec wire:navigate et onglets dynamiques ([e7ddb0b](https://github.com/BatistackApp/Core2/commit/e7ddb0bc274de3fdbd20e3831634fca829f90476))
* **notifications:** refactorisation de l'affichage et traduction de l'interface ([afc9000](https://github.com/BatistackApp/Core2/commit/afc9000d292d54a9181509308ddc6f8a757095b5))
* Permettre la mise à jour du mot de passe utilisateur ([959f415](https://github.com/BatistackApp/Core2/commit/959f4155708e76bb351b22dd72d0163a28974d49))
* **pr-agent, installation:** Ajouter l'agent de PR et corriger l'URL d'image ([113be70](https://github.com/BatistackApp/Core2/commit/113be7057725a7045499782901a12c9bc4d78111))
* **profile:** add user profile page and navigation links ([e50a7ba](https://github.com/BatistackApp/Core2/commit/e50a7ba2eb1b19d9f05db35cd897d45585ca7857))
* **profile:** ajouter des composants Livewire pour les panneaux de profil ([d493a7c](https://github.com/BatistackApp/Core2/commit/d493a7c6e3b65aace54797120c39c8ec30a34624))
* **profile:** ajouter la gestion de l'authentification à deux facteurs (2FA) ([62a557f](https://github.com/BatistackApp/Core2/commit/62a557f5b98a6de4f1018a0f64d7e056c89c087c))
* **profile:** ajouter la gestion de l'authentification à deux facteurs (2FA) ([725116b](https://github.com/BatistackApp/Core2/commit/725116bef361fcce0a10ebaf80736b85fc7743ec))
* **profile:** intégrer la gestion des informations utilisateur et la suppression de compte ([172c716](https://github.com/BatistackApp/Core2/commit/172c7168b2e1eecd77b5673f99308ddc17ea0885))
* **tests:** ajouter des tests pour UserController et CoreController ([b21ef1b](https://github.com/BatistackApp/Core2/commit/b21ef1b4859bb81c0eef28eebdc76886da7db871))
* **tiers:** ajouter le modèle, les énumérations et les migrations po… ([#45](https://github.com/BatistackApp/Core2/issues/45)) ([bdbc9d9](https://github.com/BatistackApp/Core2/commit/bdbc9d950ed40ed4ae58b58f2ac7fe4708f713a9))
* **tiers:** ajouter le modèle, les énumérations et les migrations pour la gestion des tiers ([d7d47eb](https://github.com/BatistackApp/Core2/commit/d7d47ebd9317cfb7255425572fe3f9ef63bc07ad))
* **tooling:** ajouter Larastan, Rector et leur configuration pour l'analyse statique et le refactoring ([f63d3d8](https://github.com/BatistackApp/Core2/commit/f63d3d80bf5f69a046eeb735ae76e16d2573a319))
* **ulys:** Intégration du connecteur Ulys ([9b86d56](https://github.com/BatistackApp/Core2/commit/9b86d5633be6e5ee7065ff22ab1864f859afcc98))
* **user:** add gravatar integration for user avatars ([fc5aa05](https://github.com/BatistackApp/Core2/commit/fc5aa056268ab2c128721a147dd3f1a6b0dfd964))
* **workflows:** ajouter une étape pour nettoyer les schémas avant les migrations ([fbfa834](https://github.com/BatistackApp/Core2/commit/fbfa834e4c623e3becf5a67b55d9c49d9fb6aff8))
* **workflows:** ajouter une étape pour nettoyer les schémas avant les migrations ([a29ce71](https://github.com/BatistackApp/Core2/commit/a29ce71ecd933b7c00bf2ac8e299ffe5841b6bfe))
* **workflows:** automatiser les migrations de base de données dans CI ([7248ade](https://github.com/BatistackApp/Core2/commit/7248adeacb65d60d8001450d8711bdf38a154f65))
* **workflows:** configurer SQLite pour les tests dans le workflow CI ([c709a58](https://github.com/BatistackApp/Core2/commit/c709a58726819cd2e49446d70105b133f3993acc))
* **workflows:** corriger l'analyse de couverture avec une extraction XML robuste ([92ad146](https://github.com/BatistackApp/Core2/commit/92ad146265b896f687a171a02c0004d2e14c30bc))
* **workflows:** extraire et exposer le pourcentage de couverture dans la pipeline ([49a3240](https://github.com/BatistackApp/Core2/commit/49a32400a204f0bfe6148a4df53a9537fa0ad753))
* **workflows:** modifier la configuration SQLite pour utiliser un fichier local ([8250580](https://github.com/BatistackApp/Core2/commit/825058061e37d20c0a050ee490fb06bf06228c83))
