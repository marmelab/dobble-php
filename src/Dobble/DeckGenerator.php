<?php

namespace Marmelab\Dobble;

class DeckGenerator
{
    private $elementsPerCard = 0;

    public function __construct(int $elementPerCard)
    {
        if ($elementPerCard <= 0) {
            throw new \InvalidArgumentException();
        }

        $this->elementsPerCard = $elementPerCard;
    }

    private function getSymbol($index = 0)
    {
        return Card::getUniqueSymbols($index);
    }

    private function getSymbolRange($n, $index = 0)
    {
        $symbols = [];
        $i = $index;

        for (; $i < $index + $n; ++$i) {
            array_push($symbols, $this->getSymbol($i));
        }

        return $symbols;
    }

    private function buildCard($card)
    {
        return new Card($card);
    }

    private function buildDeck($cards)
    {
        $cleanedCards = [];
        foreach ($cards as $card) {
            array_push($cleanedCards, $this->buildCard($card));
        }

        return new Deck($cleanedCards);
    }

    public function generate()
    {
        $cards = [];

        // The first card is simple
        // It's the first range of symbols
        $cards[0] = $this->getSymbolRange($this->elementsPerCard);
        $currentIndex = $this->elementsPerCard;

        // For generating all other cards, we need to iterate over first card
        $i = 0;
        foreach ($cards[0] as $symbol) {
            $new_card = []; // Until challenged

            // We link all cards with the new with unique symbol
            foreach ($cards as $card) {
                array_push($new_card, $card[$i]);
            }

            // If and while the card has not enough symbol
            // We add it new unique symb
            while (count($new_card) < $this->elementsPerCard) {
                array_push($new_card, $this->getSymbol($currentIndex));
                ++$currentIndex;
            }

            // The card is ready to push in the deck
            $cards[$i + 1] = $new_card;
            ++$i;
        }

        return $this->buildDeck($cards);
    }
}
