# Simulation jeu de cartes (bataille) en CLI

## Objectif : créer un jeu en ligne de commandes

## Règles :
* 52 cartes, on simplifie en utilisant simplement des valeurs de 1 à 52
* les cartes sont mélangées et distribuées à 2 joueurs
* chaque joueur retourne la première carte de son paquet, le joueur disposant de la plus forte carte marque un point
* on continue jusqu'à ce qu'il n'y ait plus de carte à jouer
* on affiche le nom du vainqueur

###Aucune lib installée, partir from scratch.

## Utilisation :

Se placer dans le répertoire de l'application.
Afin de faciliter la gestion des namespaces, j'ai utilisé l'autoloading PSR-4 de composer.

Lancer : 
```
composer install
```

Puis lancer le jeu via la commande :
```
php index.php
```

Le jeu va alors présenter le résultat de chaque manche, puis le nom du gagnant à la fin.
En cas d'égalité, un message en rouge s'affiche indiquant qu'aucun gagnant n'a pu être déterminé. 

## Principes techniques :

Un builder se charge de créer le jeu et d'orchestrer l'hydratation des objets utilisés pour le jeu (dans App\Entity).
Ensuite, c'est un player qui prend le relai pour jouer les différentes manches et calculer le nom du gagnant.

