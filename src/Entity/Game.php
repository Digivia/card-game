<?php

namespace App\Entity;

class Game
{
    /** @var Player[] */
    private array $players;
    private int $turns;

    public function __construct(array $players, int $turns)
    {
        $this->players = $players;
        $this->turns = $turns;
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getTurns(): int
    {
        return $this->turns;
    }
}
