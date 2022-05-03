<?php

namespace App\Entity;

class PlayerCardSet
{
    private array $cards = [];

    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function shiftCard(): void
    {
        array_shift($this->cards);
    }
}
