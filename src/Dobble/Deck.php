<?php

namespace Marmelab\Dobble;

/**
 * @todo generate functions
 */
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
        if (!count($this)) {
            // The deck is empty
            return false;
        }

        if (count(array_unique($this->cards)) < count($this)) {
            // The deck has two or more identical cards
            return false;
        }

        $count_all_cards = array_map('count', $this->cards);
        if (count(array_unique($count_all_cards)) > 1) {
            // Cards do not have the same number of symbol
            return false;
        }

        return true;
    }
}
