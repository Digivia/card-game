<?php

use App\Builder\GameBuilder;
use App\Exception\GameEqualityException;
use App\Exception\GameException;
use App\Exception\PlayerNotConformException;
use App\Player\GamePlayer;

include_once 'vendor/autoload.php';

// On check qu'on est bien en execution dans le contexte CLI
if ('cli' !== php_sapi_name()) {
   echo "<p style='color: red'>Cette page n'est pas accessible en mode web. Veuillez l'exécuter en ligne de commande via votre terminal :</p>";
   echo "<p style='background-color: black;color: white; padding: 20px'>php index.php</p>";
   exit;
}

// Just for fun...
$logo = "\e[032m⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
    ⠀⠀⠀⠀⠀⢠⠾⠻⠿⠿⠛⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣷⣆⠀⠀⠀⠀⠀
    ⠀⠀⠀⠀⠀⣯⠀⠀⠀⠀⠀⢨⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠀⠀⠀⠀⠀
    ⠀⠀⠀⠀⠀⣿⣷⣄⠀⠀⣠⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠀⠀⠀⠀⠀
    ⠀⠀⠀⠀⠀⣿⣿⣿⣷⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠀⠀⠀⠀⠀
    ⠀⠀⠀⠀⠀⣿⣿⣿⣿⣷⣶⠀⢰⣶⣿⣷⠆⣠⣴⣾⣿⣿⣿⣿⣿⠀⠀⠀⠀⠀
    ⠀⠀⠀⠀⠀⣿⣿⣿⣿⣿⣿⠀⢸⣿⡟⣡⣾⣿⣿⣿⣿⣿⣿⣿⣿⠀⠀⠀⠀⠀
    ⠀⠀⠀⠀⠀⣿⣿⣿⣿⣿⣿⠀⠸⣫⡄⠘⢿⣿⣿⣿⣿⣿⣿⣿⣿⠀⠀⠀⠀⠀
    ⠀⠀⠀⠀⠀⣿⣿⣿⣿⣿⣿⠀⢰⣿⣿⣆⠈⢻⣿⣿⣿⣿⣿⣿⣿⠀⠀⠀⠀⠀
    ⠀⠀⠀⠀⠀⣿⣿⣿⣿⡿⠿⠀⠸⠿⣿⡿⠧⠀⠙⠿⣿⣿⣿⣿⣿⠀⠀⠀⠀⠀
    ⠀⠀⠀⠀⠀⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⢿⣿⣿⣿⠀⠀⠀⠀⠀
    ⠀⠀⠀⠀⠀⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠋⠀⠀⠙⢿⣿⠀⠀⠀⠀⠀
    ⠀⠀⠀⠀⠀⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠃⠀⠀⠀⠀⠀⣻⠀⠀⠀⠀⠀
    ⠀⠀⠀⠀⠀⠘⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣷⣤⣶⣶⣦⡶⠏⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
    \n";
fwrite(STDOUT, $logo);

try {
    // On instancie un GameBuilder qui va créer une instance valide de Game
    $game = (new GameBuilder('Joueur 1', 'Joueur 2'))
        ->initGame()
        ->provideGame();
    // Le player se charge quant à lui de lancer et gérer le jeu
    $play = new GamePlayer($game);
    // On va boucler sur le nombre de tours calculé
    for ($turn=1; $turn <= $play->getGame()->getTurns(); $turn++) {
        // Une manche de jeu est jouée
        $winner = $play->play();
        fwrite(STDOUT, "\e[033m Manche {$turn}");
        fwrite(STDOUT, "\t {$winner->getName()} gagne \n");
    }
    // On calcule le gagnant du jeu
    $gameWinner = $play->calculateWinner();
    fwrite(
        STDOUT,
        sprintf(
            "\e[033m Gagnant de la partie : %s avec un score de %d manches gagnées",
            $gameWinner->getName(),
            $gameWinner->getScore()
        )
    );
} catch (PlayerNotConformException | GameEqualityException | GameException $e) {
    // Remontée des éventuelles erreurs (
    fwrite(STDOUT, "\e[031m {$e->getMessage()}");
}
