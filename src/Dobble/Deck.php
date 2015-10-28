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

    /**
     * @todo All this function
     */
    public static function generate(int $elementsPerCard)
    {
        $cards = array(
            new Card(['A', 'B']),
            new Card(['B', 'C']),
            new Card(['C', 'A']),
        );

        return new self($cards);
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
        DeckValidator::validate($this);
    }
}
