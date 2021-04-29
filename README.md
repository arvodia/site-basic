![EURL ARVODIA](/arvodia-logo-text.png)
# Rôle utilisateur
Un rôle définit les autorisations pour les utilisateurs d’effectuer un groupe de tâches. Ces rôles sont définis sur la page de modification de compte utilisateur. Les utilisateurs qui ne sont pas authentifiés ont le rôle Utilisateur anonyme. Les utilisateurs qui sont authentifiés ont le rôle Abonné.

>`Remarque` : En attribuant un rôle à un utilisateur il va lui permettre d’accéder a la partie back-office de site web.

## Contributeur :
 - il peut voir ces propre articles
 - il peut écrire, modifier et supprimer un article et ça traduction
 - il ne peut pas publier un article ou sa traduction
 - il ne peut pas modifier si le statut est publier ou refuser
 - il ne peut pas supprimer si le statut est publie

# SITE WEB Multilingue
ARVODIA Drupal Distribution est un profile d’installation du C.M.S drupal avec bootstrap comme framework d'interface.
### Table des matières
 * [Introduction](#introduction)
 * [Prérequis](#prérequis)
 * [Installing](#installing)
 * [Types d’installations](#types-dinstallations)
   * [Pack Basic](#pack-basic-)
   * [Pack Blog](#pack-blog-)
   * [Pack Pro](#pack-pro-)
 * [Git clone](#git-clone-)
 * [Contact](#contact-)
 * [Site Web](#site-web-)
 * [License](#license-)

## Introduction
Un profiles léger et rapide, simple, clé à la main et prêt à être utiliser.

## Prérequis
```
Un serveur web
Php 7 , +
Composer
Drupal Core '^8 || ^9'
```
## Installing

Télécharger l'archive dans le répertoire web root, et exécute la commande suivant

```
$ composer install
```

## Types d’installations

### Pack Basic : 
#### Téléchargement Gratuit

Des sites web équipés d’un désign responsive à faible contenu de diffusion avec :

    Cinque rubrique pour promouvoir les activités.
    Un formulaire de contact.
    Carrousel à trois images animées.
    Deux contenus latéraux avec possibilité de téléchargement de fichier PDF
    Partage avec d’autres medias externes.
    Un Back-office pour la modification de contenu publié, accessible par le rôle d’Administrateur de site.
    Multilingue (anglais, arabe, français)
    
### Pack Blog : 
#### disponible à la demande sur arvodia@hotmail.com

Des sites web équipés des fonctionnalités d’abonnement basic avec en plus une taille importante de contenu et une nouvelle rubrique Blog qui permet la publication d’article, mais aussi ;

    possibilité de s’inscrire pour commenter les articles.
    Un nouveau rôle modérateur avec les permissions de gestion de commenter et utilisation.
    Formulaire de contact pour les inscrits et pour tous les utilisateurs.

### Pack Pro : 
#### disponible à la demande sur arvodia@hotmail.com

Des sites web équipés des fonctionnalités d’abonnement Blog, avec en plus ;

    Ajout catégorie ou sous-catégorie pour la rubrique Blog.
    Le rôle Contributeur avec les permissions de proposer des articles.
    Le rôle auteur avec les permissions d’écrire et publier des articles.
    Le rôle Editorial avec les permissions de gestion des articles et rôles.

## Git clone :
```
$ git clone https://github.com/arvodia/site-basic.git
```

## Contact :
[arvodia@hotmail.com](mailto:arvodia@hotmail.com) - EURL ARVODIA

[contact@arvodia.com](mailto:contact@arvodia.com) - EURL ARVODIA

## Site Web :

https://www.arvodia.com

## License :
**Pack Basic** : GNU General Public License v3.0

**Pack Blog**  : All Rights Reserved

**Pack Pro**   : All Rights Reserved
