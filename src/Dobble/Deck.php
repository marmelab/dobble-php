<?php

namespace Marmelab\Dobble;

/**
 * @todo validate & generate functions
 */
class Deck implements \Countable
{
    private $cards = [];

    public function __construct($cards = [])
    {
        if (!is_array($cards) && !$cards instanceof \Traversable) {
            throw new \InvalidArgumentException('Not a list of cards');
        }

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
}
