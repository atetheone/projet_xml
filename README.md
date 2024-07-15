# Portail Web de Films et Restaurants

## Description

Ce projet est un portail web permettant de gérer et d'afficher des informations sur des films et des restaurants. Les données sont stockées dans des fichiers XML et sont conformes aux DTD spécifiées. Le portail permet à un administrateur de gérer les ressources (ajouter, modifier, supprimer des films et des fiches de restaurants) et à un visiteur de visualiser ces données.

## Fonctionnalités

- **Gestion des films :**
  - Ajout de films
  - Modification de films
  - Suppression de films
  - Affichage des films

- **Gestion des restaurants :**
  - Ajout de restaurants
  - Modification de restaurants
  - Suppression de restaurants
  - Affichage des restaurants

## Prérequis

- Serveur web (Apache, Nginx, etc.)
- PHP 5.3 ou supérieur
- Extensions PHP : SimpleXML

## Installation

1. Clonez le dépôt ou téléchargez les fichiers du projet.

```bash
git clone https://github.com/atetheone/projet_xml.git
```

2. Placez les fichiers du projet dans le répertoire racine de votre serveur web

3. Assurez-vous que le serveur web a les permissions de lecture et d'écriture sur les fichiers XML (`cinema.xml` et `restaurants.xml`).

## Structure des fichiers

- `index.php` : Page principale pour afficher les films et les restaurants.
- `ajout_film.php` : Script pour ajouter un film.
- `ajout_restaurant.php` : Script pour ajouter un restaurant.
- `cinema.xml` : Fichier XML contenant les données des films.
- `restaurants.xml` : Fichier XML contenant les données des restaurants.
- `restaurants.dtd` : DTD pour valider les fichiers XML des restaurants.
- `cinema.dtd` : DTD pour valider les fichiers XML des films.
- `README.md` : Ce fichier de documentation.

## Utilisation

### Affichage des films et des restaurants

Ouvrez `index.php` dans votre navigateur. Cette page affiche les films et les restaurants en lisant les données à partir des fichiers XML.

### Ajout de films

1. Ouvrez `ajout_film.php` dans votre navigateur.
2. Remplissez le formulaire d'ajout de film et soumettez-le.
3. Le film sera ajouté au fichier `films.xml` et apparaîtra sur la page principale.

### Ajout de restaurants

1. Ouvrez `ajout_restaurant.php` dans votre navigateur.
2. Remplissez le formulaire d'ajout de restaurant et soumettez-le.
3. Le restaurant sera ajouté au fichier `restaurants.xml` et apparaîtra sur la page principale.

### Modification et suppression

Pour le moment, les fonctionnalités de modification et de suppression doivent être implémentées de manière similaire aux fonctionnalités d'ajout. Vous pouvez créer des formulaires et des scripts PHP correspondants pour gérer ces opérations.

## Contributeurs

## Contributeurs

- [TOUGUE ARISTIDE ATE](https://github.com/atetheone) 
- [MAGUETTE NDIAYE](https://github.com/onlyMaguette)
- [BACAR IMANE](https://github.com/username3)
- [CATHY SADYKH DIAW](https://github.com/username4)
- [MAMYA SAMANE AIDARA](https://github.com/username4)
- [STECH CLARIN MOLINGUI](https://github.com/username4)


