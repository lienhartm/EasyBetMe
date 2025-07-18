# EasyBetMe

Plateforme de pari en ligne.

## Projet

### Initialement
Le site était très simple les visiteurs peuvent s'incrire/se connecter au site. Il faut être connecté pour pouvoir parier sur un matches.
Ces matches sont programmés par l'administrateur en ayant préalablement ajouter la compétition, les équipes, les images (équipes, compétitions) et en renseignant le score à l'issu du matches.
Les joueurs ont un aperçu sur le classement, un cadeaux peut être mis en jeu avec l'organisateur de l'événement.

Problématiques
: Structuration peu claire
Fonctionnalité non développé mais omniprésente dans le projet
Absence de documentation
Mauvaise pratique de programmation
Non respect des règles RGPD


### Cahiers des charges
-----------------------
Le projet à été en premier lieu de développer cette plateforme de pari en ligne, pour cela plusieurs grand points ont été l'objet de l'étude:
- Le développement & redynamisme du site 
- Une simplification de la gestion adminsitrateur
- Une automatisation de l'affichage des matches et de l'informations sur le thème du football avec plusieurs API.

En deuxième lieu le développement d'un environnement virtuelle pour palier aux mauvaises pratiques de programmation est nécessaire ainsi qu'au passage à une architecture de type MVC, et bien sûr de la maintenance du site pour une optimmisation. Il s'agit de l'étude:
- Environnement de développement
- Changement d'architecture de type MVC
- Optimisation du site en générale

### Pari
--------
Les matches sur lesquels les paris sont effectuées sont récupéré depuis une API offrant les services souhaité, elle est spécialisé sur le football.

### Jeu
-------
Plateforme de pari en ligne permettant au utilisateur une fois inscrit de pronostiquer sur des matches de football, des crédits sont offerts lors de pari gagné.
Des événements agrémente le temps de jeu permettant des petits challenge sur de courtes durée.
Il faut accepter d'y participer pour bénéficier du gain de points en vue d'effectuer un classement. Suivant la position du joueur dans le classement participant à l'événement des crédits lui seront offert.
Un mini-jeu de penalty permet également d'acquérir des crédits.

### Achat
---------
Des cadeaux qu'ils sont matériels ou bien aussi des bon de crédits, ceux ci d'une certaine valeur peuvent être acheté avec les crédits gagné dans les différentes situations décrites ci-dessus.

### Info
--------
Des informations sont disponible pour l'utilisateur pour les divers coupes et championnats, mais aussi sur les matches récents et à venir, et sur les classement des équipes et des meilleurs joueurs.
Une autre partie est réservé à de l'information plus générale sur le monde du football.

## Technique

### Architecture
----------------
Le site dispose d'une architecture MVC qui permet une évolution de niveau.

### Technologie
---------------

Logiciel
: VSCode, GitHub, Docker, Linux

Langage
: HTML, CSS, JS, PHP, SQL, BASH

Fichier de donnée
: JSON

Fichier émis
: Courriel, PDF

## Base de donnée


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



## Url

| site | sql | phpmyadmin |
| --- | --- | --- |
| :80 | :3306 | :8899 |
