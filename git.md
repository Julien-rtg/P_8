# UTILISATION DE GIT

# Création du compte git

> Se rendre sur ce lien : https://github.com/signup

# Télécharger gitbash

> Se rendre sur ce lien pour télécharger git :
> <https://gitforwindows.org/>

# Accéder et Cloner le projet

> Pour pouvoir accéder au projet il faudra fork le projet sur votre
> profil pour pouvoir y travailler dessus.
>
> Cliquez sur le bouton en haut à droite « Fork ».

![](vertopal_5155c0a5ca0b4fb9a051e72b7cd3190f/media/image1.png)
> Une fois gitbash installé, lancer le et diriger vous vers le dossier
> ou vous voulez cloner le projet.
>
> Cloner le projet avec la commande : git clone
> <https://github.com/Julien-rtg/P_8.git>
>
> Dans le cas ou vous voulez clonez le projet P_8 du profil Julien-rtg

# Modification du projet

## Création branche

> Avant d'envoyer les modifications il faut faire une branche pour
> indiquer dans quelle partie de l'application nous voulons faire nos
> modifications.
>
> Faites la commande git checkout -b « nom de la branche ».

## Envoi des modifications

> Une fois les modifications au projet réalisé.
>
> Faites un « git add . » pour ajouter tous les fichiers
>
> Faites un « git commit -m « message du commit » » pour sauvegarder les
> fichiers
>
> Faites un git push pour envoyer les fichiers sur le dossier distant.
>
> Remarque : Une fenêtre va s'ouvrir pour s'authentifier à votre compte
> si vous n'étiez pas déjà authentifié.

## Création pull request

> Rendez-vous sur la page <https://github.com/Julien-rtg/P_8/pulls> pour
> créer la pull request. Ou sur la page du repository et dans l'onglet
> pull request si c'est un autre projet.
>
> Cliquez sur « compare & pull request », ce sont les modifications que
> vous avez apportés au projet.
>
> ![](vertopal_5155c0a5ca0b4fb9a051e72b7cd3190f/media/image2.png)

Sur cette page nous avons en haut ces éléments

![](vertopal_5155c0a5ca0b4fb9a051e72b7cd3190f/media/image3.png)
> Base repository étant le repository ou vous avez clonez le projet de
> base.
>
> Base étant la branche sur laquelle vous voulez comparer vos
> changements
>
> Head repository étant le repository que vous avez fork sur votre
> profil
>
> Compare étant la branche sur laquelle vous avez fait les changements
>
> Vous voulez donc comparer les changements de votre projet fork au
> projet de base pour pouvoir créer la pull request.

Cliquez sur « Create pull request » pour créer la pull request

![](vertopal_5155c0a5ca0b4fb9a051e72b7cd3190f/media/image4.png)

Vous atterrissez sur cette page, cela signifie que la pull request à
bien été effectué.

![](vertopal_5155c0a5ca0b4fb9a051e72b7cd3190f/media/image5.png)
Maintenant du coté du propriétaire du repository de base, dans l'ongletpull request nous avons :

![](vertopal_5155c0a5ca0b4fb9a051e72b7cd3190f/media/image6.png)
En cliquant sur la pull request nous pouvons merge la pull request qui
nous permettra de rassembler les informations au projet de base

![](vertopal_5155c0a5ca0b4fb9a051e72b7cd3190f/media/image7.png)

# Règles à respecter

> Les règles à respecter lors de l'utilisation de git sont de :

-   Utiliser des branches lorsque vous voulez faire des changements au
    niveau du projet

-   Faire des messages les plus explicites au possible lors des commits
