<?php

namespace App\Entity;

class CardSet
{
    private array $cards = [];

    /**
     * Crée un jeu de X cartes mélangées
     * @param int $cardNumber
     * @return CardSet
     */
    public static function createShuffledCardSet(int $cardNumber): self
    {
        $cardSet = new self;
        $cardSet->fillCards($cardNumber);
        $cardSet->shuffle();
        return $cardSet;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function fillCards(int $cardNumber)
    {
        $this->cards = range(1, $cardNumber);
    }

    public function shuffle()
    {
        shuffle($this->cards);
    }
}
