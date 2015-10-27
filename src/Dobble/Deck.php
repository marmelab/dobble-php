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
            throw new DobbleException('The deck is empty');
        }

        if (count(array_unique($this->cards)) < count($this)) {
            throw new DobbleException('The deck has two or more identical cards.');
        }

        $countAllCards = array_map('count', $this->cards);
        if (count(array_unique($countAllCards)) > 1) {
            throw new DobbleException('Cards do not have different number of symbol');
        }

        return true;
    }
}
