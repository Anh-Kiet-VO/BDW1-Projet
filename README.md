# BDW1 - Projet mini-Pinterest


## 📸 À propos :

Ceci est un projet réalisé dans le cadre de l'enseignement *BDW1* (Base de Données et Programmation Web) à l'université Claude Bernard Lyon 1, au printemps 2021. Ce projet consiste à développer une petite application web permettant à un utilisateur d'accéder et de manipuler le contenu d'une base de données de photos, elles-mêmes classées en différentes catégories. L'utilisateur pourra également se connecter sur l'application.

## 🌐 Comment accéder à l'application ? 

Pour accéder à l'application, il faut aller sur [cette page web](https://bdw1.univ-lyon1.fr/p1908025/mini-pinterest/index.php). Une fois dessus on demandera des identifiants, voici ceux que vous devrez rentrer :

* *Nom d'utilisateur* : p1908025
* *Mot de passe* : Switch57Spinal

## 💻 L'environnement de travail :

Le projet a été codé en **PHP** pour manipuler la base de données et en **HTML/CSS** pour afficher le site web.  

La base de données est schématisée de cette façon :
> Categorie(*catId*, nomCat)  
> Photo(*photoId*, nomFich, description, #catId, pseudo)
> Utilisateur(*pseudo*, mdp, etat, role)

## 🔖 Organisation de l'archive : 
```
css/
├─ Fichiers de style CSS
doc/
├─ Documentation du projet avec les consignes, la présentation, etc...
php/
├─ Fonctions php utilisées sur plusieurs pages
sql/
├─ Données initiales de notre base de données
README.md
ajouter.php
connexion.php
detail.php
index.php
inscription.php
profilAdmin.php
profilUtilisateur.php
```

## 📚 Documentations :
* Affichage de la galerie d'images de [manière responsive](https://masonry.desandro.com/) (index.php)
* Utilisation de la fonction [onClick](https://developer.mozilla.org/fr/docs/Web/API/GlobalEventHandlers/onclick) pour certains boutons
* [Bibliothèque d'icons (fontawesome)](https://fontawesome.com/)

## 👨‍🎓👩‍🎓 Étudiants : 

* Anh-Kiet VO (p1907921 - anh-kiet.vo@etu.univ-lyon1.fr)
* Cécilia NGUYEN (p1908025 - cecilia.nguyen@etu.univ-lyon1.fr)


