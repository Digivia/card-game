<?php

namespace App\Entity;

class Player
{
    private string $name;
    private ?PlayerCardSet $cardSet;
    private int $score = 0;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCardSet(): ?PlayerCardSet
    {
        return $this->cardSet;
    }

    public function setCardSet(?PlayerCardSet $cardSet): void
    {
        $this->cardSet = $cardSet;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function incrementScore(): int
    {
        $this->score++;
        return $this->score;
    }
}
