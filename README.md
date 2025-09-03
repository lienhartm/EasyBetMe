# EasyBetMe

## Licence professionel génie logiciel : développement, conception et test

### Stage de fin d'étude à la formation de l'UHA4.0

#### 2023 - 2025

##### Stagiaire : LIENNART Michaël
##### Tuteur professionel : OBERLE Jean-Charles

##### Tuteur académique : FRONSECA Daniel
###### Etude pluri-disciplinaire en informatique, science des données, psychologie cognitive, économie comortementale, sciences sociales ainsi que l'analyse scientifique sous l'angle de la gamification d'une plateforme de pari en ligne.

----

## Sommaire

I. Introduction
1. Présentation
1.1. Nature et architecture du système
1.2. Composantes fonctionnelles
1.3. Aspect techniques et méthodologiques
1.4. Aspects UX / UI et cognition humaine
1.5. Impacts sociaux et éthiques
1.6. Bilan
2. Gamification
2.1. Définition scientifique de la gamification
2.2. Mécanisme de gamification observés dans *EasyBetMe*
2.3. Analyse selon le modèle Octalysis (Yu-kay Chou)
2.4. Ancrage académique et théorique
2.5. Risques et recommandations (Perspective critique)
2.6. Bilan

II. Cahiers des charges
1. Phases de développement
2. Fichiers de Maintenance
3. Planning suivi de projet
4. Projet
4.1. Initialement
4.2. Cahiers des charges V1
4.3. Cahiers des charges V2
5. Aspect Technique
5.1. Architecture
5.2. Technologie
5.3. Base de donnée
5.4. Url
5.5. Crontab

III. Conclusion

----

## I. Introduction

### 1. Présentation

#### 1.1. Nature et Architecture du système

EasyBetMe est une plateforme interactive en ligne, appatenant à la catégorie des systèmes d'information transactionels avec des composants ludiques, éducatifs et commerciaux. Elle repose sur une architecture client-serveur, interfacée avec des API tierces spécialisées dans le football pour l'acquisition de données sportives en temps réel.

#### 1.2. Composantes Fonctionnelles

a. Module de Pari (Générateur de prédictions)

- Modèles décisionnel utilisateur : Les joueurs prennet des décisions basées sur des informations footballistiques (scores, classements, historiques). Cela fait appel à des concepts de théorie de la décision et modèles cognitifs de prédiction.
- Interaction API - Système : Les données sont synchronisées via des appels API RESTful. Cela implique l'usage de protocols HTTP, de formats d'échange JSON/XML, et d'un système de parsing et de mise à jour automatique de la base de données locale.

b. Module Jeu (gamification & Engagement)

- Utilisation de mécanismes de gamification : systèmes de récompenses, mini-jeux (ex. :penalty), événements temporels.
- Système de classement dynamique : basé sur des algorithmes de ranking (probablement ordonnés par score cumulatif ou ELO-like).
- Rétroaction comportementale : Le système offre des crédits en retour de bonnes prédictions ou de performances dans les mini-jeux. C'est un renforcement positif au sens de la psychologie comportementale.

c. Module Achat (Système d'Echange de Valeur)

- Système de crédit interne basé sur une monnaie virtuelle acquise via la performance utilisateur.
- Modèle économique semi-compétitif : Les utilisateurs utilisent leurs crédits pour acheter des récompenses dans un système de type "enchère fermée" ou "accumulation contributive", où le permier à atteindre la somme acquiert le bien.
- Utilisation de notions de microéconomie, de théorie des jeux (compétition pour les ressources limitées), et de systèmes incitatifs.

d. Module Informationnel (Base de Connaissance Sportive)

- Agrégation d'information à partir de sources journalistiques et bases sportives : ce module agit comme une base de données informationnelle, structurée en ontologie sportives (équipes, classements, compétitions, joueurs).
- Objectif : soutenir l'engagement et la décision du joueur via des interfaces cognitives d'aide à la décision, tout en renforçant l'immersion.

#### 1.3. Aspect Techniques et Méthodologiques

 - Languages et technologies probables : PHP (backend), Javascript (frontend), MySQL (base de données), appels API (cURL).
 - Conteneurisation possible (Docer) pour l'isolation des services backend (ex. : Apache + PHP + Cron).
 - Sécurité applicative : nécessite la mise en oeuvre de contrôles d'accès, filtrage des entrées (protection XSS/SQLi), et de gestion des sessions utilisateurs.

#### 1.4. Aspects UX / UI et Cognition Humaine

- Présence de feedback immédiat, de récompenses visuelles, et d'éléments de motivation extrinsèque.
- Cela s'appuie sur des théories de l'expérience utilisateur gamifiée (ex. : modèle Octalysis).
- Utilisation de représentations mentales, de biais cognitifs (ex : biais de récence, biais du survivant) pouvant influencer la prise de décision des joueurs.

#### 1.5. Impacts Sociaux et Ethiques

- L'aspect de compétition pour des biens matériels introcuit des enjeux liés à la dépendance qu jeu, similaires aux systèmes de loot boxes.
- Risques de biais algorithmique dans la distribution des récompenses ou l'équité du classement.
- La dimension communautaire et compétitive poe des questions sur la gestion de la transparence, la confidentialité des données utilisateurs, et le RGPD.

#### 1.6. Bilan

EasyBetMe est une plateforme hybride entre le serious game et le système transactionnel, articulée autour de la gamification des pronostics sportifs et de l'utilisation d'une monnaie virtuelle comme mécanisme d'engagement. Elle mobilise une diversité de concepts scientifiques : systèmes d'information, psychologie du joueur, science des données sportives, théorie des jeux, architecture logicielle distribuée, et UX design.

### 2. Gamification

#### 2.1. Définition scientifique de la gamification :

La gamification
: Terme désignant l'application des mécanismes du jeu dans des contextes non-ludiques afin de renforcer l'engagement, la motivation et l'expérience utilisateur
[*(Deterdin et al. 2011)*](https://github.com/lienhartm/EasyBetMe/blob/main/documentation/deterding11.pdf)

Dans le cas d'*EasyBetMe*, la gamification sert à motiver les utilisateurs à interagir avec la plateforme de manière régulière, prendre part à des événements et s'investir dans un parcours de progression, tout cela sans mise d'agent réelle.

#### 2.2. Mécanismes de gamification observés dans *EasyBetMe*

| Mécanisme Gamifié | Implémentation sur EasyBetMe | Concepts associés |
| --- | --- | --- |
| **Points & crédits** | Crédits gagnés via pronostics ou mini-jeux | Système de récompense, renforcement extrinsèque |
| **Classements** | Classement général + classement par événement | Compétition sociale, motivation intrinsèque |
| **Défis temporels** | Evénements ponctuels avec bonus à la clé | "Time-limited challenge", dynamique de rareté |
| **Mini-jeu (pénalty)** | Jeu complémentaire pour gagner des crédits | Ludification directe, micro-engagement |
| **Boutique virtuelle** | Achat de cadeaux via crédits accumulés | Objectif, progression, sens du but |
| **Progression & récompense différée** | Contribution partielle jusqu'à l'obtention du cadeau | Accumulation, anticipation, gratification différée |
| **Opt-in pour les classements** | L'utilisateur choisit de participer à l'événement | Volontariat, autonomie (cf. SDT[^*])

[^*]SDT : **Self-Determination Theory (Deci & Ryan, 2000) - Théorie de la motivation qui souligne le rôle de l'autonomie, la compétence et la raison sociale.

#### 2.3. Analyse selon le modèle Octalysis (Yu-kay Chou)

Le modèle Octalysis est une grille d'analyse bien connue de la gamification, basée sur 8 motivations humaines fondamentales. Voici comment **EasyBetMe** s'y inscrit :

| Core Drive | Description | Application sur EasyBetMe |
| ---- | ---- | ---- |
| Sens de la réussite | Progresser, atteindre un objectif | Accumuler des crédits, obtenir un cadeau |
| Curiosité / imprévu | Découverte de nouveautés, imprévu | Matchs impévisibles, événements aléatoires |
| Influence sociale | Compétion, classement, comparaison | Classement des joueurs, classement par événement |
| Possession | Avoir, améliorer, collectionner | Collection de crédits, obtention exclusive d'un cadeau |
| Evitement | Ne pas rater une opportunité | Evénements limités dans le temps |
| Compétence | Se sentir capable, stratégie | Pronostics réussis, gameplay du mini-jeu |
| Autonomie | Choix de participer, style de jeu | Choisir ses paris, son moment de participation |
| But épique | Se sentir utile, faire partie de qqchose | Communauté de parieurs, compétition générale |

#### 2.4. Ancrage académique et théorique

- **Gamification <> jeu complet** : EasyBetMe n'est pas unjeu vidéo, mais utilise les *dynamics* et *mechnics* du jeu pour augmenter l'engagement.
- **Comportementalisme** : Le système de crédits agit comme un renforcement positif [*(Skinner, 1938)*](https://github.com/lienhartm/EasyBetMe/blob/main/documentation/convention_28406_MICHAËL_LIENHART-1.pdf).
- **Economie comportementale** : La gratification différée, l'accumulation de points et les classements ecploitent des biais cognitifs (biais de rareté, effet de dotation, biais d'ancrage).
- **Expérience utilisateur** : L'interface gamifiée améliore la satisfaction et la fdélisation des utilisateurs par des éléments de progression visibles.

#### 2.5. Risques et recommandations (Perspective critique)

| risques potentiels | Recommandations |
| ---- | ---- |
| Risque d'addiction au système de récompense | Ajouter des limites / messages de prévention |
| Frustration des nouveaux joueurs | Ajouter un tutoriel gamifié pour les premiers paris |
| Inégalité entre joueurs occasionels et réguliers | Equilibrer les événements avec de s"ligues" ou "niveaux" |

#### 2.6. Bilan

EasyBetMe est un excelent exemple de plateforme digitale combiant gamification, traitement de données sportives, et dynamique communautaire.
Elle utilise avec efficacité les mécanismes ludiques pour augmenter l'engagement, la fidélité et l'investissement des utilisateurs sans recourir à des enjeux monétaires réels.

Sonétude permet d'illustrer l'impact des designs motivants dans un contexte hybride entre jeu, compétition et consommation.

----

## II. Cahiers des charges

### 1. Phases de développement

- Début de développement dela version V1 (janvier 2025, UHA4.0 - MonWebPro)
- Fin de développement de la version V1 (juillet 2025, UHA4.0 - MonWebPro)
- Début du développement de la version V2 (mars 2025)

### 2. Fichiers de Maintenance

Démarrage docker:
: docker_build_run.sh

RAZ Docker:
: docker_remove.sh

### 3. Planning suivi de projet

|- Date -|- Phase -|
|----------|----------|
| Mars 2025 |- Mise en place de l'environnement logiciel Docker (dévelopement de la version V2) |
| Avril 2025 | - Mise en place de la base de donnée MySQL (insertion des exports bd existante) |
| Juillet 2025 | - Mise en place de l'architecture de type MVC <br> - Mise en place du CSS de la version V1 |
| Août 2025 | - Correction CSS template.php <br> - Tâche cron de récupération des données API et de mise à jour BD |

### 4. Projet

#### 4.1 Initialement

Le site était très simple les visiteurs peuvent s'incrire/se connecter au site. Il faut être connecté pour pouvoir parier sur un matches.
Ces matches sont programmés par l'administrateur en ayant préalablement ajouter la compétition, les équipes, les images (équipes, compétitions) et en renseignant le score à l'issu du matches.
Les joueurs ont un aperçu sur le classement, un cadeaux peut être mis en jeu avec l'organisateur de l'événement.

##### Problématiques:
- Structuration peu claire,
- Fonctionnalité non développé mais omniprésente dans le projet,
- Absence de documentation,
- Mauvaise pratique de programmation,
- Non respect des règles RGPD.

#### 4.2 Cahiers des charges V1

Le projet à été en premier lieu de développer cette plateforme de pari en ligne, pour cela plusieurs grand points ont été l'objet de l'étude:
- Le développement & redynamisme du site 
- Une simplification de la gestion adminsitrateur
- Une automatisation de l'affichage des matches et de l'informations sur le thème du football avec plusieurs API.

En deuxième lieu le développement d'un environnement virtuelle pour palier aux mauvaises pratiques de programmation est nécessaire ainsi qu'au passage à une architecture de type MVC, et bien sûr de la maintenance du site pour une optimmisation. Il s'agit de l'étude:
- Environnement de développement
- Changement d'architecture de type MVC
- Optimisation du site en générale

##### Description

Pari
: Les matches sur lesquels les paris sont effectuées sont récupéré depuis une API offrant les services souhaité, elle est spécialisé sur le football.

Jeu
: Plateforme de pari en ligne permettant au utilisateur une fois inscrit de pronostiquer sur des matches de football, des crédits sont offerts lors de pari gagné.
Des événements agrémente le temps de jeu permettant de petits challenge sur de courtes durée permettant d'obtenir des bonus suivant la position dans le classement qui est propre à l'événement.
Il faut accepter d'y participer pour bénéficier du gain de points en vue d'effectuer un classement. Suivant la position du joueur dans le classement participant à l'événement des crédits lui seront offert.
Un mini-jeu de penalty permet également d'acquérir des crédits, automatiquement crédité sur le compte du joueur.

Achat
: Des cadeaux qu'ils sont matériels ou bien aussi des bon de crédits, ceux ci d'une certaine valeur peuvent être acheté avec les crédits gagné dans les différentes situations de jeux décrites ci-dessus.
L'achat d'un cadeau se fait par l'apport total ou partiel jusqu'au paiement total de la somme du montant du produit. Cela permet une compétition en toute transparence jusqu'à ce qu'un joureur obtienne le cadeau, dès lors celui-ci ne sera plus disponible à l'ensemble des joueurs. Le joueur qui détient l'obtention du cadeau recevra un mail pour avoir le droit de retirer ce dernier dans le lieu approprié, tandis que les bon de crédit seront automatiquement crédité sur le solde du compte du joueur.

Info
: Des informations sont disponible pour l'utilisateur pour les divers coupes et championnats, sur les matches récents et à venir, mais aussi sur les classement des équipes, les meilleurs joueurs et sur les équipes ayant remporté la compétition.
Une autre partie est réservé à la globalitée de l'information sur le monde du football recencé par des articles publiés dans la presse.

#### 4.3. Cahiers des charges V2

Comme annoncé plus haut dans le *'cahiers des charges V1'* la refonte du site **Easybet** permettra d'augmenter la qualité, les performances, et l'optimisation de la base de donnée et la scalabilité :

- Qualité : refonte du style pour ne garder que l'essentiel
- Performances : en passant à une architecture de type MVC
- Optimisation : en soulageant le stockage des fichiers *.json et diverses améliorations
- Scalabilité : en développant le bouquet de sportif,  ... =>-> V3 ?

##### Description

Crontab
: L'utilisation de la tâche *CRON* se fera hors du conteneur depuis l'hôte. Tous les jours à 4h00 du matin celle ci sera exécutée récupérant ainsi les données footbalistiques (sportives et articles de presse) et mets également à jour les paris effectuer par les joureurs pour l'obtention des points et crédits.

### 5. Aspect Technique

#### 5.1. Architecture
Le site dispose d'une architecture MVC qui permet une évolution de niveau.

#### 5.2. Technologie

Logiciel
: VSCode, GitHub, Docker, Linux

Langage
: HTML, CSS, JS, PHP, SQL, BASH

Fichier de donnée
: JSON

Fichier émis
: Courriel, PDF

#### 5.3. Base de donnée


                                        +---------------------+ 
                                        |  easybet_events     |
       +----------------------+         +---------------------+
       |   easybet_gamers     |         | id (PK)             |
       +----------------------+         | datedebut           |
       | id (PK)              |         | datefin             |
       | id_event (FK)        | *-----1 | competition         |
       | id_user (FK)         |         | description         |
       | event_points         |         | cadeau              |
       +----------------------+         | img                 |
                  *                     +---------------------+
                  |
                  1
       +-------------------+         +-----------------+         +-------------------------+
       |  easybet_users    |         |  easybet_gifts  |         |  easybet_gifts_users    |
       +-------------------+         +-----------------+         +-------------------------+
       | id (PK)           |         | id (PK)         |         | id (PK)                 |
       | pseudo            | 1-----* | nom             | 1-----* | id_gifts (FK)           |
       | email             |         | description     |         | id_users (FK)           |
       | password          |         | prix            |         | coins                   |
       | coins             |         +-----------------+         +-------------------------+
       +-------------------+
                 1
                 |
                 *
       +-------------------+
       |  easybet_bets     |
       +-------------------+
       | id (PK)           |
       | id_user (FK)      |
       | id_game (FK)      |
       | date              |
       | score_d           |
       | score_v           |
       | bet               |
       | result            |
       +-------------------+



#### 5.4. Url

| Base | Site | SQL | PhpMyAdmin |
| --- | --- | --- | --- |
| http://localhost | :80 | :3306 | :8899 |

#### 5.5. Tâche Cron

La commande suivante permet d'insérer la tâche *cron* dans le fichier *crontab* en la recopiant directement dans le terminal de votre ordinateur hébergeant localement l'environnement docker propre au site **EasyBetMe**.

```bash
(crontab -l; echo "# Récupération des données depuis les API's";echo "0 4 * * * docker exec php73 php /var/www/html/cron/crontab.php") | crontab -
```

----

## Conclusion

EasyBetMe se présente comme une plateforme hybride située à la croisée du serious game et du système transactionn5.5. Crontabel. Elle est articulée autour de la gamification des pronostics sportifs et de l'utilisation d'une monnaie virtuelle en tant que levier d'engagement. Son fonctionnement repose sur une combinaison de disciplines scientifiques telles que les systèmes d'information, la psychologie cognitive du joueur, la science des données sportives, la théorie des jeux, l'architecture logicielle distribuée, ainsi que le design de l'expérinece utilisateur (UX).

EasyBetMe constitue un exemple pertinent de plateforme numérique intégrant avec efficacité :
- les mécanisme ludiques pour stimuler la participation,
- le traitement dynamique de données sportives en temps réel,
- et une dimension communautaire compétitive fondée sur des classements, des événements et des récompenses virtuelles.

Elle parvient à susciter l'engagement, la fidélisation et l'invertissement cognitif des utilisateurs sans faire appel à des enjeux financiers réels, mais en s'appuyant sur des motivations intrinsèques et extrinsèques.

L'analyse de cette plateforme met en lumière l'intérêt et la puissance des stratégies de design gamifiées dans un contexte numérique où se rencontrent le jeu, la compétition et la consommation différée.

----

## Référence

#### Documents
- Edward L. DECI, Richard M. RYAN, *Allocution du président honoraire (2007)*,  University of Rochester - Canadian Psychology by the Canadian Psychological Association (2008). [document](https://github.com/lienhartm/EasyBetMe/blob/main/documentation/2008_DeciRyan_CanPsy_French.pdf)
- Sebastian Deterding, Dan Dixon, Rilla Khaled, Lennart Nackle, *From Game Design Elements to Gamefulness: Deﬁning Gamiﬁcation*, Conférence Paper (September 2011). [document](https://github.com/lienhartm/EasyBetMe/blob/main/documentation/deterding11.pdf)
- The Octalysis Group, *The Octalysis Framework is a groundbreaking approach to gamification, developed by Yu-kai Chou,...*, Octalysis Framework 2025. [website](https://octalysisgroup.com/framework/)
- B.F. SKINNER, *The Behavior of Organisms an Experimental Analysis*, The Century Psychology Series (1938). [document](https://github.com/lienhartm/EasyBetMe/blob/main/documentation/convention_28406_MICHAËL_LIENHART-1.pdf)

#### Site web
- UHA4.0, *L'école du Numérique, une formation universitaire en développement informatique 100% projet à Mulhouse, en Alsace !*, UHA4.0, 2025. [website](http://www.uha4point0.fr)
- 4.0, *Formations innovantes 4.0*, UAH, 2025. [website](https://www.uha.fr/fr/formation-1/accompagnement-a-la-reussite-1/formations-innovantes-4-0.htmls)
- MonWebPro, *Votre site internet professionnel*, MonWebPro, 2025. [website](https://www.monwebpro.com/)
- EasyBet, *Bienvenue sur le site EasyBetMe !*, EasyBetMe, 2025. [website](monwebprohttps://www.easybet.me/)

#### API
- News API, *Search News and Blog Articles on the Web*, News API, [website](https://newsapi.org)
- football∼data⋅org, *A restful API for football data.*, [website](https://www.football-data.org/)

