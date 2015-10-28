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
            new Card(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H']),
            new Card(['A', 'I', 'J', 'K', 'L', 'M', 'N', 'O']),
            new Card(['B', 'I', 'P', 'Q', 'R', 'S', 'T', 'U']),
            new Card(['C', 'J', 'P', 'V', 'W', 'X', 'Y', 'Z']),
            new Card(['D', 'K', 'Q', 'V', 1, 2, 3, 4]),
            new Card(['E', 'L', 'R', 'W', 1, 5, 6, 7]),
            new Card(['F', 'M', 'S', 'X', 2, 5, 8, 9]),
            new Card(['G', 'N', 'T', 'Y', 3, 6, 8, 10]),
            new Card(['H', 'O', 'U', 'Z', 4, 7, 9, 10]),
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
        return DeckValidator::validate($this);
    }
}
