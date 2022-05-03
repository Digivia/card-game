<?php

namespace App\Player;

use App\Entity\Game;
use App\Entity\Player;
use App\Exception\GameEqualityException;
use App\Exception\GameException;
use App\Exception\PlayerNotConformException;

class GamePlayer
{
    private Game $game;

    /**
     * On reçoit ici une instance de jeu
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Joue une manche
     * @throws PlayerNotConformException
     */
    public function play(): Player
    {
        if (!count($this->game->getPlayers())) {
            throw new PlayerNotConformException("Aucun joueur n'a été ajouté. Veuillez en ajouter avant de jouer.");
        }
        $gameRoundCards = [];
        foreach ($this->game->getPlayers() as $id => $player) {
            // Carte courante du joueur
            $gameRoundCards[$id] = current($player->getCardSet()->getCards());
            // On lui dépile une carte
            $player->getCardSet()->shiftCard();
        }
        // Recherche de la carte la plus haute
        $highestId = array_search(max($gameRoundCards),$gameRoundCards);
        // On incrémente le score du gagnant de la manche
        $this->game->getPlayers()[$highestId]->incrementScore();
        return $this->game->getPlayers()[$highestId];
    }

    /**
     * Recherche le gagnant du jeu
     * @throws GameEqualityException
     * @throws GameException
     */
    public function calculateWinner(): Player
    {
        $scores = [];
        foreach ($this->game->getPlayers() as $id => $player) {
            $scores[$id] = $player->getScore();
        }
        // Tri des scores par ordre décroissant (en conservant les clés)
        arsort($scores);
        // On check s'il y a égalité : aucun gagnant !
        $this->checkScores($scores);
        // Le gagnant est celui qui a le score du premier élément du tableau des scores
        $winnerId = array_key_first($scores);
        if (null === $winnerId) {
            throw new GameException("Le gagnant n'a pas pu être calculé. Avez-vous bien lancé le jeu ?");
        }
        return $this->game->getPlayers()[$winnerId];
    }

    /**
     * @throws GameEqualityException
     */
    private function checkScores(array $rankedScores)
    {
        // Si on a le premier score le plus élevé équivalent au second le plus élevé, alors il y a égalité
        if (count($rankedScores) > 1 && $rankedScores[0] === $rankedScores[1]) {
            throw new GameEqualityException("Il y a égalité, donc aucun gagnant au jeu.");
        }
    }

    public function getGame(): Game
    {
        return $this->game;
    }
}
