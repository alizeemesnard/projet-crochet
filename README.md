# Application ‘Projet-Crochet’

## Description

Projet-Crochet est une application dédiée aux passionnés de crochet, permettant aux utilisateurs de gérer leur collection de modèles de crochet. Les membres peuvent créer des fiches détaillées pour chaque patron, gérer leur collection de patrons, et partager certains modèles avec la communauté via des galeries (bientôt disponible).

## Entités

- Inventaires = patternCollection (collection de patrons).
- Objets = CrochetPattern (patron de crochet).

## Attributs des entités

### PatternCollection

La classe PatternCollection représente une collection de patrons de crochet. Voici les attributs utilisés :

id: int - Identifiant unique pour chaque collection.
name: string - Nom de la collection.
designer: string - Nom du designer de la collection.
patterns: array - Liste des noms des patrons contenus dans la collection.
dateCreated: \DateTime - Date de création de la collection.
totalPatterns: int - Nombre total de patrons dans la collection.
CrochetPattern

### CrochetPattern

La classe CrochetPattern représente un patron de crochet. Voici les attributs utilisés :

id: int - Identifiant unique pour chaque patron.
Name: string - Titre du patron de crochet.
HookSize: float - Taille du crochet recommandé pour le patron.
Category: string - Catégorie du patron (ex: Jouets, Vêtements).
Language: string - Langue dans laquelle le patron est écrit.
Image: array - Tableau d'URL d'images représentant le patron.
Designer: string - Nom du designer du patron.

## Technologies Utilisées

- Symfony : Framework PHP utilisé pour développer l'application.
- Doctrine : Outil ORM pour la gestion de la base de données.
- Twig : Moteur de templates pour la création de vues.
- Bootstrap: Framework CSS pour le design et la mise en page responsive.
