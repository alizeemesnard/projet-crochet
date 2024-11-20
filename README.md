# Application ‘Projet-Crochet’

## Description

Projet-Crochet est une application dédiée aux passionnés de crochet, permettant aux utilisateurs de gérer leur collection de modèles de crochet. Les membres peuvent créer des fiches détaillées pour chaque patron, gérer leur collection de patrons, et partager certains modèles avec la communauté via des galeries.

## Entités

- [Inventaires] = patternCollection (collection de patrons).
- [Objets] = CrochetPattern (patron de crochet).
- [Membre] = Member.
- [Galeries] = Portfolio (galerie contenant des patrons d’un membre).

## AppFixtures: voici comment les données sont chargées

// 1. On charge les membres
    $this->loadMembers($manager);
	A ce stade, aucune relation n’est établie.
// 2. On charge les collections
    $this->loadMembers($manager);
	A ce stade, on établit une relation OneToOne entre les membres et les collections.
// 3. On charge les patrons
    $this->loadCrochetPatterns($manager);
	A ce stade, on établit une relation OneToMany entre les collections et les patrons (une collection a plusieurs patrons).
// 4. On charge les portfolios
    $this->loadPortfolios($manager);
	A ce stade, on établit une relation OneToMany entre les membres et les portfolios (un membre a plusieurs portfolios).
	A ce stade, on établit une relation ManyToMany entre les patrons et les portfolios (un patron peut appartenir à plusieurs portfolios et un portfolio possède plusieurs patrons).

## Voici les différents liens accessibles.

| Name                                | Path                                                       | Explication                                                        |
|-------------------------------------|------------------------------------------------------------|--------------------------------------------------------------------|
| app_crochet_pattern_index           | /crochet/pattern/list                                      | Liste des patrons de crochet du membre                             |
| app_crochet_pattern_show            | /crochet/pattern/{pattern_id}                              | Affiche un patron de crochet spécifique                            |
| app_crochet_pattern_edit            | /crochet/pattern/{pattern_id}/edit                         | Permet d'éditer un patron de crochet                               |
| app_crochet_pattern_delete          | /crochet/pattern/{pattern_id}                              | Supprime un patron de crochet                                      |
| app_crochet_pattern_new             | /crochet/pattern/new/{collection_id}                       | Crée un nouveau patron de crochet dans la collection choisie       |
| app_login                           | /login                                                     | Affiche la page de connexion                                       |
| app_logout                          | /logout                                                    | Permet de se déconnecter                                           |
| app_member_index                    | /member                                                    | Liste des membres                                                  |
| app_member_show                     | /member/{member_id}                                        | Affiche un membre spécifique                                       |
| app_portfolio_index                 | /portfolio                                                 | Liste des portfolios                                               |
| app_portfolio_new                   | /portfolio/new                                             | Crée un nouveau portfolio                                          |
| app_portfolio_show                  | /portfolio/{portfolio_id}                                  | Affiche un portfolio spécifique                                    |
| app_portfolio_edit                  | /portfolio/{portfolio_id}/edit                             | Permet d'éditer un portfolio                                       |
| app_portfolio_delete                | /portfolio/{portfolio_id}                                  | Supprime un portfolio                                              |
| app_portfolio_crochet_pattern_show  | /portfolio/{portfolio_id}/crochet/pattern/{pattern_id}     | Affiche un patron de crochet dans un portfolio                     |
| app_pattern_collection_list         | /pattern/collection/list                                   | Liste des collections de patrons                                   |
| app_pattern_collection_show         | /pattern/collection/{collection_id}                        | Affiche une collection de patrons spécifique                       |

## Comptes déjà créés et leurs rôles

Il y a un seul compte ADMIN: zelia@localhost ; password1
Pour tester un compte USER: alizee@hlocalhost ; password2

## Attributs des entités

### Member

La classe PatternCollection représente un utilisateur. Voici les attributs utilisés :

| Attribut      | Type               | Description                                                         |
|---------------|--------------------|---------------------------------------------------------------------|
| id            | int                | Identifiant unique pour chaque membre.                              |
| email         | string             | Adresse email du membre.                                            |
| roles         | array              | Liste des rôles associés au membre (inclut `ROLE_USER` par défaut).  |
| password      | string             | Mot de passe du membre (utilisé pour l'authentification).           |
| patternCollection | object           | Collection de patrons associée au membre (un seul modèle par membre).|
| portfolios    | array              | Liste des portfolios associés au membre.                            |

Les rôles possibles pour les members sont: ROLE_ADMIN ET ROLE_USER.

### PatternCollection

La classe PatternCollection représente une collection de patrons de crochet. Voici les attributs utilisés :

| Attribut     | Type              | Description                                                      |
|--------------|-------------------|------------------------------------------------------------------|
| id           | int               | Identifiant unique pour chaque collection.                       |
| name         | string            | Nom de la collection.                                            |
| designer     | string            | Nom du designer de la collection.                                |
| patterns     | array             | Liste des modèles de crochet associés à la collection.           |
| dateCreated  | datetime          | Date de création de la collection.                               |
| totalPatterns| int               | Nombre total de modèles dans la collection.                      |


### CrochetPattern

La classe CrochetPattern représente un patron de crochet. Voici les attributs utilisés :

| Attribut          | Type               | Description                                                      |
|-------------------|--------------------|------------------------------------------------------------------|
| id                | int                | Identifiant unique pour chaque patron.                           |
| name              | string             | Nom du patron de crochet.                                        |
| hookSize          | float|null         | Taille du crochet utilisée pour le patron                        |
| category          | string             | Catégorie du patron.                                             |
| language          | string             | Langue du patron.                                                |
| image             | array              | Liste des images associées au patron.                            |
| patternCollection | object             | Collection de patrons associée (lié à `patternCollection`).      |
| portfolios        | array              | Liste des portfolios auxquels ce patron est associé.             |


### Portfolio

La classe CrochetPattern représente un portfolio de patrons. Voici les attributs utilisés :

| Attribut         | Type               | Description                                                       |
|------------------|--------------------|-------------------------------------------------------------------|
| id               | int                | Identifiant unique pour chaque portfolio.                         |
| name             | string             | Nom du portfolio.                                                 |
| member           | object (Member)    | Membre associé au portfolio (lié à l'entité `Member`).            |
| dateCreated      | datetime           | Date de création du portfolio (peut être nulle).                  |
| totalPatterns    | int                | Nombre total de patrons dans le portfolio                         |
| patterns         | array              | Liste des patrons associés au portfolio (relation ManyToMany).    |

## Technologies Utilisées

- Symfony : Framework PHP utilisé pour développer l'application.
- Doctrine : Outil ORM pour la gestion de la base de données.
- Twig : Moteur de templates pour la création de vues.
- Bootstrap: Framework CSS pour le design et la mise en page responsive.

## Créatrice

Alizée MESNARD



