<?php

namespace App\Builder;

use App\Entity\CardSet;
use App\Entity\Game;
use App\Entity\Player;
use App\Entity\PlayerCardSet;
use App\Exception\PlayerNotConformException;

class GameBuilder
{
    public const GAME_CARD_NUMBER = 52;

    /** @var Player[] */
    private array $players = [];

    private ?int $cardByPlayer = null;

    /**
     * @param string[] $playerNames
     */
    public function __construct(...$playerNames)
    {
        $this->addPlayers($playerNames);
    }

    /**
     * @param string[] $playerNames
     */
    public function addPlayers(array $playerNames)
    {
        foreach ($playerNames as $playerName) {
            $this->players[] = new Player($playerName);
        }
    }

    /**
     * @throws PlayerNotConformException
     */
    public function initGame(): self
    {
        // Nombre de cartes par joueur
        $this->cardByPlayer = $this->calculateGameCardNumberByPlayer();
        // Distribution de cartes mélangées à chaque joueur
        $this->distributeCards();
        return $this;
    }

    /**
     * Fournit une instance valide de jeu
     * @return Game
     */
    public function provideGame(): Game
    {
        return new Game($this->players, $this->cardByPlayer);
    }

    /**
     * Distribue les cartes entre les joueurs
     */
    private function distributeCards()
    {
        // Création du jeu de carte mélangé
        $cardSet = CardSet::createShuffledCardSet(self::GAME_CARD_NUMBER);
        // Distribution des cartes aux joueurs
        foreach ($this->players as $key => $player) {
            $playerCardSet = new PlayerCardSet(
                array_slice(
                    $cardSet->getCards(),
                    $key * $this->cardByPlayer,
                    $this->cardByPlayer
                )
            );
            // Le joueur a désormais son jeu de carte rempli
            $player->setCardSet($playerCardSet);
        }
    }

    /**
     * @throws PlayerNotConformException
     */
    private function calculateGameCardNumberByPlayer(): int
    {
        // On check le nombre de joueurs (on va éviter une division par zéro)
        if (!count($this->players)) {
            throw new PlayerNotConformException("Aucun joueur n'a été ajouté. Le jeu ne peut pas démarrer");
        }
        // Arrondi le nombre à l'entier inférieur
        return (int) floor(self::GAME_CARD_NUMBER / count($this->players));
    }
}
