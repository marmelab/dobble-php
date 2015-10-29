<?php

namespace Marmelab\Dobble;

class Deck implements \Countable
{
    private $cards = [];

    public function __construct(array $cards = [])
    {
        foreach ($cards as $card) {
            $this->append($card);
        }
    }

    public function __toString()
    {
        return sprintf('<DobbleDeck: [%s]>', implode(', ', $this->cards));
    }

    public function append(Card $card)
    {
        array_push($this->cards, $card);
    }

    public function getCards()
    {
        return $this->cards;
    }

    public function count()
    {
        return count($this->cards);
    }

    public function validate()
    {
        return DeckValidator::validate($this);
    }
}
